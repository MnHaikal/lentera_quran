<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\Surah;
use App\Models\TahlilItem;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $surahCount = Surah::query()->count() ?: 114;
        $tahlilCount = TahlilItem::query()->count() ?: 24;
        $doaCount = Doa::query()->count() ?: 185;
        $doaCategoryCount = DoaCategory::query()->count() ?: 12;
        $userCount = User::query()->count();

        return view('admin.dashboard', [
            'surahCount' => $surahCount,
            'tahlilCount' => $tahlilCount,
            'doaCount' => $doaCount,
            'doaCategoryCount' => $doaCategoryCount,
            'userCount' => $userCount,
        ]);
    }
}

