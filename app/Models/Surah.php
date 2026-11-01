<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RevelationType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Surah extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'nama_arab',
        'nama_latin',
        'arti',
        'jumlah_ayat',
        'tempat_turun',
        'deskripsi',
        'audio_url',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'jumlah_ayat' => 'integer',
            'tempat_turun' => RevelationType::class,
        ];
    }

    public function ayahs(): HasMany
    {
        return $this->hasMany(Ayah::class)->orderBy('nomor_ayat', 'asc');
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function lastReads(): HasMany
    {
        return $this->hasMany(LastRead::class);
    }

    public function scopeJuzAmma(Builder $query): Builder
    {
        return $query->whereBetween('id', [78, 114]);
    }
}

