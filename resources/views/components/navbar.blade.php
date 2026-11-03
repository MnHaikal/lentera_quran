@php
    $isAuthPage = request()->routeIs('login', 'register', 'password.*');

    $navItems = [
        [
            'label' => 'Beranda',
            'route' => 'beranda',
            'active' => request()->routeIs('beranda'),
            'icon' => 'M3 10.5L12 3l9 7.5v9a1.5 1.5 0 01-1.5 1.5h-4.5v-6h-6v6H4.5A1.5 1.5 0 013 19.5v-9z',
        ],
        [
            'label' => "Al-Qur'an",
            'route' => 'quran.index',
            'active' => request()->routeIs('quran.*'),
            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        ],
        [
            'label' => 'Tahlil',
            'route' => 'tahlil.index',
            'active' => request()->routeIs('tahlil.*'),
            'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
        ],
        [
            'label' => 'Doa',
            'route' => 'doa.index',
            'active' => request()->routeIs('doa.*'),
            'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
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
                    href="{{ route('tersimpan') }}"
                    wire:navigate
                    aria-label="Penanda bacaan tersimpan"
                    class="hidden sm:inline-flex items-center justify-center min-h-[44px] min-w-[44px] rounded-full text-ink-muted hover:text-ink hover:bg-surface-container/60 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                    </svg>
                </a>
            @endauth

            <div x-data="{ themeMenuOpen: false }" class="relative">
                <button
                    type="button"
                    @click="themeMenuOpen = !themeMenuOpen"
                    @keydown.escape.window="themeMenuOpen = false"
                    aria-label="Pilih tema tampilan"
                    aria-haspopup="true"
                    :aria-expanded="themeMenuOpen"
                    class="inline-flex items-center justify-center min-h-[44px] min-w-[44px] rounded-full text-ink-muted hover:text-ink hover:bg-surface-container/60 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                >
                    <svg x-show="$store.theme && $store.theme.current === 'terang'" class="w-5 h-5 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                    <svg x-show="!$store.theme || $store.theme.current !== 'terang'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </button>

                <div
                    x-show="themeMenuOpen"
                    @click.outside="themeMenuOpen = false"
                    x-transition
                    style="display: none;"
                    class="absolute right-0 mt-2 w-40 rounded-card bg-surface-card border border-line shadow-card py-1.5 z-50"
                    role="menu"
                    aria-label="Pilihan tema"
                >
                    @foreach (['terang' => 'Terang', 'gelap' => 'Gelap', 'sistem' => 'Sistem'] as $modeKey => $modeLabel)
                        <button
                            type="button"
                            role="menuitem"
                            @click="$store.theme.set('{{ $modeKey }}'); themeMenuOpen = false"
                            class="w-full min-h-[44px] px-4 py-2 text-left text-body-sm font-medium flex items-center justify-between hover:bg-surface-container transition focus:outline-none focus-visible:bg-surface-container"
                            :class="$store.theme && $store.theme.current === '{{ $modeKey }}' ? 'text-brand-teal font-semibold' : 'text-ink'"
                        >
                            <span>{{ $modeLabel }}</span>
                            <span x-show="$store.theme && $store.theme.current === '{{ $modeKey }}'" class="text-brand-gold" aria-hidden="true">&#10003;</span>
                        </button>
                    @endforeach
                </div>
            </div>

            @auth
                <div x-data="{ accountMenuOpen: false }" class="relative">
                    <button
                        type="button"
                        @click="accountMenuOpen = !accountMenuOpen"
                        @keydown.escape.window="accountMenuOpen = false"
                        aria-label="Menu akun pengguna"
                        aria-haspopup="true"
                        :aria-expanded="accountMenuOpen"
                        class="inline-flex items-center gap-2 min-h-[44px] px-4 py-2 rounded-full border border-line bg-surface-card text-ink text-body-sm font-semibold hover:border-brand-teal transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                    >
                        <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-ink-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div
                        x-show="accountMenuOpen"
                        @click.outside="accountMenuOpen = false"
                        x-transition
                        style="display: none;"
                        class="absolute right-0 mt-2 w-48 rounded-card bg-surface-card border border-line shadow-card py-1.5 z-50 divide-y divide-line"
                        role="menu"
                    >
                        <div class="py-1">
                            @if (Auth::user()->isAdmin())
                                <a
                                    href="{{ route('admin.dashboard') }}"
                                    role="menuitem"
                                    class="w-full min-h-[40px] px-4 py-2 text-left text-body-sm font-semibold text-brand-gold hover:bg-surface-container transition flex items-center gap-2"
                                >
                                    <span>Panel Admin</span>
                                </a>
                            @endif
                            <a
                                href="{{ route('tersimpan') }}"
                                wire:navigate
                                role="menuitem"
                                class="w-full min-h-[40px] px-4 py-2 text-left text-body-sm font-medium text-ink hover:bg-surface-container transition flex items-center gap-2"
                            >
                                <span>Tersimpan</span>
                            </a>
                            <a
                                href="{{ route('pengaturan.edit') }}"
                                wire:navigate
                                role="menuitem"
                                class="w-full min-h-[40px] px-4 py-2 text-left text-body-sm font-medium text-ink hover:bg-surface-container transition flex items-center gap-2"
                            >
                                <span>Pengaturan</span>
                            </a>
                        </div>
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    role="menuitem"
                                    class="w-full min-h-[40px] px-4 py-2 text-left text-body-sm font-semibold text-danger hover:bg-surface-container transition focus:outline-none focus-visible:bg-surface-container"
                                >
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a
                    href="{{ route('login') }}"
                    wire:navigate
                    class="inline-flex items-center justify-center min-h-[44px] px-3 text-body-sm font-semibold text-ink hover:text-brand-teal transition rounded-full focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                >
                    Masuk
                </a>
                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        wire:navigate
                        class="hidden sm:inline-flex items-center justify-center min-h-[40px] px-5 py-2 rounded-full bg-brand-navy text-white text-body-sm font-semibold hover:ring-2 hover:ring-brand-gold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                    >
                        Daftar
                    </a>
                @endif
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
                <svg class="w-5 h-5 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                <span class="text-label-sm">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
@endif
