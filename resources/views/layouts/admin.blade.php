<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Panel - Lentera Quran' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-slate-100 font-sans antialiased flex flex-col">
    <header class="bg-emerald-800 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
            <div class="flex items-center gap-4">
                <span class="text-xl font-bold">⚙️ Admin Lentera Quran</span>
                <span class="text-xs bg-emerald-700 px-2.5 py-1 rounded-full uppercase tracking-wider font-semibold">
                    {{ Auth::user()->role->label() }}
                </span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('beranda') }}" class="text-sm bg-emerald-700 hover:bg-emerald-600 px-3 py-1.5 rounded text-white font-medium transition">
                    ← Kembali ke Situs
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-emerald-200 hover:text-white transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow flex flex-col md:flex-row gap-6">
        <aside class="w-full md:w-64 shrink-0">
            <nav class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.surah.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.surah.*') || request()->routeIs('admin.ayat.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                    📖 Kelola Surah & Ayat
                </a>
                <a href="{{ route('admin.tahlil.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.tahlil.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                    📿 Kelola Tahlil
                </a>
                <a href="{{ route('admin.doa-category.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.doa-category.*') || request()->routeIs('admin.kategori-doa.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                    📁 Kategori Doa
                </a>
                <a href="{{ route('admin.doa.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.doa.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                    🤲 Kelola Doa
                </a>

                @if(Auth::user()->isSuperAdmin())
                    <div class="pt-4 border-t border-slate-200 mt-4">
                        <span class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Super Admin</span>
                    </div>
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.pengguna.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                        👥 Kelola Pengguna
                    </a>
                @endif
            </nav>
        </aside>

        <main class="flex-grow">
            @if(session('status'))
                <div class="mb-6 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center justify-between">
                    <span>✓ {{ session('status') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium flex items-center justify-between">
                    <span>✕ {{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
