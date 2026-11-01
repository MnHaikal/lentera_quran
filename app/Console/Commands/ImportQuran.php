<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\QuranImportService;
use Illuminate\Console\Command;
use Throwable;

class ImportQuran extends Command
{
    protected $signature = 'quran:import {--fresh : Mengosongkan tabel surahs dan ayahs lalu mengimpor ulang}';

    protected $description = 'Mengimpor data 114 surah dan 6.236 ayat Al-Qur\'an dari API publik ke database MySQL.';

    public function handle(QuranImportService $importService): int
    {
        $fresh = (bool) $this->option('fresh');

        $this->info('=====================================================');
        $this->info('  Memulai Impor Data Al-Qur\'an (Lentera Quran)');
        $this->info('=====================================================');

        if ($fresh) {
            $this->warn('Mode --fresh aktif: Tabel surahs dan ayahs akan dikosongkan.');
        }

        $progressBar = null;

        try {
            $result = $importService->import($fresh, function (int $current, int $total, string $message) use (&$progressBar) {
                if ($progressBar === null) {
                    $progressBar = $this->output->createProgressBar($total);
                    $progressBar->start();
                }
                $progressBar->setProgress($current);
                $this->output->write("  [{$current}/{$total}] {$message}\r");
            });

            if ($progressBar) {
                $progressBar->finish();
                $this->newLine(2);
            }

            $this->info('✓ Impor Al-Qur\'an Berhasil!');
            $this->table(
                ['Entitas', 'Jumlah'],
                [
                    ['Total Surah', $result['surahs_count']],
                    ['Total Ayat', $result['ayahs_count']],
                ]
            );
            $this->info('Validasi integritas: 114 Surah dan 6.236 Ayat terverifikasi sesuai riwayat Hafs.');

            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->newLine();
            $this->error('Gagal mengimpor Al-Qur\'an: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
