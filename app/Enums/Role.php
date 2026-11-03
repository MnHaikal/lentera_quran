<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case USER = 'user';

    public const SuperAdmin = self::SUPER_ADMIN;
    public const Admin = self::ADMIN;
    public const User = self::USER;

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::USER => 'User',
        };
    }

    public function isAdmin(): bool
    {
        return $this === self::ADMIN || $this === self::SUPER_ADMIN;
    }

    public function isSuperAdmin(): bool
    {
        return $this === self::SUPER_ADMIN;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

