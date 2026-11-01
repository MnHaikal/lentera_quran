<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSurahUpdateRequest;
use App\Models\Surah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AdminSurahController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $query = Surah::query()->withCount('ayahs')->orderBy('id');

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_latin', 'like', "%{$q}%")
                    ->orWhere('arti', 'like', "%{$q}%")
                    ->orWhere('id', $q);
            });
        }

        $surahs = $query->paginate(20)->withQueryString();

        return view('admin.surah.index', compact('surahs', 'q'));
    }

    public function show(Surah $surah): View
    {
        $surah->load(['ayahs' => function ($q) {
            $q->orderBy('nomor_ayat', 'asc');
        }]);

        return view('admin.surah.show', compact('surah'));
    }

    public function edit(Surah $surah): View
    {
        return view('admin.surah.edit', compact('surah'));
    }

    public function update(AdminSurahUpdateRequest $request, Surah $surah): RedirectResponse
    {
        $surah->update($request->validated());

        Cache::forget('surahs.all');
        Cache::forget('surahs.juz_amma');
        Cache::forget('home.juz_amma_surahs');

        return redirect()->route('admin.surah.index')
            ->with('status', "Data Surah {$surah->nama_latin} berhasil diperbarui.");
    }
}
