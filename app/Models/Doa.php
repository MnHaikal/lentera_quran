<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Doa extends Model
{
    use HasFactory;

    protected $fillable = [
        'doa_category_id',
        'judul',
        'slug',
        'teks_arab',
        'teks_latin',
        'terjemahan',
        'sumber',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'doa_category_id' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DoaCategory::class, 'doa_category_id');
    }

    public function doaCategory(): BelongsTo
    {
        return $this->belongsTo(DoaCategory::class, 'doa_category_id');
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}

