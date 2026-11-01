<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class QuranApiClient
{
    private const EQURAN_BASE_URL = 'https://equran.id/api/v2';
    private const ALQURAN_CLOUD_BASE_URL = 'https://api.alquran.cloud/v1';

    public const DEFAULT_JUZ_BOUNDARIES = [
        1  => ['surah' => 1,  'ayah' => 1],
        2  => ['surah' => 2,  'ayah' => 142],
        3  => ['surah' => 2,  'ayah' => 253],
        4  => ['surah' => 3,  'ayah' => 93],
        5  => ['surah' => 4,  'ayah' => 24],
        6  => ['surah' => 4,  'ayah' => 148],
        7  => ['surah' => 5,  'ayah' => 82],
        8  => ['surah' => 6,  'ayah' => 111],
        9  => ['surah' => 7,  'ayah' => 88],
        10 => ['surah' => 8,  'ayah' => 41],
        11 => ['surah' => 9,  'ayah' => 93],
        12 => ['surah' => 11, 'ayah' => 6],
        13 => ['surah' => 12, 'ayah' => 53],
        14 => ['surah' => 15, 'ayah' => 1],
        15 => ['surah' => 17, 'ayah' => 1],
        16 => ['surah' => 18, 'ayah' => 75],
        17 => ['surah' => 21, 'ayah' => 1],
        18 => ['surah' => 23, 'ayah' => 1],
        19 => ['surah' => 25, 'ayah' => 21],
        20 => ['surah' => 27, 'ayah' => 56],
        21 => ['surah' => 29, 'ayah' => 46],
        22 => ['surah' => 33, 'ayah' => 31],
        23 => ['surah' => 36, 'ayah' => 28],
        24 => ['surah' => 39, 'ayah' => 32],
        25 => ['surah' => 41, 'ayah' => 47],
        26 => ['surah' => 46, 'ayah' => 1],
        27 => ['surah' => 51, 'ayah' => 31],
        28 => ['surah' => 58, 'ayah' => 1],
        29 => ['surah' => 67, 'ayah' => 1],
        30 => ['surah' => 78, 'ayah' => 1],
    ];

    public function getSurahList(): array
    {
        try {
            $response = Http::timeout(20)
                ->retry(3, 200)
                ->get(self::EQURAN_BASE_URL . '/surat');

            if ($response->successful()) {
                $data = $response->json('data');
                if (is_array($data) && count($data) === 114) {
                    return $data;
                }
            }
        } catch (\Throwable $e) {
        }

        $fallback = Http::timeout(20)
            ->retry(3, 200)
            ->get(self::ALQURAN_CLOUD_BASE_URL . '/surah');

        if ($fallback->successful()) {
            return $fallback->json('data') ?? [];
        }

        throw new RuntimeException('Gagal mengambil daftar surah dari EQuran.id dan Al-Quran Cloud API.');
    }

    public function getSurahDetail(int $surahNumber): array
    {
        $response = Http::timeout(25)
            ->retry(3, 250)
            ->get(self::EQURAN_BASE_URL . "/surat/{$surahNumber}");

        if ($response->successful()) {
            $data = $response->json('data');
            if (is_array($data)) {
                return $data;
            }
        }

        throw new RuntimeException("Gagal mengambil detail surah nomor {$surahNumber} dari API.");
    }

    public function getJuzBoundaries(): array
    {
        try {
            $response = Http::timeout(10)->get(self::ALQURAN_CLOUD_BASE_URL . '/meta');
            if ($response->successful()) {
                $refs = $response->json('data.juzs.references');
                if (is_array($refs) && count($refs) === 30) {
                    $boundaries = [];
                    foreach ($refs as $idx => $ref) {
                        $boundaries[$idx + 1] = [
                            'surah' => (int) $ref['surah'],
                            'ayah' => (int) $ref['ayah'],
                        ];
                    }
                    return $boundaries;
                }
            }
        } catch (\Throwable $e) {
        }

        return self::DEFAULT_JUZ_BOUNDARIES;
    }
}
