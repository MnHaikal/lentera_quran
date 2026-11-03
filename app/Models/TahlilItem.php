<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TahlilItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'urutan',
        'judul',
        'teks_arab',
        'teks_latin',
        'terjemahan',
        'jumlah_baca',
        'keterangan',
        'is_published',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'jumlah_baca' => 'integer',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}

