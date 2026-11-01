<?php

declare(strict_types=1);

namespace App\Enums;

enum BookmarkType: string
{
    case SURAH = 'surah';
    case AYAH = 'ayah';
    case DOA = 'doa';

    public function label(): string
    {
        return match ($this) {
            self::SURAH => 'Surah',
            self::AYAH => 'Ayat',
            self::DOA => 'Doa',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

