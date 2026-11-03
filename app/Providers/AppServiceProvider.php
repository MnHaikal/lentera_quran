<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Ayah;
use App\Models\Doa;
use App\Models\Surah;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'surah' => Surah::class,
            'ayah' => Ayah::class,
            'doa' => Doa::class,
            'user' => User::class,
        ]);

        Password::defaults(function () {
            $rule = Password::min(8)->max(64);

            return $this->app->isProduction()
                ? $rule->uncompromised()
                : $rule;
        });

        RateLimiter::for('register', function (Request $request): Limit {
            return Limit::perMinute(5)->by('register|'.$request->ip());
        });

        RateLimiter::for('password-reset', function (Request $request): array {
            $email = Str::lower(trim((string) $request->input('email', '')));

            return [
                Limit::perMinute(5)->by('password-reset-ip|'.$request->ip()),
                Limit::perMinute(3)->by('password-reset-email|'.$email.'|'.$request->ip()),
            ];
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token): MailMessage {
            $appName = config('app.name', 'Lentera Quran');
            $expireMinutes = config('auth.passwords.'.config('auth.defaults.passwords').'.expire', 60);
            $resetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject("Atur Ulang Kata Sandi - {$appName}")
                ->greeting('Assalamu\'alaikum, '.($notifiable->name ?? 'Sahabat Tilawah'))
                ->line("Kami menerima permintaan untuk mengatur ulang kata sandi akun {$appName} Anda.")
                ->action('Atur Ulang Kata Sandi', $resetUrl)
                ->line("Tautan pengaturan ulang kata sandi ini berlaku selama {$expireMinutes} menit.")
                ->line('Jika Anda tidak merasa melakukan permintaan ini, abaikan surel ini. Kata sandi akun Anda tidak akan berubah.')
                ->salutation("Salam hangat, Tim {$appName}");
        });
    }
}
