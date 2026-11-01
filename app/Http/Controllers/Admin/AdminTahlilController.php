<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminTahlilRequest;
use App\Models\TahlilItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AdminTahlilController extends Controller
{
    public function index(Request $request): View
    {
        $items = TahlilItem::orderBy('urutan')->paginate(15);

        return view('admin.tahlil.index', compact('items'));
    }

    public function create(): View
    {
        $nextUrutan = (TahlilItem::max('urutan') ?? 0) + 1;

        return view('admin.tahlil.create', compact('nextUrutan'));
    }

    public function store(AdminTahlilRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published', true);

        TahlilItem::create($data);

        $this->flushCache();

        return redirect()->route('admin.tahlil.index')
            ->with('status', 'Butir tahlil berhasil ditambahkan.');
    }

    public function edit(TahlilItem $tahlil): View
    {
        return view('admin.tahlil.edit', compact('tahlil'));
    }

    public function update(AdminTahlilRequest $request, TahlilItem $tahlil): RedirectResponse
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published', true);

        $tahlil->update($data);

        $this->flushCache();

        return redirect()->route('admin.tahlil.index')
            ->with('status', 'Butir tahlil berhasil diperbarui.');
    }

    public function destroy(TahlilItem $tahlil): RedirectResponse
    {
        $tahlil->delete();

        $this->flushCache();

        return redirect()->route('admin.tahlil.index')
            ->with('status', 'Butir tahlil berhasil dihapus.');
    }

    private function flushCache(): void
    {
        Cache::forget('tahlil.published_items');
        Cache::forget('home.tahlil_count');
    }
}
