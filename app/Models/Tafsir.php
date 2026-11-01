<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tafsir extends Model
{
    use HasFactory;

    protected $fillable = [
        'ayah_id',
        'sumber',
        'isi',
    ];

    public function ayah(): BelongsTo
    {
        return $this->belongsTo(Ayah::class);
    }
}

