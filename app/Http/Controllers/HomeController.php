<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Ayah;
use App\Models\Doa;
use App\Models\Surah;
use App\Models\TahlilItem;
use App\Services\LastReadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly LastReadService $lastReadService
    ) {}

    public function index(Request $request): View
    {
        $juzAmmaSurahs = Cache::remember('home.juz_amma_surahs', 86400, function () {
            return Surah::juzAmma()->orderBy('id')->get();
        });

        $todayKey = 'home.ayat_harian.' . Carbon::today()->toDateString();
        $ayatHarian = Cache::remember($todayKey, 86400, function () {
            return Ayah::with('surah')->inRandomOrder()->first();
        });

        $tahlilCount = Cache::remember('home.tahlil_count', 86400, function () {
            return TahlilItem::published()->count();
        });

        $doaCount = Cache::remember('home.doa_count', 86400, function () {
            return Doa::published()->count();
        });

        $lastRead = null;
        if ($request->user()) {
            $lastRead = $this->lastReadService->getLastRead($request->user());
        }

        return view('beranda', compact('juzAmmaSurahs', 'ayatHarian', 'tahlilCount', 'doaCount', 'lastRead'));
    }
}
