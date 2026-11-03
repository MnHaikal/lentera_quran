<?php

namespace App\Http\Controllers;

use App\Models\Ayah;
use App\Models\Bookmark;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\Surah;
use App\Models\TahlilItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $surahBookmarks = Bookmark::with('bookmarkable')
            ->where('user_id', $user->id)
            ->where('bookmarkable_type', 'surah')
            ->latest()
            ->get();

        $ayahBookmarks = Bookmark::with(['bookmarkable.surah'])
            ->where('user_id', $user->id)
            ->where('bookmarkable_type', 'ayah')
            ->latest()
            ->get();

        $tahlilBookmarks = Bookmark::with('bookmarkable')
            ->where('user_id', $user->id)
            ->where('bookmarkable_type', 'tahlil')
            ->latest()
            ->get();

        $tahlilBacaanBookmarks = Bookmark::with('bookmarkable')
            ->where('user_id', $user->id)
            ->where('bookmarkable_type', 'tahlil_bacaan')
            ->latest()
            ->get();

        $doaCategoryBookmarks = Bookmark::with(['bookmarkable' => static fn ($q) => $q->withCount('doas')])
            ->where('user_id', $user->id)
            ->where('bookmarkable_type', 'doa_category')
            ->latest()
            ->get();

        $doaBookmarks = Bookmark::with(['bookmarkable.doaCategory'])
            ->where('user_id', $user->id)
            ->where('bookmarkable_type', 'doa')
            ->latest()
            ->get();

        return view('bookmarks.index', [
            'surahBookmarks' => $surahBookmarks,
            'ayahBookmarks' => $ayahBookmarks,
            'tahlilBookmarks' => $tahlilBookmarks,
            'tahlilBacaanBookmarks' => $tahlilBacaanBookmarks,
            'doaCategoryBookmarks' => $doaCategoryBookmarks,
            'doaBookmarks' => $doaBookmarks,
        ]);
    }

    public function toggle(Request $request): JsonResponse
    {
        if (! auth()->check()) {
            return response()->json([
                'authenticated' => false,
                'redirect' => route('login'),
            ], 401);
        }

        $validated = $request->validate([
            'type' => ['required', 'string', 'in:surah,ayah,tahlil,tahlil_bacaan,doa,doa_category'],
            'id' => ['required', 'integer'],
        ]);

        $type = $validated['type'];
        $id = $validated['id'];
        $user = auth()->user();

        if ($type === 'surah') {
            $model = Surah::find($id);
            if (! $model) {
                return response()->json(['error' => 'Surah tidak ditemukan'], 404);
            }
        } elseif ($type === 'ayah') {
            $model = Ayah::find($id);
            if (! $model) {
                return response()->json(['error' => 'Ayat tidak ditemukan'], 404);
            }
        } elseif ($type === 'doa') {
            $model = Doa::find($id);
            if (! $model) {
                return response()->json(['error' => 'Doa tidak ditemukan'], 404);
            }
        } elseif ($type === 'doa_category') {
            $model = DoaCategory::find($id);
            if (! $model) {
                return response()->json(['error' => 'Kategori doa tidak ditemukan'], 404);
            }
        } elseif ($type === 'tahlil' || $type === 'tahlil_bacaan') {
            $model = TahlilItem::find($id);
            if (! $model) {
                return response()->json(['error' => 'Bacaan tahlil tidak ditemukan'], 404);
            }
        }

        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('bookmarkable_type', $type)
            ->where('bookmarkable_id', $id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();

            $removedMessage = match ($type) {
                'surah' => 'Surah dihapus dari favorit.',
                'tahlil' => 'Bacaan tahlil dihapus dari favorit.',
                'doa_category' => 'Kategori doa dihapus dari favorit.',
                'ayah' => 'Penanda ayat dihapus.',
                'tahlil_bacaan' => 'Penanda bacaan tahlil dihapus.',
                'doa' => 'Penanda doa dihapus.',
                default => 'Berhasil dihapus.',
            };

            return response()->json([
                'bookmarked' => false,
                'message' => $removedMessage,
            ]);
        }

        Bookmark::create([
            'user_id' => $user->id,
            'bookmarkable_type' => $type,
            'bookmarkable_id' => $id,
        ]);

        $addedMessage = match ($type) {
            'surah' => 'Surah berhasil ditambahkan ke favorit.',
            'tahlil' => 'Bacaan tahlil berhasil ditambahkan ke favorit.',
            'doa_category' => 'Kategori doa berhasil ditambahkan ke favorit.',
            'ayah' => 'Penanda ayat berhasil disimpan.',
            'tahlil_bacaan' => 'Penanda bacaan tahlil berhasil disimpan.',
            'doa' => 'Penanda doa berhasil disimpan.',
            default => 'Berhasil disimpan.',
        };

        return response()->json([
            'bookmarked' => true,
            'message' => $addedMessage,
        ]);
    }
}

