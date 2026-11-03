{{-- Top Header Bar --}}
<header
    class="bg-[#FFFDF7] dark:bg-[#0D213A] border-b border-[#EAE3D2] dark:border-white/10 px-5 sm:px-7 py-3.5 flex items-center justify-between gap-4"
>
    {{-- Left: Page Title --}}
    <div class="flex items-center gap-2.5 min-w-0">
        @if(View::hasSection('topbar_title'))
            @yield('topbar_title')
        @elseif(request()->routeIs('admin.dashboard', 'super-admin.dashboard'))
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
                    Pusat Kendali &amp; Kurasi Konten
                </h1>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#F6EBD1] dark:bg-[#2B261D] text-[#A87B24] dark:text-[#E2B14C] text-[11px] font-bold shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D9A94A]"></span>
                    <span>Live Server</span>
                </span>
            </div>
        @elseif(request()->routeIs('admin.surah.*'))
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
                    Surah &amp; Ayat
                </h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#FDF8EB] dark:bg-[#2B261D] text-[#A66C0C] dark:text-[#E2B14C] border border-[#F3DFC1] dark:border-white/10 shrink-0">
                    Mushaf Standar RI
                </span>
            </div>
        @elseif(request()->routeIs('admin.tahlil.*'))
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
                    Bacaan Tahlil
                </h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#E1F1F1] dark:bg-[#16363B] text-[#1B6B73] dark:text-[#7CE3B3] text-[11px] font-bold shrink-0">
                    {{ $totalTahlil ?? 24 }} Bacaan
                </span>
            </div>
        @elseif(request()->routeIs('admin.doa.*'))
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
                    Kumpulan Doa
                </h1>
            </div>
        @elseif(request()->routeIs('admin.doa-category.*'))
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
                    Kategori Doa
                </h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#FDF8EB] dark:bg-[#2B261D] text-[#A66C0C] dark:text-[#E2B14C] border border-[#F3DFC1] dark:border-white/10 shrink-0">
                    Total {{ $totalCategories ?? 12 }} Kategori
                </span>
            </div>
        @elseif(request()->routeIs('admin.users.*'))
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
                    Kelola Pengguna &amp; Peran
                </h1>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#0D253F] dark:bg-[#071526] text-[#D9A94A] border border-[#27486E] dark:border-white/10 shrink-0">
                    <svg class="w-3.5 h-3.5 text-[#D9A94A]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944z" clip-rule="evenodd" />
                    </svg>
                    <span>Khusus Super Admin</span>
                </span>
            </div>
        @endif
    </div>

    {{-- Right Actions: Theme, Notif & Logo --}}
    <div class="flex items-center gap-3 sm:gap-4 ml-auto shrink-0">
        {{-- Theme Switcher Dropdown (Matching Mockup: Terang, Gelap, Sistem) --}}
        <div x-data="{ themeMenuOpen: false }" class="relative">
            <button
                type="button"
                @click="themeMenuOpen = !themeMenuOpen"
                @keydown.escape.window="themeMenuOpen = false"
                aria-label="Pilih tema tampilan"
                :aria-expanded="themeMenuOpen"
                class="w-9 h-9 rounded-full flex items-center justify-center text-[#4A5B6C] dark:text-[#9AB1C9] hover:bg-black/5 dark:hover:bg-white/10 hover:text-[#0F1E36] dark:hover:text-white transition focus:outline-none"
            >
                {{-- Sun Icon for Light Theme --}}
                <svg
                    x-show="$store.theme && $store.theme.current === 'terang'"
                    class="w-5 h-5 text-[#D9A94A]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                    aria-hidden="true"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                </svg>

                {{-- Moon Icon for Dark Theme --}}
                <svg
                    x-show="$store.theme && $store.theme.current === 'gelap'"
                    class="w-5 h-5 text-[#9BE8F0]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                    aria-hidden="true"
                    style="display: none;"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                </svg>

                {{-- System / Auto Icon --}}
                <svg
                    x-show="!$store.theme || $store.theme.current === 'sistem'"
                    class="w-5 h-5 text-[#788797] dark:text-[#9AB1C9]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                    aria-hidden="true"
                    style="display: none;"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0H3" />
                </svg>
            </button>

            {{-- Dropdown Menu (Exact match with screenshot 2) --}}
            <div
                x-show="themeMenuOpen"
                @click.outside="themeMenuOpen = false"
                x-transition
                style="display: none;"
                class="absolute right-0 mt-2 w-40 rounded-2xl bg-white dark:bg-[#132C4B] border border-[#EAE3D2] dark:border-white/10 shadow-xl py-2 z-50 overflow-hidden"
                role="menu"
                aria-label="Pilihan tema"
            >
                @foreach (['terang' => 'Terang', 'gelap' => 'Gelap', 'sistem' => 'Sistem'] as $modeKey => $modeLabel)
                    <button
                        type="button"
                        role="menuitem"
                        @click="$store.theme.set('{{ $modeKey }}'); themeMenuOpen = false"
                        class="w-full px-4 py-2.5 text-left text-xs font-semibold flex items-center justify-between hover:bg-[#FAF7F0] dark:hover:bg-white/10 transition focus:outline-none"
                        :class="$store.theme && $store.theme.current === '{{ $modeKey }}' ? 'text-[#0E7B87] dark:text-[#7CE3B3] font-bold' : 'text-[#0F1E36] dark:text-[#E2EEF8]'"
                    >
                        <span>{{ $modeLabel }}</span>
                        <svg
                            x-show="$store.theme && $store.theme.current === '{{ $modeKey }}'"
                            class="w-4 h-4 text-[#D9A94A]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Notification Bell with Badge 3 --}}
        <button
            type="button"
            title="Notifikasi Kurasi (3)"
            class="relative w-9 h-9 rounded-full flex items-center justify-center text-[#4A5B6C] dark:text-[#9AB1C9] hover:bg-black/5 dark:hover:bg-white/10 transition"
        >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
            <span class="absolute top-0.5 right-0.5 w-4 h-4 rounded-full bg-[#D9383A] text-white text-[9px] font-bold flex items-center justify-center shadow-sm">
                3
            </span>
        </button>

        <div class="h-7 w-px bg-[#E5DEC9] dark:bg-white/10 hidden sm:block"></div>

        {{-- Logo Lentera Quran (Sebelah Kanan Atas) --}}
        <a
            href="{{ route('beranda') }}"
            wire:navigate
            wire:navigate.hover
            class="flex items-center group focus:outline-none"
            title="Lentera Quran — Kembali ke Beranda"
        >
            <img
                src="{{ asset('images/logo-lentera-quran.png') }}"
                alt="Lentera Quran"
                class="h-9 sm:h-10 w-auto object-contain hover:opacity-90 transition"
            >
        </a>
    </div>
</header>
