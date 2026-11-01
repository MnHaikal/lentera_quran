<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\TahlilItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TahlilController extends Controller
{
    public function index(): View
    {
        $tahlilItems = Cache::rememberForever('tahlil.published_items', function () {
            return TahlilItem::published()->get();
        });

        return view('tahlil.index', compact('tahlilItems'));
    }
}
