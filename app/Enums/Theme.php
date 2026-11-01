<?php

declare(strict_types=1);

namespace App\Enums;

enum Theme: string
{
    case TERANG = 'terang';
    case GELAP = 'gelap';
    case SISTEM = 'sistem';

    public function label(): string
    {
        return match ($this) {
            self::TERANG => 'Terang',
            self::GELAP => 'Gelap',
            self::SISTEM => 'Mengikuti Sistem',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

