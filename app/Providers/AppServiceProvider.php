<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Ayah;
use App\Models\Doa;
use App\Models\Surah;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'surah' => Surah::class,
            'ayah'  => Ayah::class,
            'doa'   => Doa::class,
        ]);
    }
}
