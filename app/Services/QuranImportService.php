<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RevelationType;
use App\Models\Ayah;
use App\Models\Surah;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class QuranImportService
{
    public function __construct(
        private readonly QuranApiClient $apiClient
    ) {}

    public function import(bool $fresh = false, ?callable $progressCallback = null): array
    {
        if ($fresh) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Ayah::truncate();
            Surah::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $juzBoundaries = $this->apiClient->getJuzBoundaries();
        $surahList = $this->apiClient->getSurahList();

        $totalSurahs = count($surahList);
        $importedAyahsCount = 0;

        foreach ($surahList as $index => $surahSummary) {
            $surahNumber = (int) $surahSummary['nomor'];

            if ($progressCallback) {
                $progressCallback($index + 1, $totalSurahs, "Mengimpor Surah {$surahNumber}: {$surahSummary['namaLatin']}");
            }

            $surahDetail = $this->apiClient->getSurahDetail($surahNumber);

            usleep(100000);

            $audioFull = $surahDetail['audioFull'] ?? [];
            $surahAudioUrl = $audioFull['05'] ?? (is_array($audioFull) && count($audioFull) > 0 ? reset($audioFull) : null);

            DB::transaction(function () use ($surahDetail, $surahNumber, $surahAudioUrl, $juzBoundaries, &$importedAyahsCount) {
                $tempatTurun = strtolower((string) ($surahDetail['tempatTurun'] ?? 'mekah'));
                $revelationEnum = $tempatTurun === 'madinah' ? RevelationType::MADINAH : RevelationType::MEKAH;

                Surah::updateOrCreate(
                    ['id' => $surahNumber],
                    [
                        'nama_arab' => $surahDetail['nama'],
                        'nama_latin' => $surahDetail['namaLatin'],
                        'arti' => $surahDetail['arti'],
                        'jumlah_ayat' => (int) $surahDetail['jumlahAyat'],
                        'tempat_turun' => $revelationEnum,
                        'deskripsi' => $surahDetail['deskripsi'] ?? null,
                        'audio_url' => $surahAudioUrl,
                    ]
                );

                $ayahsData = $surahDetail['ayat'] ?? [];
                foreach ($ayahsData as $ayahItem) {
                    $nomorAyat = (int) $ayahItem['nomorAyat'];
                    $juzNumber = $this->resolveJuzNumber($surahNumber, $nomorAyat, $juzBoundaries);

                    $ayahAudioList = $ayahItem['audio'] ?? [];
                    $ayahAudioUrl = $ayahAudioList['05'] ?? (is_array($ayahAudioList) && count($ayahAudioList) > 0 ? reset($ayahAudioList) : null);

                    Ayah::updateOrCreate(
                        [
                            'surah_id' => $surahNumber,
                            'nomor_ayat' => $nomorAyat,
                        ],
                        [
                            'teks_arab' => $ayahItem['teksArab'],
                            'teks_latin' => $ayahItem['teksLatin'],
                            'terjemahan' => $ayahItem['teksIndonesia'],
                            'juz' => $juzNumber,
                            'halaman' => null,
                            'audio_url' => $ayahAudioUrl,
                        ]
                    );

                    $importedAyahsCount++;
                }
            });
        }

        $this->validateImportResults();

        return [
            'surahs_count' => Surah::count(),
            'ayahs_count' => Ayah::count(),
        ];
    }

    public function resolveJuzNumber(int $surahNumber, int $ayahNumber, array $juzBoundaries): int
    {
        for ($juz = 30; $juz >= 1; $juz--) {
            if (!isset($juzBoundaries[$juz])) {
                continue;
            }

            $startSurah = $juzBoundaries[$juz]['surah'];
            $startAyah = $juzBoundaries[$juz]['ayah'];

            if ($surahNumber > $startSurah || ($surahNumber === $startSurah && $ayahNumber >= $startAyah)) {
                return $juz;
            }
        }

        return 1;
    }

    public function validateImportResults(): void
    {
        $surahCount = Surah::count();
        if ($surahCount !== 114) {
            throw new RuntimeException("Validasi gagal: Ditemukan {$surahCount} surah (seharusnya 114).");
        }

        $ayahCount = Ayah::count();
        if ($ayahCount !== 6236) {
            throw new RuntimeException("Validasi gagal: Total ayat adalah {$ayahCount} (seharusnya 6.236 ayat riwayat Hafs).");
        }

        $surahs = Surah::withCount('ayahs')->get();
        foreach ($surahs as $surah) {
            if ($surah->ayahs_count !== $surah->jumlah_ayat) {
                throw new RuntimeException(
                    "Validasi gagal pada Surah {$surah->id} ({$surah->nama_latin}): " .
                    "Jumlah ayat di database ({$surah->ayahs_count}) tidak sesuai jumlah_ayat ({$surah->jumlah_ayat})."
                );
            }
        }
    }
}
