<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Ayah extends Model
{
    use HasFactory;

    protected $fillable = [
        'surah_id',
        'nomor_ayat',
        'teks_arab',
        'teks_latin',
        'terjemahan',
        'juz',
        'halaman',
        'audio_url',
    ];

    protected function casts(): array
    {
        return [
            'surah_id' => 'integer',
            'nomor_ayat' => 'integer',
            'juz' => 'integer',
            'halaman' => 'integer',
        ];
    }

    public function surah(): BelongsTo
    {
        return $this->belongsTo(Surah::class);
    }

    public function tafsir(): HasOne
    {
        return $this->hasOne(Tafsir::class);
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}

