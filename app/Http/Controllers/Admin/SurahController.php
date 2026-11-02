<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doa;
use App\Models\Surah;
use App\Models\TahlilItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SurahController extends Controller
{
    /**
     * Tampilkan daftar surah untuk kurasi Super Admin.
     */
    public function index(Request $request): View
    {
        $query = Surah::query();

        // Filter Pencarian (nama latin, nama arab, arti, atau nomor surah)
        if ($search = trim((string) $request->input('q', ''))) {
            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->where('id', (int) $search)
                        ->orWhere('nama_latin', 'like', "%{$search}%");
                } else {
                    $q->where('nama_latin', 'like', "%{$search}%")
                        ->orWhere('nama_arab', 'like', "%{$search}%")
                        ->orWhere('arti', 'like', "%{$search}%");
                }
            });
        }

        // Filter Tempat Turun (Mekah / Madinah)
        if ($tempatTurun = $request->input('tempat_turun')) {
            if (in_array(strtolower($tempatTurun), ['mekah', 'madinah'], true)) {
                $query->where('tempat_turun', strtolower($tempatTurun));
            }
        }

        // Filter Juz (1 - 30)
        if ($juz = $request->input('juz')) {
            $juzNum = (int) $juz;
            if ($juzNum >= 1 && $juzNum <= 30) {
                $query->whereHas('ayahs', function ($q) use ($juzNum) {
                    $q->where('juz', $juzNum);
                });
            }
        }

        // Filter Ketersediaan Audio
        if ($audio = $request->input('audio')) {
            if ($audio === 'tersedia') {
                $query->whereNotNull('audio_url')->where('audio_url', '!=', '');
            } elseif ($audio === 'belum_ada') {
                $query->where(function ($q) {
                    $q->whereNull('audio_url')->orWhere('audio_url', '');
                });
            }
        }

        $surahs = $query->orderBy('id')->paginate(10)->withQueryString();

        $surahCount = Surah::count() ?: 114;
        $tahlilCount = TahlilItem::count() ?: 24;
        $doaCount = Doa::count() ?: 185;

        return view('admin.surah.index', [
            'surahs' => $surahs,
            'surahCount' => $surahCount,
            'tahlilCount' => $tahlilCount,
            'doaCount' => $doaCount,
            'totalVerifiedSurahs' => $surahCount,
        ]);
    }

    /**
     * Perbarui data surah hasil kurasi.
     */
    public function update(Request $request, Surah $surah): RedirectResponse
    {
        $validated = $request->validate([
            'nama_latin' => ['required', 'string', 'max:60'],
            'nama_arab' => ['required', 'string', 'max:50'],
            'arti' => ['required', 'string', 'max:100'],
            'tempat_turun' => ['required', 'in:mekah,madinah'],
            'audio_url' => ['nullable', 'url', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'nama_latin.required' => 'Nama latin surah wajib diisi.',
            'nama_arab.required' => 'Nama arab surah wajib diisi.',
            'arti.required' => 'Arti terjemahan wajib diisi.',
            'tempat_turun.required' => 'Tempat turun wajib dipilih.',
            'audio_url.url' => 'Format tautan audio harus berupa URL yang valid.',
        ]);

        $surah->update($validated);

        return redirect()
            ->back()
            ->with('success', "Surah {$surah->nama_latin} (No. {$surah->id}) berhasil diperbarui.");
    }
}
