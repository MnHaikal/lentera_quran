<?php

namespace App\Http\Controllers;

use App\Models\Doa;
use App\Models\DoaCategory;
use Database\Seeders\DoaSeeder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoaController extends Controller
{
    private const PER_PAGE = 8;

    public function index(Request $request): View
    {
        $this->ensureSeeded();

        $search = trim((string) $request->query('q', ''));
        $sort = (string) $request->query('sort', 'urutan');

        $query = DoaCategory::query()
            ->with(['doas' => static fn ($q) => $q->published()->orderBy('id')])
            ->withCount(['doas' => static fn ($q) => $q->published()]);

        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder->where('nama', 'like', "%{$search}%")
                    ->orWhereHas('doas', static function ($doaQuery) use ($search): void {
                        $doaQuery->published()->where(function ($sub) use ($search): void {
                            $sub->where('judul', 'like', "%{$search}%")
                                ->orWhere('terjemahan', 'like', "%{$search}%")
                                ->orWhere('teks_latin', 'like', "%{$search}%")
                                ->orWhere('sumber', 'like', "%{$search}%");
                        });
                    });
            });
        }

        match ($sort) {
            'nama' => $query->orderBy('nama'),
            'jumlah-doa' => $query->orderByDesc('doas_count')->orderBy('urutan'),
            'urutan-desc' => $query->orderByDesc('urutan'),
            default => $query->orderBy('urutan'),
        };

        $categories = $query->paginate(self::PER_PAGE)->withQueryString();
        $totalDoaCount = Doa::query()->published()->count();

        return view('doa.index', [
            'categories' => $categories,
            'totalDoaCount' => $totalDoaCount,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    public function show(Request $request, string $slug): View
    {
        $this->ensureSeeded();

        $category = DoaCategory::query()
            ->where('slug', $slug)
            ->first();

        $targetDoaSlug = trim((string) $request->query('doa', ''));

        if (! $category) {
            $matchedDoa = Doa::query()->published()->where('slug', $slug)->firstOrFail();
            $category = $matchedDoa->doaCategory;
            $targetDoaSlug = $matchedDoa->slug;
        }

        $doas = $category->doas()
            ->published()
            ->orderBy('id')
            ->get();

        $allCategories = DoaCategory::query()
            ->withCount(['doas' => static fn ($q) => $q->published()])
            ->orderBy('urutan')
            ->get();

        $previousCategory = $allCategories
            ->where('urutan', '<', $category->urutan)
            ->sortByDesc('urutan')
            ->first();

        $nextCategory = $allCategories
            ->where('urutan', '>', $category->urutan)
            ->sortBy('urutan')
            ->first();

        return view('doa.show', [
            'category' => $category,
            'doas' => $doas,
            'allCategories' => $allCategories,
            'previousCategory' => $previousCategory,
            'nextCategory' => $nextCategory,
            'targetDoaSlug' => $targetDoaSlug !== '' ? $targetDoaSlug : null,
        ]);
    }

    private function ensureSeeded(): void
    {
        if (DoaCategory::query()->count() === 0 || Doa::query()->count() === 0) {
            app(DoaSeeder::class)->run();
        }
    }
}
