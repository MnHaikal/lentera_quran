@php
    $isAuthPage = request()->routeIs('login', 'register', 'password.*');

    $navItems = [
        [
            'label' => 'Beranda',
            'route' => 'beranda',
            'active' => request()->routeIs('beranda'),
            'icon' => 'M3 10.5L12 3l9 7.5v9a1.5 1.5 0 01-1.5 1.5h-4.5v-6h-6v6H4.5A1.5 1.5 0 013 19.5v-9z',
            'is_filled' => false,
        ],
        [
            'label' => "Al-Qur'an",
            'route' => 'quran.index',
            'active' => request()->routeIs('quran.*'),
            'icon' => 'M 18.71 4.15 L 16.63 4.91 L 14.39 5.38 L 13.46 5.80 L 12.49 6.52 L 12.36 8.51 L 12.36 14.56 L 13.38 13.67 L 15.37 12.53 L 17.52 11.60 L 20.74 10.50 Z M 5.33 4.11 L 4.99 4.95 L 4.87 5.63 L 4.40 6.81 L 3.30 10.41 L 3.64 10.62 L 5.63 11.26 L 7.32 11.94 L 8.97 12.70 L 10.37 13.50 L 11.64 14.56 L 11.60 6.56 L 10.75 5.93 L 9.61 5.38 L 6.94 4.78 Z M 3.85 4.19 L 1.65 11.56 L 7.03 14.18 L 6.43 14.86 L 6.56 15.62 L 8.21 14.86 L 8.55 14.98 L 7.37 15.79 L 5.80 17.52 L 3.85 18.58 L 3.64 19.47 L 3.94 19.85 L 11.68 16.04 L 12.40 16.04 L 19.98 19.85 L 20.28 19.64 L 20.36 19.01 L 19.81 18.24 L 18.20 17.52 L 15.45 14.98 L 15.79 14.86 L 17.44 15.62 L 17.65 14.98 L 16.97 14.18 L 22.26 11.60 L 20.11 4.15 L 19.34 4.44 L 21.29 11.09 L 12.06 15.45 L 2.71 11.09 L 4.66 4.53 L 4.53 4.23 Z',
            'is_filled' => true,
        ],
        [
            'label' => 'Tahlil',
            'route' => 'tahlil.index',
            'active' => request()->routeIs('tahlil.*'),
            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'is_filled' => false,
        ],
        [
            'label' => 'Doa',
            'route' => 'doa.index',
            'active' => request()->routeIs('doa.*'),
            'icon' => 'M 16.89 6.06 L 16.69 5.97 L 16.37 5.97 L 16.19 6.06 L 15.93 6.41 L 15.93 6.76 L 16.95 10.78 L 16.98 11.04 L 16.89 11.13 L 16.72 11.01 L 15.47 6.03 L 15.15 5.80 L 14.74 5.80 L 14.48 5.97 L 14.33 6.26 L 14.33 6.52 L 15.50 11.16 L 15.50 11.33 L 15.41 11.42 L 15.23 11.27 L 14.21 7.22 L 13.95 7.02 L 13.57 6.99 L 13.34 7.11 L 13.17 7.34 L 13.14 7.72 L 14.13 11.65 L 14.07 11.85 L 13.95 11.85 L 13.86 11.77 L 13.11 8.62 L 12.93 8.36 L 12.70 8.24 L 12.41 8.24 L 12.20 8.33 L 12.00 8.62 L 11.77 8.36 L 11.59 8.27 L 11.24 8.27 L 10.95 8.48 L 10.83 8.74 L 10.11 11.80 L 10.02 11.88 L 9.84 11.83 L 10.83 7.75 L 10.78 7.31 L 10.63 7.14 L 10.40 7.02 L 10.11 7.02 L 9.90 7.11 L 9.67 7.43 L 8.74 11.30 L 8.59 11.45 L 8.48 11.36 L 9.64 6.55 L 9.64 6.29 L 9.50 6.00 L 9.12 5.80 L 8.74 5.85 L 8.50 6.06 L 8.42 6.23 L 7.25 11.04 L 7.14 11.16 L 7.05 11.13 L 6.99 10.92 L 8.04 6.79 L 8.04 6.44 L 7.89 6.17 L 7.60 6.00 L 7.19 6.03 L 6.90 6.26 L 5.85 10.51 L 6.73 13.05 L 7.11 13.40 L 7.89 13.69 L 8.71 14.18 L 9.23 14.71 L 9.67 15.47 L 9.50 15.58 L 9.00 14.83 L 8.45 14.30 L 7.78 13.92 L 7.05 13.66 L 6.61 13.31 L 6.35 12.87 L 5.62 10.57 L 5.45 10.28 L 5.24 10.11 L 4.83 9.96 L 4.28 10.08 L 4.14 10.25 L 4.11 10.57 L 4.86 14.56 L 5.21 15.47 L 5.59 16.17 L 6.09 16.86 L 6.61 17.45 L 7.14 17.83 L 7.98 18.15 L 8.80 18.20 L 9.52 18.06 L 11.56 17.01 L 11.71 16.75 L 11.97 15.79 L 12.03 15.82 L 12.23 16.63 L 12.44 17.01 L 14.27 17.97 L 14.77 18.12 L 15.58 18.17 L 16.22 18.06 L 16.98 17.71 L 17.59 17.18 L 18.47 15.99 L 18.79 15.38 L 19.11 14.53 L 19.86 10.54 L 19.83 10.22 L 19.69 10.05 L 19.17 9.93 L 18.84 10.02 L 18.61 10.17 L 18.35 10.54 L 17.62 12.84 L 17.36 13.28 L 16.98 13.60 L 16.19 13.89 L 15.52 14.27 L 15.00 14.77 L 14.48 15.55 L 14.39 15.55 L 14.30 15.44 L 14.65 14.80 L 15.26 14.16 L 16.02 13.69 L 16.86 13.37 L 17.24 13.02 L 18.12 10.49 L 17.16 6.44 L 17.07 6.23 Z M 12.00 9.06 L 12.64 11.62 L 12.70 12.20 L 12.61 12.70 L 12.17 13.66 L 11.97 14.39 L 11.80 13.69 L 11.36 12.73 L 11.27 12.03 L 11.91 9.20 Z',
            'is_filled' => true,
        ],
    ];
