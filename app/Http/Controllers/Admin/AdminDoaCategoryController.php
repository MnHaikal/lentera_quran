<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminDoaCategoryRequest;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\Surah;
use App\Models\TahlilItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminDoaCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = DoaCategory::query()->withCount('doas');

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

        $categories = $query->orderBy('urutan', 'asc')->paginate(7)->withQueryString();

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

    public function store(AdminDoaCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

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

    public function update(AdminDoaCategoryRequest $request, DoaCategory $kategoriDoa): RedirectResponse
    {
        $validated = $request->validated();

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

        if (empty($validated['urutan'])) {
            $validated['urutan'] = $kategoriDoa->urutan;
        }

        $kategoriDoa->update($validated);

        return redirect()
            ->back()
            ->with('success', "Kategori '{$kategoriDoa->nama}' berhasil diperbarui.");
    }

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
