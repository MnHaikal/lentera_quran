<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogAuthenticationFailure
{
    public function handleFailed(Failed $event): void
    {
        $email = is_string($event->credentials['email'] ?? null)
            ? $event->credentials['email']
            : '';

        Log::warning('Percobaan login gagal.', [
            'guard' => $event->guard,
            'email' => self::maskEmail($email),
            'ip' => request()->ip(),
        ]);
    }

    public function handleLockout(Lockout $event): void
    {
        $email = is_string($event->request->input('email'))
            ? $event->request->input('email')
            : '';

        Log::warning('Percobaan login dikunci karena melebihi batas laju.', [
            'email' => self::maskEmail($email),
            'ip' => $event->request->ip(),
        ]);
    }

    public static function maskEmail(string $email): string
    {
        $normalized = Str::lower(trim($email));

        if ($normalized === '' || ! str_contains($normalized, '@')) {
            return '***';
        }

        [$local, $domain] = explode('@', $normalized, 2);
        $length = Str::length($local);

        $maskedLocal = match (true) {
            $length <= 1 => '*',
            $length === 2 => Str::substr($local, 0, 1).'*',
            default => Str::substr($local, 0, 1).str_repeat('*', min($length - 2, 5)).Str::substr($local, -1),
        };

        return $maskedLocal.'@'.$domain;
    }
}

