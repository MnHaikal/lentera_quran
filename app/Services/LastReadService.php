<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\LastRead;
use App\Models\User;

class LastReadService
{
    public function updateLastRead(User $user, int $surahId, ?int $ayahId = null): LastRead
    {
        return LastRead::updateOrCreate(
            ['user_id' => $user->id],
            [
                'surah_id' => $surahId,
                'ayah_id' => $ayahId,
            ]
        );
    }

    public function getLastRead(User $user): ?LastRead
    {
        return LastRead::where('user_id', $user->id)
            ->with(['surah', 'ayah'])
            ->first();
    }
}
