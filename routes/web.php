<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminAyahController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDoaCategoryController;
use App\Http\Controllers\Admin\AdminDoaController;
use App\Http\Controllers\Admin\AdminSurahController;
use App\Http\Controllers\Admin\AdminTahlilController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DoaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LastReadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TahlilController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('beranda');

Route::get('/al-quran', [QuranController::class, 'index'])
    ->name('quran.index');

Route::get('/al-quran/juz-amma', [QuranController::class, 'juzAmma'])
    ->name('quran.juz-amma');

Route::get('/al-quran/{surah}', [QuranController::class, 'show'])
    ->whereNumber('surah')
    ->name('quran.show');

Route::get('/tahlil', [TahlilController::class, 'index'])
    ->name('tahlil.index');

Route::get('/tahlil/{urutan}', [TahlilController::class, 'show'])
    ->whereNumber('urutan')
    ->name('tahlil.show');

Route::get('/doa', [DoaController::class, 'index'])
    ->name('doa.index');

Route::get('/doa/{slug}', [DoaController::class, 'show'])
    ->name('doa.show');

Route::middleware('auth')->group(function () {
    Route::post('/al-quran/{surah}/simpan', [BookmarkController::class, 'surah'])
        ->middleware('throttle:60,1')
        ->name('bookmark.surah');

    Route::post('/ayat/{ayah}/simpan', [BookmarkController::class, 'ayah'])
        ->middleware('throttle:60,1')
        ->name('bookmark.ayah');

    Route::post('/doa/{doa:slug}/simpan', [BookmarkController::class, 'doa'])
        ->middleware('throttle:60,1')
        ->name('bookmark.doa');

    Route::patch('/tersimpan/{bookmark}/catatan', [BookmarkController::class, 'updateNote'])
        ->middleware('throttle:60,1')
        ->name('bookmark.catatan.update');

    Route::get('/tersimpan', [BookmarkController::class, 'index'])
        ->name('tersimpan');

    Route::post('/al-quran/{surah}/terakhir-dibaca', [LastReadController::class, 'store'])
        ->middleware('throttle:60,1')
        ->name('terakhir-dibaca.store');

    Route::get('/pengaturan', [SettingController::class, 'edit'])
        ->name('pengaturan.edit');

    Route::put('/pengaturan', [SettingController::class, 'update'])
        ->name('pengaturan.update');

    Route::get('/dashboard', function () {
        if (request()->user()?->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('beranda');
    })->name('dashboard');

    Route::get('/profil', [ProfileController::class, 'edit'])
        ->name('profil.edit');

    Route::match(['put', 'patch'], '/profil', [ProfileController::class, 'update'])
        ->name('profil.update');

    Route::delete('/profil', [ProfileController::class, 'destroy'])
        ->name('profil.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('surah', AdminSurahController::class)
            ->only(['index', 'show', 'edit', 'update']);

        Route::resource('surah.ayat', AdminAyahController::class)
            ->shallow()
            ->only(['index', 'edit', 'update']);

        Route::resource('tahlil', AdminTahlilController::class)
            ->except('show');

        Route::resource('kategori-doa', AdminDoaCategoryController::class)
            ->parameters(['kategori-doa' => 'kategori'])
            ->except('show');

        Route::resource('doa', AdminDoaController::class)
            ->except('show');

        Route::middleware('super_admin')->group(function () {
            Route::resource('pengguna', AdminUserController::class)
                ->parameters(['pengguna' => 'user'])
                ->except('show');
        });
    });

require __DIR__.'/auth.php';
