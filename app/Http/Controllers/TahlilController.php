<?php

namespace App\Http\Controllers;

use App\Models\TahlilItem;
use Database\Seeders\TahlilSeeder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TahlilController extends Controller
{
    private const PER_PAGE = 8;

    public function index(Request $request): View
    {
        $this->ensureSeeded();

        $search = trim((string) $request->query('q', ''));
        $sort = (string) $request->query('sort', 'urutan');

        $query = TahlilItem::query()->published();

        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                if (ctype_digit($search)) {
                    $builder->where('urutan', (int) $search);
                }

                $builder->orWhere('judul', 'like', "%{$search}%")
                    ->orWhere('terjemahan', 'like', "%{$search}%")
                    ->orWhere('teks_latin', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        match ($sort) {
            'urutan-desc' => $query->orderByDesc('urutan'),
            'judul' => $query->orderBy('judul'),
            'jumlah-baca' => $query->orderByDesc('jumlah_baca')->orderBy('urutan'),
            default => $query->orderBy('urutan'),
        };

        $tahlilItems = $query->paginate(self::PER_PAGE)->withQueryString();

        return view('tahlil.index', [
            'tahlilItems' => $tahlilItems,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    public function show(int $urutan): View
    {
        $this->ensureSeeded();

        $tahlilItem = TahlilItem::query()
            ->published()
            ->where('urutan', $urutan)
            ->first()
            ?? TahlilItem::query()->published()->findOrFail($urutan);

        $allItems = TahlilItem::query()
            ->published()
            ->orderBy('urutan')
            ->get();

        $followingItems = $allItems
            ->where('urutan', '>', $tahlilItem->urutan)
            ->take(4)
            ->values();

        $previousItem = $allItems
            ->where('urutan', '<', $tahlilItem->urutan)
            ->sortByDesc('urutan')
            ->first();

        $nextItem = $allItems
            ->where('urutan', '>', $tahlilItem->urutan)
            ->sortBy('urutan')
            ->first();

        $closingDoaItem = $allItems->firstWhere('urutan', 24);

        return view('tahlil.show', [
            'tahlilItem' => $tahlilItem,
            'allItems' => $allItems,
            'followingItems' => $followingItems,
            'previousItem' => $previousItem,
            'nextItem' => $nextItem,
            'closingDoaItem' => $closingDoaItem,
        ]);
    }

    private function ensureSeeded(): void
    {
        if (TahlilItem::query()->count() === 0) {
            app(TahlilSeeder::class)->run();
        }
    }
}
