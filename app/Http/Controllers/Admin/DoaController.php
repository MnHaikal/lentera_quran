<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\Surah;
use App\Models\TahlilItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DoaController extends Controller
{
    /**
     * Tampilkan daftar doa untuk Super Admin.
     */
    public function index(Request $request): View
    {
        $query = Doa::query()->with('doaCategory');

        // Filter Pencarian (judul, teks_latin, sumber, atau ID / kode #DOA-xxx)
        if ($search = trim((string) $request->input('q', ''))) {
            $query->where(function ($q) use ($search) {
                // Bersihkan pencarian jika user mengetik #DOA-001 atau DOA-1
                $cleanId = preg_replace('/[^0-9]/', '', $search);
                if ($cleanId !== '' && is_numeric($cleanId)) {
                    $q->orWhere('id', (int) $cleanId);
                }

                $q->orWhere('judul', 'like', "%{$search}%")
                    ->orWhere('teks_latin', 'like', "%{$search}%")
                    ->orWhere('sumber', 'like', "%{$search}%");
            });
        }

        // Filter Kategori
        if ($kategori = $request->input('kategori')) {
            if (is_numeric($kategori)) {
                $query->where('doa_category_id', (int) $kategori);
            } else {
                $query->whereHas('doaCategory', function ($q) use ($kategori) {
                    $q->where('slug', $kategori);
                });
            }
        }

        // Filter Status (Terbit / Draf)
        if ($status = $request->input('status')) {
            if ($status === 'terbit') {
                $query->where('is_published', true);
            } elseif ($status === 'draf') {
                $query->where('is_published', false);
            }
        }

        // 10 doa per halaman sesuai standar Surah & Ayat
        $doas = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();

        $categories = DoaCategory::orderBy('urutan')->get();

        $totalDoa = Doa::count();
        $totalPublished = Doa::where('is_published', true)->count();
        $totalDraft = Doa::where('is_published', false)->count();

        $surahCount = Surah::count() ?: 114;
        $tahlilCount = TahlilItem::count() ?: 24;

        return view('admin.doa.index', [
            'doas' => $doas,
            'categories' => $categories,
            'totalDoa' => $totalDoa,
            'totalPublished' => $totalPublished,
            'totalDraft' => $totalDraft,
            'surahCount' => $surahCount,
            'tahlilCount' => $tahlilCount,
            'doaCount' => $totalDoa,
        ]);
    }

    /**
     * Simpan doa baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'doa_category_id' => ['required', 'exists:doa_categories,id'],
            'judul' => ['required', 'string', 'max:150'],
            'teks_arab' => ['required', 'string'],
            'teks_latin' => ['required', 'string'],
            'terjemahan' => ['required', 'string'],
            'sumber' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'doa_category_id.required' => 'Kategori doa wajib dipilih.',
            'doa_category_id.exists' => 'Kategori doa tidak valid.',
            'judul.required' => 'Judul doa wajib diisi.',
            'teks_arab.required' => 'Teks arab doa wajib diisi.',
            'teks_latin.required' => 'Teks latin doa wajib diisi.',
            'terjemahan.required' => 'Terjemahan doa wajib diisi.',
        ]);

        $baseSlug = Str::slug($validated['judul']);
        $slug = $baseSlug;
        $count = 1;
        while (Doa::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }

        $validated['slug'] = $slug;
        $validated['is_published'] = $request->boolean('is_published', true);

        $doa = Doa::create($validated);

        return redirect()
            ->back()
            ->with('success', "Doa '{$doa->judul}' (#DOA-" . str_pad((string) $doa->id, 3, '0', STR_PAD_LEFT) . ") berhasil ditambahkan.");
    }

    /**
     * Perbarui data doa hasil kurasi.
     */
    public function update(Request $request, Doa $doa): RedirectResponse
    {
        $validated = $request->validate([
            'doa_category_id' => ['required', 'exists:doa_categories,id'],
            'judul' => ['required', 'string', 'max:150'],
            'teks_arab' => ['required', 'string'],
            'teks_latin' => ['required', 'string'],
            'terjemahan' => ['required', 'string'],
            'sumber' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'doa_category_id.required' => 'Kategori doa wajib dipilih.',
            'doa_category_id.exists' => 'Kategori doa tidak valid.',
            'judul.required' => 'Judul doa wajib diisi.',
            'teks_arab.required' => 'Teks arab doa wajib diisi.',
            'teks_latin.required' => 'Teks latin doa wajib diisi.',
            'terjemahan.required' => 'Terjemahan doa wajib diisi.',
        ]);

        if ($validated['judul'] !== $doa->judul) {
            $baseSlug = Str::slug($validated['judul']);
            $slug = $baseSlug;
            $count = 1;
            while (Doa::where('slug', $slug)->where('id', '!=', $doa->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
            $validated['slug'] = $slug;
        }

        $validated['is_published'] = $request->boolean('is_published', true);

        $doa->update($validated);

        return redirect()
            ->back()
            ->with('success', "Doa '{$doa->judul}' (#DOA-" . str_pad((string) $doa->id, 3, '0', STR_PAD_LEFT) . ") berhasil diperbarui.");
    }

    /**
     * Hapus doa dari database.
     */
    public function destroy(Doa $doa): RedirectResponse
    {
        $judul = $doa->judul;
        $doaId = $doa->id;
        $doa->delete();

        return redirect()
            ->back()
            ->with('success', "Doa '{$judul}' (#DOA-" . str_pad((string) $doaId, 3, '0', STR_PAD_LEFT) . ") berhasil dihapus.");
    }

    /**
     * Ekspor daftar doa ke file format CSV / Excel dengan encoding UTF-8 (BOM).
     */
    public function export(): StreamedResponse
    {
        $fileName = 'kumpulan_doa_lentera_quran_' . date('Ymd_His') . '.csv';

        return response()->streamDownload(function () {
            $output = fopen('php://output', 'w');
            // Menulis UTF-8 BOM agar Excel dapat menampilkan teks Arab secara benar
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header kolom
            fputcsv($output, [
                'Kode Doa',
                'ID',
                'Judul Doa',
                'Kategori',
                'Teks Arab',
                'Teks Latin',
                'Terjemahan',
                'Sumber / Dalil',
                'Status',
                'Terakhir Diperbarui',
            ]);

            Doa::with('doaCategory')->chunk(100, function ($doas) use ($output) {
                foreach ($doas as $doa) {
                    fputcsv($output, [
                        '#DOA-' . str_pad((string) $doa->id, 3, '0', STR_PAD_LEFT),
                        $doa->id,
                        $doa->judul,
                        $doa->doaCategory?->nama ?? '-',
                        $doa->teks_arab,
                        $doa->teks_latin,
                        $doa->terjemahan,
                        $doa->sumber ?? '-',
                        $doa->is_published ? 'Terbit' : 'Draf',
                        $doa->updated_at ? $doa->updated_at->format('Y-m-d H:i:s') : '-',
                    ]);
                }
            });

            fclose($output);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }
}

