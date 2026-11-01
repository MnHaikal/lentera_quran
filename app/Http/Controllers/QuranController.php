<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\BookmarkType;
use App\Models\Ayah;
use App\Models\Bookmark;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class QuranController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $juz = $request->query('juz');
        $tempat = $request->query('tempat');

        $allSurahs = Cache::rememberForever('surahs.all', function () {
            return Surah::orderBy('id')->get();
        });

        $surahs = $allSurahs;

        if ($q !== '') {
            $surahs = $surahs->filter(function (Surah $surah) use ($q) {
                return str_contains(strtolower($surah->nama_latin), strtolower($q))
                    || str_contains(strtolower($surah->arti), strtolower($q))
                    || str_contains($surah->nama_arab, $q)
                    || (string) $surah->id === $q;
            });
        }

        if (!empty($tempat) && in_array(strtolower($tempat), ['mekah', 'madinah'], true)) {
            $surahs = $surahs->filter(function (Surah $surah) use ($tempat) {
                return $surah->tempat_turun->value === strtolower($tempat);
            });
        }

        if (!empty($juz) && is_numeric($juz)) {
            $juzNum = (int) $juz;
            if ($juzNum >= 1 && $juzNum <= 30) {
                $surahIdsInJuz = Cache::remember("surahs.juz.{$juzNum}", 86400, function () use ($juzNum) {
                    return Ayah::where('juz', $juzNum)->distinct()->pluck('surah_id')->toArray();
                });

                $surahs = $surahs->filter(function (Surah $surah) use ($surahIdsInJuz) {
                    return in_array($surah->id, $surahIdsInJuz, true);
                });
            }
        }

        return view('quran.index', [
            'surahs' => $surahs,
            'q' => $q,
            'selectedJuz' => $juz,
            'selectedTempat' => $tempat,
            'isJuzAmma' => false,
        ]);
    }

    public function juzAmma(): View
    {
        $surahs = Cache::rememberForever('surahs.juz_amma', function () {
            return Surah::juzAmma()->orderBy('id')->get();
        });

        return view('quran.index', [
            'surahs' => $surahs,
            'q' => '',
            'selectedJuz' => '30',
            'selectedTempat' => '',
            'isJuzAmma' => true,
        ]);
    }

    public function show(int $surahNumber, Request $request): View
    {
        abort_if($surahNumber < 1 || $surahNumber > 114, 404, 'Surah tidak ditemukan (nomor harus 1 - 114).');

        $surah = Surah::with(['ayahs' => function ($query) {
            $query->orderBy('nomor_ayat', 'asc');
        }])->findOrFail($surahNumber);

        $prevSurah = $surahNumber > 1 ? Surah::find($surahNumber - 1) : null;
        $nextSurah = $surahNumber < 114 ? Surah::find($surahNumber + 1) : null;

        $targetAyat = $request->query('ayat');

        $isSurahBookmarked = false;
        $bookmarkedAyahIds = [];

        if ($request->user()) {
            $isSurahBookmarked = Bookmark::where('user_id', $request->user()->id)
                ->where('bookmarkable_type', BookmarkType::SURAH->value)
                ->where('bookmarkable_id', $surah->id)
                ->exists();

            $bookmarkedAyahIds = Bookmark::where('user_id', $request->user()->id)
                ->where('bookmarkable_type', BookmarkType::AYAH->value)
                ->whereIn('bookmarkable_id', $surah->ayahs->pluck('id'))
                ->pluck('bookmarkable_id')
                ->toArray();
        }

        return view('quran.show', compact(
            'surah',
            'prevSurah',
            'nextSurah',
            'targetAyat',
            'isSurahBookmarked',
            'bookmarkedAyahIds'
        ));
    }
}
