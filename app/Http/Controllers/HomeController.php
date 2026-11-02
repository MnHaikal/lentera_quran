<?php

namespace App\Http\Controllers;

use App\Models\Ayah;
use App\Models\Surah;
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

        return view('beranda', [
            'previewSurahs' => $previewSurahs,
            'dailyAyah' => $dailyAyah,
            'alKahf' => $alKahf,
            'totalSurahs' => Surah::count() ?: 114,
        ]);
    }
}
