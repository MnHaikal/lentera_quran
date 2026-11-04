<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\Surah;
use App\Models\TahlilItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DoaCategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori doa untuk Super Admin.
     */
    public function index(Request $request): View
    {
        $query = DoaCategory::query()->withCount('doas');

        // Filter Pencarian (nama, slug, deskripsi, atau urutan)
        if ($search = trim((string) $request->input('q', ''))) {
            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->orWhere('urutan', (int) $search)
                        ->orWhere('id', (int) $search);
                }

                $q->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // 10 kategori per halaman sesuai standar Surah & Ayat
        $categories = $query->orderBy('urutan', 'asc')->paginate(10)->withQueryString();

        $totalCategories = DoaCategory::count();
        $totalDoas = Doa::count();

        $surahCount = Surah::count() ?: 114;
        $tahlilCount = TahlilItem::count() ?: 24;
        $doaCount = $totalDoas ?: 185;

        return view('admin.doa-category.index', [
            'categories' => $categories,
            'totalCategories' => $totalCategories,
            'totalDoas' => $totalDoas,
            'surahCount' => $surahCount,
            'tahlilCount' => $tahlilCount,
            'doaCount' => $doaCount,
            'doaCategoryCount' => $totalCategories,
        ]);
    }

    /**
     * Tambah kategori doa baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer', 'min:1'],
        ], [
            'nama.required' => 'Nama kategori doa wajib diisi.',
            'nama.max' => 'Nama kategori maksimal 100 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter.',
        ]);

        $baseSlug = Str::slug($validated['nama']);
        $slug = $baseSlug;
        $count = 1;
        while (DoaCategory::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$count}";
            $count++;
        }
        $validated['slug'] = $slug;

        if (empty($validated['urutan'])) {
            $validated['urutan'] = ((int) DoaCategory::max('urutan')) + 1;
        }

        $category = DoaCategory::create($validated);

        return redirect()
            ->back()
            ->with('success', "Kategori '{$category->nama}' berhasil ditambahkan.");
    }

    /**
     * Perbarui data kategori doa.
     */
    public function update(Request $request, DoaCategory $kategoriDoa): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'urutan' => ['required', 'integer', 'min:1'],
        ], [
            'nama.required' => 'Nama kategori doa wajib diisi.',
            'nama.max' => 'Nama kategori maksimal 100 karakter.',
            'urutan.required' => 'Nomor urutan wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 255 karakter.',
        ]);

        if ($validated['nama'] !== $kategoriDoa->nama) {
            $baseSlug = Str::slug($validated['nama']);
            $slug = $baseSlug;
            $count = 1;
            while (DoaCategory::where('slug', $slug)->where('id', '!=', $kategoriDoa->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
            $validated['slug'] = $slug;
        }

        $kategoriDoa->update($validated);

        return redirect()
            ->back()
            ->with('success', "Kategori '{$kategoriDoa->nama}' berhasil diperbarui.");
    }

    /**
     * Hapus kategori doa.
     */
    public function destroy(DoaCategory $kategoriDoa): RedirectResponse
    {
        $doasCount = $kategoriDoa->doas()->count();

        if ($doasCount > 0) {
            return redirect()
                ->back()
                ->with('error', "Kategori '{$kategoriDoa->nama}' tidak dapat dihapus karena masih memuat {$doasCount} doa.");
        }

        $nama = $kategoriDoa->nama;
        $kategoriDoa->delete();

        return redirect()
            ->back()
            ->with('success', "Kategori '{$nama}' berhasil dihapus.");
    }

    /**
     * Simpan urutan susunan kategori (Drag & Drop / Reorder).
     */
    public function reorder(Request $request): JsonResponse
    {
        $orders = $request->input('orders', []);

        if (is_array($orders)) {
            foreach ($orders as $index => $id) {
                DoaCategory::where('id', (int) $id)->update(['urutan' => $index + 1]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Urutan susunan kategori berhasil disimpan.',
        ]);
    }
}

