<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\BookmarkType;
use App\Models\Bookmark;
use App\Models\Doa;
use App\Models\DoaCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoaController extends Controller
{
    public function index(Request $request): View
    {
        $categorySlug = $request->query('kategori');
        $q = trim((string) $request->query('q', ''));

        $categories = DoaCategory::orderBy('urutan')->withCount(['doas' => function ($q) {
            $q->where('is_published', true);
        }])->get();

        $doasQuery = Doa::published()->with('category');

        if (!empty($categorySlug)) {
            $doasQuery->whereHas('category', function ($catQuery) use ($categorySlug) {
                $catQuery->where('slug', $categorySlug);
            });
        }

        if ($q !== '') {
            $doasQuery->where(function ($searchQuery) use ($q) {
                $searchQuery->where('judul', 'like', "%{$q}%")
                    ->orWhere('terjemahan', 'like', "%{$q}%")
                    ->orWhere('teks_latin', 'like', "%{$q}%");
            });
        }

        $doas = $doasQuery->latest()->paginate(12)->withQueryString();

        return view('doa.index', compact('categories', 'doas', 'categorySlug', 'q'));
    }

    public function show(Doa $doa, Request $request): View
    {
        abort_unless($doa->is_published, 404, 'Doa tidak ditemukan atau belum dipublikasikan.');

        $isBookmarked = false;
        if ($request->user()) {
            $isBookmarked = Bookmark::where('user_id', $request->user()->id)
                ->where('bookmarkable_type', BookmarkType::DOA->value)
                ->where('bookmarkable_id', $doa->id)
                ->exists();
        }

        return view('doa.show', compact('doa', 'isBookmarked'));
    }
}
