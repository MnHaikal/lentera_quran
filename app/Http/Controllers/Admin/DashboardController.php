<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\LastRead;
use App\Models\MurottalStreamLog;
use App\Models\Surah;
use App\Models\TahlilItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $surahCount = Surah::query()->count() ?: 114;
        $tahlilCount = TahlilItem::query()->count() ?: 24;
        $doaCount = Doa::query()->count() ?: 47;
        $doaCategoryCount = DoaCategory::query()->count() ?: 12;
        $userCount = User::query()->count();
        $usersThisMonth = User::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Real Data Bookmark & Catatan
        $bookmarkCount = Bookmark::query()->count();
        $notesCount = Bookmark::query()->whereNotNull('catatan')->where('catatan', '!=', '')->count();

        // Real Data Surah Terfavorit (dari bookmark surah atau last read)
        $favoriteSurahId = Bookmark::query()->where('bookmarkable_type', 'surah')
            ->selectRaw('bookmarkable_id, count(*) as total')
            ->groupBy('bookmarkable_id')
            ->orderByDesc('total')
            ->value('bookmarkable_id');

        if (!$favoriteSurahId) {
            $favoriteSurahId = LastRead::query()->selectRaw('surah_id, count(*) as total')
                ->groupBy('surah_id')
                ->orderByDesc('total')
                ->value('surah_id');
        }

        $favoriteSurah = $favoriteSurahId
            ? Surah::find($favoriteSurahId)
            : (Surah::find(2) ?? Surah::find(18) ?? Surah::first());

        $favoriteSurahBookmarks = $favoriteSurah
            ? Bookmark::query()->where('bookmarkable_type', 'surah')->where('bookmarkable_id', $favoriteSurah->id)->count()
            : 0;

        // Data Real Surah yang Paling Banyak Didengar Audio / Murottalnya
        $topStreamed = MurottalStreamLog::query()
            ->selectRaw('surah_id, SUM(duration_seconds) as total_seconds, COUNT(*) as total_plays')
            ->groupBy('surah_id')
            ->orderByDesc('total_seconds')
            ->first();

        if ($topStreamed) {
            $mostStreamedSurah = Surah::find($topStreamed->surah_id);
            $mostStreamedSeconds = (int) $topStreamed->total_seconds;
            $mostStreamedPlays = (int) $topStreamed->total_plays;
        } else {
            $mostStreamedSurah = Surah::find(2) ?? Surah::first();
            $mostStreamedSeconds = 0;
            $mostStreamedPlays = 0;
        }

        $topQari = MurottalStreamLog::query()
            ->when($mostStreamedSurah, fn ($q) => $q->where('surah_id', $mostStreamedSurah->id))
            ->select('qari')
            ->groupBy('qari')
            ->orderByRaw('COUNT(*) DESC')
            ->value('qari') ?? 'Misyari Rasyid';

        if ($mostStreamedSeconds >= 3600) {
            $hours = round($mostStreamedSeconds / 3600, 1);
            $mostStreamedDurationText = ($hours == (int) $hours ? (int) $hours : number_format($hours, 1, ',', '.')) . ' Jam diputar';
        } elseif ($mostStreamedSeconds >= 60) {
            $minutes = (int) ceil($mostStreamedSeconds / 60);
            $mostStreamedDurationText = $minutes . ' Menit diputar';
        } elseif ($mostStreamedSeconds > 0) {
            $mostStreamedDurationText = $mostStreamedSeconds . ' Detik diputar';
        } else {
            $mostStreamedDurationText = 'Belum ada pemutaran';
        }

        $mostStreamedSubtitle = "{$mostStreamedDurationText} • Qari: {$topQari}";
        $mostStreamedProgressPercent = $mostStreamedPlays > 0 ? min(100, max(25, $mostStreamedPlays * 30)) : 20;

        // Real Chart Data for Active Users (7d, 30d, 12m)
        $chartData = $this->getUsersChartData();

        return view('admin.dashboard', [
            'surahCount' => $surahCount,
            'tahlilCount' => $tahlilCount,
            'doaCount' => $doaCount,
            'doaCategoryCount' => $doaCategoryCount,
            'userCount' => $userCount,
            'usersThisMonth' => $usersThisMonth,
            'bookmarkCount' => $bookmarkCount,
            'notesCount' => $notesCount,
            'favoriteSurah' => $favoriteSurah,
            'favoriteSurahBookmarks' => $favoriteSurahBookmarks,
            'mostStreamedSurah' => $mostStreamedSurah,
            'mostStreamedDurationText' => $mostStreamedDurationText,
            'mostStreamedSubtitle' => $mostStreamedSubtitle,
            'mostStreamedProgressPercent' => $mostStreamedProgressPercent,
            'mostStreamedPlays' => $mostStreamedPlays,
            'chartData' => $chartData,
        ]);
    }

    private function getUsersChartData(): array
    {
        $now = Carbon::now();
        $totalUsers = User::query()->count();

        // Skala Y dinamis sesuai jumlah total riil pengguna
        if ($totalUsers <= 5) {
            $yMax = 5;
            $yLabels = ['5', '4', '3', '2', '1', '0'];
        } elseif ($totalUsers <= 10) {
            $yMax = 10;
            $yLabels = ['10', '8', '6', '4', '2', '0'];
        } elseif ($totalUsers <= 25) {
            $yMax = 25;
            $yLabels = ['25', '20', '15', '10', '5', '0'];
        } elseif ($totalUsers <= 50) {
            $yMax = 50;
            $yLabels = ['50', '40', '30', '20', '10', '0'];
        } elseif ($totalUsers <= 100) {
            $yMax = 100;
            $yLabels = ['100', '80', '60', '40', '20', '0'];
        } else {
            $ceil = (int) (ceil($totalUsers / 1000) * 1000);
            $yMax = max(1000, $ceil);
            $step = $yMax / 5;
            $yLabels = [
                round($yMax / 1000) . 'k',
                round(($yMax - $step) / 1000) . 'k',
                round(($yMax - $step * 2) / 1000) . 'k',
                round(($yMax - $step * 3) / 1000) . 'k',
                round(($yMax - $step * 4) / 1000) . 'k',
                '0'
            ];
        }

        // 1. Periode 7 Hari (7 titik)
        $points7d = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $count = User::query()->whereDate('created_at', '<=', $dateStr)->count();
            $x = round(60 + ((6 - $i) / 6) * 760, 1);
            $y = round(230 - ($count / $yMax) * 200, 1);
            $points7d[] = [
                'x' => $x,
                'y' => $y,
                'label' => $date->translatedFormat('d M'),
                'date' => $date->translatedFormat('d M Y'),
                'count' => $count,
                'info' => $date->translatedFormat('d M Y') . ' — ' . number_format($count, 0, ',', '.') . ' pengguna aktif',
            ];
        }

        // 2. Periode 30 Hari (11 titik representatif setiap 3 hari)
        $points30d = [];
        $stepDays = [30, 27, 24, 21, 18, 15, 12, 9, 6, 3, 0];
        $totalSteps = count($stepDays);
        foreach ($stepDays as $idx => $sub) {
            $date = $now->copy()->subDays($sub);
            $dateStr = $date->format('Y-m-d');
            $count = User::query()->whereDate('created_at', '<=', $dateStr)->count();
            $x = round(60 + ($idx / ($totalSteps - 1)) * 760, 1);
            $y = round(230 - ($count / $yMax) * 200, 1);
            $points30d[] = [
                'x' => $x,
                'y' => $y,
                'label' => $date->translatedFormat('d M'),
                'date' => $date->translatedFormat('d M Y'),
                'count' => $count,
                'info' => $date->translatedFormat('d M Y') . ' — ' . number_format($count, 0, ',', '.') . ' pengguna aktif',
            ];
        }

        // 3. Periode 12 Bulan (12 titik per bulan)
        $points12m = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = $i === 0 ? $now->copy() : $now->copy()->subMonths($i)->endOfMonth();
            $dateStr = $date->format('Y-m-d');
            $count = User::query()->whereDate('created_at', '<=', $dateStr)->count();
            $x = round(60 + ((11 - $i) / 11) * 760, 1);
            $y = round(230 - ($count / $yMax) * 200, 1);
            $points12m[] = [
                'x' => $x,
                'y' => $y,
                'label' => $date->translatedFormat('M'),
                'date' => $date->translatedFormat('F Y'),
                'count' => $count,
                'info' => $date->translatedFormat('F Y') . ' — ' . number_format($count, 0, ',', '.') . ' pengguna aktif',
            ];
        }

        return [
            'yLabels' => $yLabels,
            'datasets' => [
                '7d' => [
                    'points' => $points7d,
                    'paths' => $this->generateSvgPaths($points7d),
                    'activePoint' => $points7d[count($points7d) - 1],
                ],
                '30d' => [
                    'points' => $points30d,
                    'paths' => $this->generateSvgPaths($points30d),
                    'activePoint' => $points30d[count($points30d) - 1],
                ],
                '12m' => [
                    'points' => $points12m,
                    'paths' => $this->generateSvgPaths($points12m),
                    'activePoint' => $points12m[count($points12m) - 1],
                ],
            ],
        ];
    }

    private function generateSvgPaths(array $points): array
    {
        $n = count($points);
        if ($n === 0) {
            return ['line' => '', 'area' => ''];
        }

        $linePath = "M {$points[0]['x']} {$points[0]['y']}";

        for ($i = 0; $i < $n - 1; $i++) {
            $p0 = $points[$i];
            $p1 = $points[$i + 1];

            $dx = ($p1['x'] - $p0['x']) / 2;
            $cp1x = round($p0['x'] + $dx, 1);
            $cp1y = round($p0['y'], 1);
            $cp2x = round($p0['x'] + $dx, 1);
            $cp2y = round($p1['y'], 1);

            $p1x = round($p1['x'], 1);
            $p1y = round($p1['y'], 1);

            $linePath .= " C {$cp1x} {$cp1y}, {$cp2x} {$cp2y}, {$p1x} {$p1y}";
        }

        $lastX = round($points[$n - 1]['x'], 1);
        $firstX = round($points[0]['x'], 1);
        $areaPath = $linePath . " L {$lastX} 230 L {$firstX} 230 Z";

        return [
            'line' => $linePath,
            'area' => $areaPath,
        ];
    }
}

