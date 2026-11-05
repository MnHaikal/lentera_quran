<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $token
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        $fromAddress = config('mail.from.address', 'mramayusuf3@gmail.com');
        $fromName = config('mail.from.name', 'Lentera Quran');
        $expireMinutes = (int) config('auth.passwords.users.expire', 60);

        return (new MailMessage)
            ->from($fromAddress, $fromName)
            ->subject('Atur Ulang Kata Sandi Akun - Lentera Quran')
            ->view('emails.reset-password', [
                'name' => $notifiable->name ?? 'Sahabat Lentera Quran',
                'url' => $url,
                'count' => $expireMinutes,
            ])
            ->text('emails.reset-password-text', [
                'name' => $notifiable->name ?? 'Sahabat Lentera Quran',
                'url' => $url,
                'count' => $expireMinutes,
            ]);
    }
}

