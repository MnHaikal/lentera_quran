<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Theme;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ukuran_font_arab',
        'tampilkan_latin',
        'tampilkan_terjemahan',
        'tema',
    ];

    protected function casts(): array
    {
        return [
            'ukuran_font_arab' => 'integer',
            'tampilkan_latin' => 'boolean',
            'tampilkan_terjemahan' => 'boolean',
            'tema' => Theme::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

