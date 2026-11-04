<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\DoaCategoryController;
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

Route::get('/', [HomeController::class, 'index'])->name('beranda');

Route::get('/al-quran', [QuranController::class, 'index'])->name('quran.index');
Route::get('/al-quran/juz-amma', [QuranController::class, 'juzAmma'])->name('quran.juz-amma');
Route::get('/al-quran/{surah}', [QuranController::class, 'show'])->whereNumber('surah')->name('quran.show');
Route::get('/api/audio/track', [QuranController::class, 'audioTrack'])->name('quran.audio-track');

Route::get('/tahlil', [TahlilController::class, 'index'])->name('tahlil.index');
Route::get('/tahlil/{urutan}', [TahlilController::class, 'show'])->whereNumber('urutan')->name('tahlil.show');

Route::get('/doa', [DoaController::class, 'index'])->name('doa.index');
Route::get('/doa/{slug}', [DoaController::class, 'show'])->name('doa.show');

Route::middleware(['auth', 'auth.session'])->group(function () {
    // Bookmarks / Penanda
    Route::get('/penanda', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::get('/tersimpan', [BookmarkController::class, 'index'])->name('tersimpan');
    Route::post('/bookmarks/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');

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

    // Terakhir Dibaca
    Route::post('/al-quran/{surah}/terakhir-dibaca', [LastReadController::class, 'store'])
        ->middleware('throttle:60,1')
        ->name('terakhir-dibaca.store');

    // Pengaturan
    Route::get('/pengaturan', [SettingController::class, 'edit'])->name('pengaturan.edit');
    Route::put('/pengaturan', [SettingController::class, 'update'])->name('pengaturan.update');

    // Profil
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil.edit');
    Route::match(['put', 'patch'], '/profil', [ProfileController::class, 'update'])->name('profil.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profil.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'auth.session', 'admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/super-admin', [AdminDashboardController::class, 'index'])->name('super-admin.dashboard');

    // Surah
    Route::get('/admin/surah', [AdminSurahController::class, 'index'])->name('admin.surah.index');
    Route::put('/admin/surah/{surah}', [AdminSurahController::class, 'update'])->whereNumber('surah')->name('admin.surah.update');

    // Tahlil
    Route::get('/admin/tahlil', [AdminTahlilController::class, 'index'])->name('admin.tahlil.index');
    Route::get('/admin/tahlil/export', [AdminTahlilController::class, 'export'])->name('admin.tahlil.export');
    Route::post('/admin/tahlil', [AdminTahlilController::class, 'store'])->name('admin.tahlil.store');
    Route::put('/admin/tahlil/{tahlil:id}', [AdminTahlilController::class, 'update'])->name('admin.tahlil.update');
    Route::delete('/admin/tahlil/{tahlil:id}', [AdminTahlilController::class, 'destroy'])->name('admin.tahlil.destroy');
    Route::post('/admin/tahlil/reorder', [AdminTahlilController::class, 'reorder'])->name('admin.tahlil.reorder');

    // Doa
    Route::get('/admin/doa', [AdminDoaController::class, 'index'])->name('admin.doa.index');
    Route::get('/admin/doa/export', [AdminDoaController::class, 'export'])->name('admin.doa.export');
    Route::post('/admin/doa', [AdminDoaController::class, 'store'])->name('admin.doa.store');
    Route::put('/admin/doa/{doa:id}', [AdminDoaController::class, 'update'])->name('admin.doa.update');
    Route::delete('/admin/doa/{doa:id}', [AdminDoaController::class, 'destroy'])->name('admin.doa.destroy');

    // Kategori Doa
    Route::get('/admin/kategori-doa', [DoaCategoryController::class, 'index'])->name('admin.doa-category.index');
    Route::post('/admin/kategori-doa', [DoaCategoryController::class, 'store'])->name('admin.doa-category.store');
    Route::put('/admin/kategori-doa/{kategoriDoa:id}', [DoaCategoryController::class, 'update'])->name('admin.doa-category.update');
    Route::delete('/admin/kategori-doa/{kategoriDoa:id}', [DoaCategoryController::class, 'destroy'])->name('admin.doa-category.destroy');
    Route::post('/admin/kategori-doa/reorder', [DoaCategoryController::class, 'reorder'])->name('admin.doa-category.reorder');
    Route::get('/admin/doa-category', fn () => redirect()->route('admin.doa-category.index'))->name('admin.kategori-doa.index');

    // Pengguna (Super Admin)
    Route::middleware('super_admin')->group(function () {
        Route::get('/admin/pengguna', [AdminUserController::class, 'index'])->name('admin.pengguna.index');
        Route::get('/admin/pengguna/create', [AdminUserController::class, 'create'])->name('admin.pengguna.create');
        Route::post('/admin/pengguna', [AdminUserController::class, 'store'])->name('admin.pengguna.store');
        Route::get('/admin/pengguna/{user:id}/edit', [AdminUserController::class, 'edit'])->name('admin.pengguna.edit');
        Route::put('/admin/pengguna/{user:id}', [AdminUserController::class, 'update'])->name('admin.pengguna.update');
        Route::delete('/admin/pengguna/{user:id}', [AdminUserController::class, 'destroy'])->name('admin.pengguna.destroy');

        // Aliases for admin.users.*
        Route::get('/admin/users', fn () => redirect()->route('admin.pengguna.index'))->name('admin.users.index');
        Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{user:id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user:id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    });
});

require __DIR__.'/auth.php';
