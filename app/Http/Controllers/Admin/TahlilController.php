<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\Surah;
use App\Models\TahlilItem;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TahlilController extends Controller
{
    /**
     * Tampilkan daftar bacaan tahlil berurutan untuk kurasi Super Admin.
     */
    public function index(Request $request): View
    {
        $query = TahlilItem::query();

        // Filter Pencarian (urutan, judul, keterangan, teks arab, teks latin, terjemahan)
        if ($search = trim((string) $request->input('q', ''))) {
            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->orWhere('urutan', (int) $search)
                        ->orWhere('id', (int) $search);
                }

                $q->orWhere('judul', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhere('teks_arab', 'like', "%{$search}%")
                    ->orWhere('teks_latin', 'like', "%{$search}%")
                    ->orWhere('terjemahan', 'like', "%{$search}%");
            });
        }

        // Filter Jumlah Baca (1x, 3x, 7x, 10x, 33x, dst)
        if ($jumlahBaca = $request->input('jumlah_baca')) {
            if (is_numeric($jumlahBaca)) {
                $query->where('jumlah_baca', (int) $jumlahBaca);
            }
        }

        // 10 bacaan per halaman sesuai standar Surah & Ayat
        $tahlilItems = $query->orderBy('urutan', 'asc')->paginate(10)->withQueryString();

        $totalTahlil = TahlilItem::count();
        $distinctJumlahBaca = TahlilItem::distinct()->orderBy('jumlah_baca', 'asc')->pluck('jumlah_baca')->all();
        if (empty($distinctJumlahBaca)) {
            $distinctJumlahBaca = [1, 3, 7, 10, 33];
        }

        $surahCount = Surah::count() ?: 114;
        $tahlilCount = $totalTahlil ?: 24;
        $doaCount = Doa::count() ?: 185;
        $doaCategoryCount = DoaCategory::count() ?: 12;
        $userCount = User::count() ?: 1;

        return view('admin.tahlil.index', [
            'tahlilItems' => $tahlilItems,
            'totalTahlil' => $totalTahlil,
            'distinctJumlahBaca' => $distinctJumlahBaca,
            'totalTerbit' => $totalTahlil,
            'totalDraf' => 0,
            'surahCount' => $surahCount,
            'tahlilCount' => $tahlilCount,
            'doaCount' => $doaCount,
            'doaCategoryCount' => $doaCategoryCount,
            'userCount' => $userCount,
        ]);
    }

    /**
     * Tambah bacaan tahlil baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'teks_arab' => ['required', 'string'],
            'teks_latin' => ['nullable', 'string'],
            'terjemahan' => ['nullable', 'string'],
            'jumlah_baca' => ['required', 'integer', 'min:1', 'max:1000'],
            'urutan' => ['nullable', 'integer', 'min:1'],
            'is_published' => ['nullable'],
        ], [
            'judul.required' => 'Judul bacaan tahlil wajib diisi.',
            'judul.max' => 'Judul bacaan maksimal 150 karakter.',
            'teks_arab.required' => 'Teks Arab bacaan wajib diisi.',
            'jumlah_baca.required' => 'Jumlah bacaan wajib diisi (minimal 1x).',
        ]);

        if (empty($validated['urutan'])) {
            $validated['urutan'] = ((int) TahlilItem::max('urutan')) + 1;
        }

        $validated['is_published'] = $request->boolean('is_published', true);
        $validated['teks_latin'] = $validated['teks_latin'] ?? '';
        $validated['terjemahan'] = $validated['terjemahan'] ?? '';

        $item = TahlilItem::create($validated);

        return redirect()
            ->route('admin.tahlil.index')
            ->with('success', "Bacaan tahlil \"{$item->judul}\" berhasil ditambahkan.");
    }

    /**
     * Perbarui data bacaan tahlil di database.
     */
    public function update(Request $request, TahlilItem $tahlil): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'teks_arab' => ['required', 'string'],
            'teks_latin' => ['nullable', 'string'],
            'terjemahan' => ['nullable', 'string'],
            'jumlah_baca' => ['required', 'integer', 'min:1', 'max:1000'],
            'urutan' => ['required', 'integer', 'min:1'],
            'is_published' => ['nullable'],
        ], [
            'judul.required' => 'Judul bacaan tahlil wajib diisi.',
            'judul.max' => 'Judul bacaan maksimal 150 karakter.',
            'teks_arab.required' => 'Teks Arab bacaan wajib diisi.',
            'jumlah_baca.required' => 'Jumlah bacaan wajib diisi (minimal 1x).',
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['teks_latin'] = $validated['teks_latin'] ?? '';
        $validated['terjemahan'] = $validated['terjemahan'] ?? '';

        $tahlil->update($validated);

        return redirect()
            ->route('admin.tahlil.index')
            ->with('success', "Bacaan tahlil \"{$tahlil->judul}\" berhasil diperbarui.");
    }

    /**
     * Hapus bacaan tahlil dari database.
     */
    public function destroy(TahlilItem $tahlil): RedirectResponse
    {
        $judul = $tahlil->judul;
        $tahlil->delete();

        return redirect()
            ->route('admin.tahlil.index')
            ->with('success', "Bacaan tahlil \"{$judul}\" berhasil dihapus.");
    }

    /**
     * Reorder urutan susunan bacaan tahlil via AJAX / Drag-and-drop.
     */
    public function reorder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:tahlil_items,id'],
            'items.*.urutan' => ['required', 'integer', 'min:1'],
        ]);

        foreach ($validated['items'] as $itemData) {
            TahlilItem::where('id', $itemData['id'])->update(['urutan' => $itemData['urutan']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan susunan bacaan tahlil berhasil diperbarui.',
        ]);
    }

    /**
     * Ekspor data bacaan tahlil ke file CSV / Excel.
     */
    public function export(): StreamedResponse
    {
        $fileName = 'bacaan_tahlil_lentera_quran_' . date('Ymd_His') . '.csv';

        return response()->streamDownload(function () {
            $output = fopen('php://output', 'w');
            // UTF-8 BOM untuk kompatibilitas Excel dengan aksara Arab
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($output, [
                'Urutan',
                'Judul Bacaan',
                'Keterangan / Subjudul',
                'Jumlah Bacaan',
                'Teks Arab',
                'Teks Latin',
                'Terjemahan',
                'Status',
                'Terakhir Diperbarui',
            ]);

            TahlilItem::orderBy('urutan', 'asc')->chunk(100, function ($items) use ($output) {
                foreach ($items as $item) {
                    fputcsv($output, [
                        $item->urutan,
                        $item->judul,
                        $item->keterangan ?? '-',
                        $item->jumlah_baca . 'x',
                        $item->teks_arab,
                        $item->teks_latin,
                        $item->terjemahan,
                        $item->is_published ? 'Terbit' : 'Draf',
                        $item->updated_at?->format('d M Y H:i') ?? '-',
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

