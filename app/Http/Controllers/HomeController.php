<?php

namespace App\Http\Controllers;

use App\Models\Ayah;
use App\Models\Bookmark;
use App\Models\Doa;
use App\Models\DoaCategory;
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

        $lastRead = auth()->check()
            ? auth()->user()->lastRead()->with(['surah', 'ayah'])->first()
            : null;

        // Penanda ayat terakhir yang disimpan oleh user jika sudah login
        $latestAyahBookmark = null;
        if (auth()->check()) {
            $latestAyahBookmark = Bookmark::with(['bookmarkable.surah'])
                ->where('user_id', auth()->id())
                ->where('bookmarkable_type', 'ayah')
                ->latest()
                ->first();
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
            'lastRead' => $lastRead,
            'latestAyahBookmark' => $latestAyahBookmark,
            'favoriteSurahs' => $favoriteSurahs,
            'favoriteDoas' => $favoriteDoas,
        ]);
    }
}
