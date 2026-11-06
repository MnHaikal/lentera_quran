<?php

namespace App\Http\Controllers;

use App\Models\Ayah;
use App\Models\Bookmark;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\MurottalStreamLog;
use App\Models\Surah;
use Database\Seeders\DoaSeeder;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $previewSurahs = Surah::query()
            ->withMin('ayahs', 'juz')
            ->withMax('ayahs', 'juz')
            ->orderBy('id')
            ->take(12)
            ->get();

        $dailyAyah = Ayah::query()
            ->with('surah')
            ->where('surah_id', 2)
            ->where('nomor_ayat', 255)
            ->first();

        $alKahf = Surah::find(18);

        // Penanda ayat terakhir yang disimpan oleh user jika sudah login
        $latestAyahBookmark = null;
        $latestMurottal = null;

        if (auth()->check()) {
            $latestAyahBookmark = Bookmark::with(['bookmarkable.surah'])
                ->where('user_id', auth()->id())
                ->where('bookmarkable_type', 'ayah')
                ->latest()
                ->first();

            // Murottal terakhir yang didengarkan oleh user
            $latestLog = MurottalStreamLog::with('surah')
                ->where('user_id', auth()->id())
                ->latest()
                ->first();

            if ($latestLog && $latestLog->surah) {
                $ayah = null;
                if ($latestLog->ayah_number) {
                    $ayah = Ayah::where('surah_id', $latestLog->surah_id)
                        ->where('nomor_ayat', $latestLog->ayah_number)
                        ->first();
                }

                $audioUrl = $ayah?->audio_url ?: $latestLog->surah->audio_url;

                $latestMurottal = [
                    'surah' => $latestLog->surah,
                    'ayah' => $ayah,
                    'ayah_number' => $latestLog->ayah_number,
                    'audio_url' => $audioUrl,
                    'qari' => $latestLog->qari ?: config('quran.qari_name', 'Misyari Rasyid Al-Afasi'),
                    'is_from_log' => true,
                ];
            }
        }

        // Fallback murottal jika user belum memiliki riwayat pemutaran audio
        if (! $latestMurottal) {
            $fallbackAyah = $dailyAyah ?? Ayah::with('surah')->where('surah_id', 2)->where('nomor_ayat', 255)->first();
            if ($fallbackAyah) {
                $latestMurottal = [
                    'surah' => $fallbackAyah->surah,
                    'ayah' => $fallbackAyah,
                    'ayah_number' => $fallbackAyah->nomor_ayat,
                    'audio_url' => $fallbackAyah->audio_url,
                    'qari' => config('quran.qari_name', 'Misyari Rasyid Al-Afasi'),
                    'is_from_log' => false,
                ];
            }
        }

        // Surah Terfavorit (berdasarkan bookmark terbanyak atau surah utama pilihan)
        $favoriteSurahs = Surah::query()
            ->withCount(['bookmarks' => static fn ($q) => $q->where('bookmarkable_type', 'surah')])
            ->orderByDesc('bookmarks_count')
            ->orderByRaw('CASE WHEN id = 18 THEN 0 WHEN id = 36 THEN 1 WHEN id = 67 THEN 2 WHEN id = 1 THEN 3 ELSE 4 END')
            ->orderBy('id')
            ->take(4)
            ->get();

        // Pastikan seeder doa dijalankan jika belum ada data
        if (Doa::query()->count() === 0 || DoaCategory::query()->count() === 0) {
            app(DoaSeeder::class)->run();
        }

        // Doa-Doa Terfavorit (berdasarkan bookmark terbanyak atau doa mustajab pilihan)
        $favoriteDoas = Doa::query()
            ->published()
            ->with('doaCategory')
            ->withCount(['bookmarks' => static fn ($q) => $q->where('bookmarkable_type', 'doa')])
            ->orderByDesc('bookmarks_count')
            ->orderBy('id')
            ->take(4)
            ->get();

        return view('beranda', [
            'previewSurahs' => $previewSurahs,
            'dailyAyah' => $dailyAyah,
            'alKahf' => $alKahf,
            'totalSurahs' => Surah::count() ?: 114,
            'latestAyahBookmark' => $latestAyahBookmark,
            'latestMurottal' => $latestMurottal,
            'favoriteSurahs' => $favoriteSurahs,
            'favoriteDoas' => $favoriteDoas,
        ]);
    }
}
