<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\LastReadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LastReadController extends Controller
{
    public function __construct(
        private readonly LastReadService $lastReadService
    ) {}

    public function store(int $surahNumber, Request $request): JsonResponse
    {
        abort_if($surahNumber < 1 || $surahNumber > 114, 404, 'Surah tidak valid.');

        $request->validate([
            'ayah_id' => ['nullable', 'integer', 'exists:ayahs,id'],
        ]);

        $ayahId = $request->input('ayah_id') ? (int) $request->input('ayah_id') : null;

        $lastRead = $this->lastReadService->updateLastRead(
            $request->user(),
            $surahNumber,
            $ayahId
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Posisi terakhir dibaca berhasil diperbarui.',
            'data' => [
                'surah_id' => $lastRead->surah_id,
                'ayah_id' => $lastRead->ayah_id,
                'updated_at' => $lastRead->updated_at->toIso8601String(),
            ],
        ]);
    }
}
