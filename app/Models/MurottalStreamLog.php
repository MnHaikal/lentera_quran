<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MurottalStreamLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'surah_id',
        'ayah_number',
        'duration_seconds',
        'qari',
    ];

    protected $casts = [
        'surah_id' => 'integer',
        'ayah_number' => 'integer',
        'duration_seconds' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function surah(): BelongsTo
    {
        return $this->belongsTo(Surah::class);
    }
}

