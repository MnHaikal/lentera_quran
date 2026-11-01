<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAyahUpdateRequest;
use App\Models\Ayah;
use App\Models\Surah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAyahController extends Controller
{
    public function index(Surah $surah, Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $query = $surah->ayahs()->orderBy('nomor_ayat');

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('nomor_ayat', $q)
                    ->orWhere('terjemahan', 'like', "%{$q}%")
                    ->orWhere('teks_latin', 'like', "%{$q}%");
            });
        }

        $ayahs = $query->paginate(30)->withQueryString();

        return view('admin.ayat.index', compact('surah', 'ayahs', 'q'));
    }

    public function edit(Ayah $ayah): View
    {
        $ayah->load('surah');

        return view('admin.ayat.edit', compact('ayah'));
    }

    public function update(AdminAyahUpdateRequest $request, Ayah $ayah): RedirectResponse
    {
        $ayah->update($request->validated());

        return redirect()->route('admin.surah.ayat.index', $ayah->surah_id)
            ->with('status', "Ayat ke-{$ayah->nomor_ayat} Surah {$ayah->surah->nama_latin} berhasil diperbarui.");
    }
}
