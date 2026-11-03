<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case User = 'user';

    public const SUPER_ADMIN = self::SuperAdmin;
    public const ADMIN = self::Admin;
    public const USER = self::User;

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin => 'Admin',
            self::User => 'User',
        };
    }

    public function isAdmin(): bool
    {
        return $this === self::SuperAdmin || $this === self::Admin;
    }

    public function isSuperAdmin(): bool
    {
        return $this === self::SuperAdmin;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
