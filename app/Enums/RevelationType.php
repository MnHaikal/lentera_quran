<?php

declare(strict_types=1);

namespace App\Enums;

enum RevelationType: string
{
    case MEKAH = 'mekah';
    case MADINAH = 'madinah';

    public function label(): string
    {
        return match ($this) {
            self::MEKAH => 'Makkiyah',
            self::MADINAH => 'Madaniyah',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