@endphp

@if ($isAuthPage)
    <header class="sticky top-0 z-40 bg-canvas/95 backdrop-blur border-b border-line/70 transition-colors duration-200">
        <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter h-20 flex items-center justify-between gap-4">
            <a
                href="{{ route('beranda') }}"
                wire:navigate
                wire:navigate.hover
                class="inline-flex items-center gap-2.5 min-h-[44px] rounded-lg px-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
            >
                <img
                    src="{{ asset('images/logo-lentera-quran.png') }}"
                    alt="Lentera Quran"
                    class="h-12 sm:h-14 w-auto object-contain"
                >
                <span class="sr-only">Lentera Quran</span>
            </a>

            <a
                href="{{ route('beranda') }}"
                wire:navigate
                wire:navigate.hover
                class="inline-flex items-center gap-2 min-h-[44px] px-3 rounded-full text-body-sm font-semibold text-ink hover:text-brand-teal transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </header>
@else
<header class="sticky top-0 z-40 bg-canvas/95 backdrop-blur border-b border-line/70 transition-colors duration-200">
    <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter h-20 flex items-center justify-between gap-4">
        <a
            href="{{ route('beranda') }}"
            wire:navigate
            wire:navigate.hover
            class="inline-flex items-center gap-2.5 min-h-[44px] rounded-lg px-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
        >
            <img
                src="{{ asset('images/logo-lentera-quran.png') }}"
                alt="Lentera Quran"
                class="h-12 sm:h-14 w-auto object-contain"
            >
            <span class="sr-only">Lentera Quran</span>
        </a>

        <nav aria-label="Navigasi Utama" class="hidden md:flex items-center gap-6">
            @foreach ($navItems as $item)
                <a
                    href="{{ route($item['route']) }}"
                    wire:navigate
                    wire:navigate.hover
                    @if ($item['active']) aria-current="page" @endif
                    class="relative inline-flex items-center justify-center min-h-[44px] px-1 text-body-md transition duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold rounded {{ $item['active'] ? 'text-ink font-semibold' : 'text-ink-muted font-medium hover:text-ink' }}"
                >
                    <span>{{ $item['label'] }}</span>
                    @if ($item['active'])
                        <span class="absolute bottom-1.5 left-0 right-0 h-[2.5px] rounded-full bg-brand-teal"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            @auth
                <a
                    href="{{ route('bookmarks.index') }}"
                    wire:navigate
                    aria-label="Penanda bacaan tersimpan"
                    title="Penanda bacaan tersimpan"
                    class="hidden sm:inline-flex items-center justify-center min-h-[44px] min-w-[44px] rounded-full text-ink-muted hover:text-brand-gold hover:bg-surface-container/60 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                    </svg>
                </a>
            @endauth

            @auth
                <div x-data="{ accountMenuOpen: false }" class="relative">
                    <button
                        type="button"
                        @click="accountMenuOpen = !accountMenuOpen"
                        @keydown.escape.window="accountMenuOpen = false"
                        aria-label="Menu akun {{ Auth::user()->name }}"
                        aria-haspopup="true"
                        :aria-expanded="accountMenuOpen"
                        class="w-10 h-10 rounded-full bg-[#1C5868] border border-[#4AB3BF]/50 flex items-center justify-center text-xs font-bold text-white shadow-sm hover:ring-2 hover:ring-brand-gold/60 hover:opacity-95 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold shrink-0"
                        title="{{ Auth::user()->name }}"
                    >
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                    </button>

                    <div
                        x-show="accountMenuOpen"
                        @click.outside="accountMenuOpen = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        style="display: none;"
                        class="absolute right-0 mt-2 w-56 rounded-2xl bg-surface-card border border-line shadow-card p-1.5 z-50 overflow-hidden"
                        role="menu"
                    >
                        {{-- Info User (Nama & Email) --}}
                        <div class="px-3.5 py-3 border-b border-line/70 mb-1">
                            <p class="text-body-xs font-bold text-ink truncate leading-snug">
                                {{ Auth::user()->name }}
                            </p>
                            @if (Auth::user()->email)
                                <p class="text-[11px] text-ink-muted truncate mt-0.5">
                                    {{ Auth::user()->email }}
                                </p>
                            @endif
                        </div>

                        {{-- Link ke Dashboard Admin jika User adalah Admin --}}
                        @if (Auth::user()->role?->isAdmin())
                            <a
                                href="{{ route('admin.dashboard') }}"
                                role="menuitem"
                                class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-body-xs font-semibold text-ink hover:bg-surface-container hover:text-brand-navy transition focus:outline-none"
                            >
                                <svg class="w-4 h-4 text-brand-teal shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                <span>Dashboard Admin</span>
                            </a>
                        @endif

                        {{-- Link ke Pengaturan Profil --}}
                        <a
                            href="{{ route('profile.edit') }}"
                            wire:navigate
                            role="menuitem"
                            class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-body-xs font-semibold text-ink hover:bg-surface-container hover:text-brand-navy transition focus:outline-none"
                        >
                            <svg class="w-4 h-4 text-ink-muted shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span>Pengaturan Profil</span>
                        </a>

                        {{-- Tombol Keluar --}}
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button
                                type="submit"
                                role="menuitem"
                                class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-body-xs font-semibold text-danger hover:bg-danger/10 hover:text-danger transition focus:outline-none focus:bg-danger/10"
                            >
                                <svg class="w-4 h-4 text-danger shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a
                    href="{{ route('login') }}"
                    wire:navigate
                    class="inline-flex items-center justify-center min-h-[40px] px-5 py-2 rounded-full bg-brand-navy text-white text-body-sm font-semibold hover:ring-2 hover:ring-brand-gold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                >
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</header>

<nav
    aria-label="Navigasi Bawah Mobile"
    class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-surface-card/95 backdrop-blur border-t border-line shadow-overlay"
>
    <div class="grid grid-cols-4 px-2 py-1">
        @foreach ($navItems as $item)
            <a
                href="{{ route($item['route']) }}"
                wire:navigate
                wire:navigate.hover
                @if ($item['active']) aria-current="page" @endif
                class="flex flex-col items-center justify-center min-h-[52px] min-w-[44px] py-1.5 rounded-lg transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold {{ $item['active'] ? 'text-brand-teal font-semibold' : 'text-ink-muted hover:text-ink' }}"
            >
                @if ($item['is_filled'] ?? false)
                    <svg class="w-5 h-5 mb-0.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="{{ $item['icon'] }}" />
                    </svg>
                @else
                    <svg class="w-5 h-5 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                @endif
                <span class="text-label-sm">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
@endif
