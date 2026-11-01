<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminDoaRequest;
use App\Models\Doa;
use App\Models\DoaCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminDoaController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $categoryId = $request->query('kategori_id');

        $query = Doa::with('category')->latest();

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('terjemahan', 'like', "%{$q}%");
            });
        }

        if (!empty($categoryId)) {
            $query->where('doa_category_id', $categoryId);
        }

        $doas = $query->paginate(15)->withQueryString();
        $categories = DoaCategory::orderBy('urutan')->get();

        return view('admin.doa.index', compact('doas', 'categories', 'q', 'categoryId'));
    }

    public function create(): View
    {
        $categories = DoaCategory::orderBy('urutan')->get();

        return view('admin.doa.create', compact('categories'));
    }

    public function store(AdminDoaRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['judul']);
        }
        $data['is_published'] = $request->boolean('is_published', true);

        Doa::create($data);

        Cache::forget('home.doa_count');

        return redirect()->route('admin.doa.index')
            ->with('status', 'Doa berhasil ditambahkan.');
    }

    public function edit(Doa $doa): View
    {
        $categories = DoaCategory::orderBy('urutan')->get();

        return view('admin.doa.edit', compact('doa', 'categories'));
    }

    public function update(AdminDoaRequest $request, Doa $doa): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['judul']);
        }
        $data['is_published'] = $request->boolean('is_published', true);

        $doa->update($data);

        Cache::forget('home.doa_count');

        return redirect()->route('admin.doa.index')
            ->with('status', 'Doa berhasil diperbarui.');
    }

    public function destroy(Doa $doa): RedirectResponse
    {
        $doa->delete();

        Cache::forget('home.doa_count');

        return redirect()->route('admin.doa.index')
            ->with('status', 'Doa berhasil dihapus.');
    }
}
