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
                        @if (Auth::user()->isAdmin())
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

                        <a
                            href="{{ route('tersimpan') }}"
                            role="menuitem"
                            class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-body-xs font-semibold text-ink hover:bg-surface-container hover:text-brand-navy transition focus:outline-none"
                        >
                            <svg class="w-4 h-4 text-brand-teal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                            </svg>
                            <span>Tersimpan</span>
                        </a>

                        <a
                            href="{{ route('profile.edit') }}"
                            role="menuitem"
                            class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-body-xs font-semibold text-ink hover:bg-surface-container hover:text-brand-navy transition focus:outline-none"
                        >
                            <svg class="w-4 h-4 text-brand-teal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span>Profil Saya</span>
                        </a>

                        <a
                            href="{{ route('pengaturan.edit') }}"
                            role="menuitem"
                            class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-body-xs font-semibold text-ink hover:bg-surface-container hover:text-brand-navy transition focus:outline-none"
                        >
                            <svg class="w-4 h-4 text-brand-teal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                            </svg>
                            <span>Pengaturan</span>
                        </a>

                        <div class="border-t border-line/70 my-1"></div>

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
                <svg class="w-5 h-5 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                <span class="text-label-sm">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
@endif
