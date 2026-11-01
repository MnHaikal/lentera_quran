<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Ayah;
use App\Models\Bookmark;
use App\Models\Doa;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class BookmarkService
{
    public function toggle(User $user, string $type, int $id, ?string $catatan = null): array
    {
        $morphMap = Relation::morphMap();
        if (! isset($morphMap[$type])) {
            throw new InvalidArgumentException("Tipe bookmark tidak valid: {$type}");
        }

        return DB::transaction(function () use ($user, $type, $id, $catatan) {
            $existing = Bookmark::where('user_id', $user->id)
                ->where('bookmarkable_type', $type)
                ->where('bookmarkable_id', $id)
                ->first();

            if ($existing) {
                $existing->delete();

                return [
                    'status' => 'deleted',
                    'bookmarked' => false,
                    'message' => 'Berhasil dihapus dari tersimpan.',
                ];
            }

            Bookmark::create([
                'user_id' => $user->id,
                'bookmarkable_type' => $type,
                'bookmarkable_id' => $id,
                'catatan' => $catatan,
            ]);

            return [
                'status' => 'created',
                'bookmarked' => true,
                'message' => 'Berhasil disimpan ke daftar tersimpan.',
            ];
        });
    }

    public function getBookmarksForUser(User $user, ?string $type = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Bookmark::where('user_id', $user->id)
            ->with([
                'bookmarkable' => function (MorphTo $morphTo) {
                    $morphTo->morphWith([
                        Ayah::class => ['surah'],
                        Doa::class => ['category'],
                    ]);
                },
            ])
            ->latest();

        if ($type !== null) {
            $query->where('bookmarkable_type', $type);
        }

        return $query->paginate($perPage);
    }
}
