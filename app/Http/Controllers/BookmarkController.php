<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\BookmarkType;
use App\Models\Ayah;
use App\Models\Bookmark;
use App\Models\Doa;
use App\Services\BookmarkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    public function __construct(
        private readonly BookmarkService $bookmarkService
    ) {}

    public function index(Request $request): View
    {
        $type = $request->query('tipe');
        $bookmarks = $this->bookmarkService->getBookmarksForUser($request->user(), $type, 15);

        return view('akun.tersimpan', compact('bookmarks', 'type'));
    }

    public function surah(int $surahNumber, Request $request): JsonResponse
    {
        abort_if($surahNumber < 1 || $surahNumber > 114, 404, 'Surah tidak valid.');

        $catatan = $request->input('catatan');
        $result = $this->bookmarkService->toggle(
            $request->user(),
            BookmarkType::SURAH->value,
            $surahNumber,
            $catatan
        );

        return response()->json($result);
    }

    public function ayah(Ayah $ayah, Request $request): JsonResponse
    {
        $catatan = $request->input('catatan');
        $result = $this->bookmarkService->toggle(
            $request->user(),
            BookmarkType::AYAH->value,
            $ayah->id,
            $catatan
        );

        return response()->json($result);
    }

    public function doa(Doa $doa, Request $request): JsonResponse
    {
        $catatan = $request->input('catatan');
        $result = $this->bookmarkService->toggle(
            $request->user(),
            BookmarkType::DOA->value,
            $doa->id,
            $catatan
        );

        return response()->json($result);
    }

    public function updateNote(Bookmark $bookmark, Request $request): JsonResponse
    {
        Gate::authorize('update', $bookmark);

        $validated = $request->validate([
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        $bookmark->update([
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Catatan berhasil diperbarui.',
            'catatan' => $bookmark->catatan,
        ]);
    }
}
