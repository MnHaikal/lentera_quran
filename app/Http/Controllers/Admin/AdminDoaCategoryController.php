<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminDoaCategoryRequest;
use App\Models\DoaCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminDoaCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = DoaCategory::withCount('doas')->orderBy('urutan')->paginate(15);

        return view('admin.kategori-doa.index', compact('categories'));
    }

    public function create(): View
    {
        $nextUrutan = (DoaCategory::max('urutan') ?? 0) + 1;

        return view('admin.kategori-doa.create', compact('nextUrutan'));
    }

    public function store(AdminDoaCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        DoaCategory::create($data);

        return redirect()->route('admin.kategori-doa.index')
            ->with('status', 'Kategori doa berhasil ditambahkan.');
    }

    public function edit(DoaCategory $kategori): View
    {
        return view('admin.kategori-doa.edit', compact('kategori'));
    }

    public function update(AdminDoaCategoryRequest $request, DoaCategory $kategori): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        $kategori->update($data);

        return redirect()->route('admin.kategori-doa.index')
            ->with('status', 'Kategori doa berhasil diperbarui.');
    }

    public function destroy(DoaCategory $kategori): RedirectResponse
    {
        if ($kategori->doas()->count() > 0) {
            return redirect()->route('admin.kategori-doa.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki doa di dalamnya.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori-doa.index')
            ->with('status', 'Kategori doa berhasil dihapus.');
    }
}
