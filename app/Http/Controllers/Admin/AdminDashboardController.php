<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ayah;
use App\Models\Bookmark;
use App\Models\Doa;
use App\Models\DoaCategory;
use App\Models\Surah;
use App\Models\TahlilItem;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_surahs' => Surah::count(),
            'total_ayahs' => Ayah::count(),
            'total_tahlil' => TahlilItem::count(),
            'total_doa_categories' => DoaCategory::count(),
            'total_doas' => Doa::count(),
            'total_bookmarks' => Bookmark::count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentBookmarks = Bookmark::with(['user', 'bookmarkable'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentBookmarks'));
    }
}
