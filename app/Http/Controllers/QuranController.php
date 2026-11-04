<?php

namespace App\Http\Controllers;

use App\Models\Ayah;
use App\Models\MurottalStreamLog;
use App\Models\Surah;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuranController extends Controller
{
    public function index(Request $request): View
    {
        $filter = (string) $request->query('filter', 'semua');
        $juz = $request->integer('juz');
        $search = trim((string) $request->query('q', ''));
        $sort = $request->query('sort') === 'desc' ? 'desc' : 'asc';

        $query = Surah::query()
            ->withMin('ayahs', 'juz')
            ->withMax('ayahs', 'juz');

        $this->applySurahFilters($query, $filter, $juz, $search);

        $surahs = $query
            ->orderBy('id', $sort)
            ->paginate(24)
            ->withQueryString();

        $favoritedSurahIds = auth()->check()
            ? auth()->user()->bookmarks()->where('bookmarkable_type', 'surah')->pluck('bookmarkable_id')->all()
            : [];

        return view('quran.index', [
            'surahs' => $surahs,
            'favoritedSurahIds' => $favoritedSurahIds,
            'activeFilter' => $filter,
            'activeJuz' => $juz > 0 ? $juz : null,
            'searchQuery' => $search,
            'sortDirection' => $sort,
            'totalSurahCount' => Surah::count() ?: 114,
            'totalAyahCount' => Ayah::count() ?: 6236,
            'juzAmmaCount' => Surah::where('id', '>=', 78)->count() ?: 37,
            'makkiyahCount' => Surah::where('tempat_turun', 'mekah')->count() ?: 86,
            'madaniyahCount' => Surah::where('tempat_turun', 'madinah')->count() ?: 28,
        ]);
    }

    public function show(Request $request, Surah $surah): View
    {
        $perPage = 20;
        $targetAyahNumber = $request->integer('ayat');
        $currentPage = $request->integer('page', 1);

        if ($targetAyahNumber > 0 && ! $request->has('page')) {
            $currentPage = (int) ceil(min($targetAyahNumber, $surah->jumlah_ayat) / $perPage);
        }

        $ayahs = $surah->ayahs()
            ->paginate($perPage, ['*'], 'page', max(1, $currentPage))
            ->withQueryString();

        $minJuz = (int) ($surah->ayahs()->min('juz') ?: 1);
        $maxJuz = (int) ($surah->ayahs()->max('juz') ?: $minJuz);
        $juzRangeLabel = $minJuz === $maxJuz ? "Juz {$minJuz}" : "Juz {$minJuz}–{$maxJuz}";

        $featuredAyah = $surah->id === 2
            ? $surah->ayahs()->where('nomor_ayat', 255)->first()
            : null;

        $bookmarkedAyahIds = auth()->check()
            ? auth()->user()->bookmarks()
                ->where('bookmarkable_type', 'ayah')
                ->whereIn('bookmarkable_id', $ayahs->pluck('id'))
                ->pluck('bookmarkable_id')
                ->all()
            : [];

        $isSurahFavorited = auth()->check()
            ? auth()->user()->bookmarks()
                ->where('bookmarkable_type', 'surah')
                ->where('bookmarkable_id', $surah->id)
                ->exists()
            : false;

        return view('quran.show', [
            'surah' => $surah,
            'ayahs' => $ayahs,
            'bookmarkedAyahIds' => $bookmarkedAyahIds,
            'isSurahFavorited' => $isSurahFavorited,
            'minJuz' => $minJuz,
            'maxJuz' => $maxJuz,
            'juzRangeLabel' => $juzRangeLabel,
            'targetAyahNumber' => $targetAyahNumber > 0 ? $targetAyahNumber : null,
            'featuredAyah' => $featuredAyah,
            'previousSurah' => Surah::find($surah->id - 1),
            'nextSurah' => Surah::find($surah->id + 1),
        ]);
    }

    public function audioTrack(Request $request): JsonResponse
    {
        $surahId = $request->integer('surah');
        $ayahNumber = $request->has('ayat') && $request->filled('ayat') ? $request->integer('ayat') : null;

        if ($surahId < 1 || $surahId > 114) {
            return response()->json(['error' => 'Surah tidak valid'], 404);
        }

        $surah = Surah::find($surahId);
        if (! $surah) {
            return response()->json(['error' => 'Surah tidak ditemukan'], 404);
        }

        if ($ayahNumber !== null) {
            if ($ayahNumber < 1 || $ayahNumber > $surah->jumlah_ayat) {
                return response()->json(['error' => 'Ayat tidak valid untuk surah ini'], 404);
            }

            $ayah = $surah->ayahs()->where('nomor_ayat', $ayahNumber)->first();
            if (! $ayah || ! $ayah->audio_url) {
                return response()->json(['error' => 'Audio ayat tidak tersedia'], 404);
            }

            return response()->json([
                'surahId' => $surah->id,
                'surahName' => $surah->nama_latin,
                'ayahNumber' => $ayah->nomor_ayat,
                'totalAyat' => $surah->jumlah_ayat,
                'src' => $ayah->audio_url,
                'qariName' => config('quran.qari_name', 'Misyari Rasyid Al-Afasi'),
            ]);
        }

        if (! $surah->audio_url) {
            return response()->json(['error' => 'Audio surah tidak tersedia'], 404);
        }

        return response()->json([
            'surahId' => $surah->id,
            'surahName' => $surah->nama_latin,
            'ayahNumber' => null,
            'totalAyat' => $surah->jumlah_ayat,
            'src' => $surah->audio_url,
            'qariName' => config('quran.qari_name', 'Misyari Rasyid Al-Afasi'),
        ]);
    }

    public function recordStreamPing(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'surah_id' => 'required|integer|min:1|max:114',
            'ayah_number' => 'nullable|integer',
            'duration_seconds' => 'required|integer|min:1|max:3600',
            'qari' => 'nullable|string|max:100',
        ]);

        $log = MurottalStreamLog::create([
            'user_id' => auth()->id(),
            'surah_id' => $validated['surah_id'],
            'ayah_number' => $validated['ayah_number'] ?? null,
            'duration_seconds' => $validated['duration_seconds'],
            'qari' => $validated['qari'] ?? config('quran.qari_name', 'Misyari Rasyid Al-Afasi'),
        ]);

        return response()->json(['success' => true, 'id' => $log->id]);
    }

    private function applySurahFilters(Builder $query, string $filter, int $juz, string $search): void
    {
        if ($filter === 'juz-amma') {
            $query->where('id', '>=', 78);
        } elseif ($filter === 'mekah') {
            $query->where('tempat_turun', 'mekah');
        } elseif ($filter === 'madinah') {
            $query->where('tempat_turun', 'madinah');
        }

        if ($juz >= 1 && $juz <= 30) {
            $query->whereHas('ayahs', fn (Builder $ayahQuery) => $ayahQuery->where('juz', $juz));
        }

        if ($search !== '') {
            $query->where(function (Builder $subQuery) use ($search): void {
                $subQuery->where('nama_latin', 'like', "%{$search}%")
                    ->orWhere('arti', 'like', "%{$search}%");

                if (ctype_digit($search)) {
                    $subQuery->orWhere('id', (int) $search);
                }
            });
        }
    }
}
