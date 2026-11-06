{{-- Left Sidebar (Deep Navy) --}}
<aside
    :class="sidebarOpen ? 'flex' : 'hidden lg:flex'"
    class="w-full lg:w-[248px] xl:w-[256px] lg:sticky lg:top-0 lg:h-screen shrink-0 bg-[#0D253F] text-white flex-col justify-between border-r border-white/10 select-none overflow-y-auto"
>
    {{-- Top Part of Sidebar --}}
    <div class="p-4 space-y-4">
        {{-- Profile Super Admin Card (Sebelah Kiri / Sidebar) --}}
        <div class="rounded-[12px] bg-[#15314F] border border-[#27486E] px-3.5 py-3 flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-[#1C5868] border border-[#4AB3BF]/40 flex items-center justify-center text-xs font-bold text-white shrink-0 shadow-xs">
                {{ strtoupper(substr(Auth::user()?->name ?? 'SA', 0, 2)) }}
            </div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-white truncate leading-snug">
                    {{ Auth::user()?->name ?? 'Super Admin' }}
                </p>
            </div>
        </div>

        <div class="border-t border-white/10"></div>

        {{-- MENU UTAMA --}}
        <div class="space-y-1">
            <p class="px-2.5 text-[10px] font-bold uppercase tracking-[0.14em] text-[#6E8BA8] mb-1.5">
                MENU UTAMA
            </p>

            {{-- Dashboard --}}
            @php
                $isDashboardActive = request()->routeIs('admin.dashboard') || request()->routeIs('super-admin.dashboard');
                $isSurahActive = request()->routeIs('admin.surah.*');
                $isTahlilActive = request()->routeIs('admin.tahlil.*');
                $isDoaActive = request()->routeIs('admin.doa.*');
                $isDoaCategoryActive = request()->routeIs('admin.doa-category.*');
                $isUsersActive = request()->routeIs('admin.users.*');
            @endphp
            <a
                href="{{ route('admin.dashboard') }}"
                wire:navigate
                wire:navigate.hover
                class="{{ $isDashboardActive ? 'relative flex items-center justify-between px-3.5 py-2.5 rounded-[10px] bg-[#061629] text-white font-semibold text-xs border-l-[3.5px] border-[#E2B14C] shadow-sm' : 'flex items-center justify-between px-3.5 py-2 rounded-[10px] text-[#9AB1C9] hover:text-white hover:bg-white/5 text-xs font-medium transition' }}"
            >
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ $isDashboardActive ? 'text-[#E2B14C]' : 'text-[#7F9AB5]' }} shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>Dashboard</span>
                </span>
                @if($isDashboardActive)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#E2B14C]"></span>
                @endif
            </a>

            {{-- Surah & Ayat (Quran on Rehal Stand) --}}
            <a
                href="{{ route('admin.surah.index') }}"
                wire:navigate
                wire:navigate.hover
                class="{{ $isSurahActive ? 'relative flex items-center justify-between px-3.5 py-2.5 rounded-[10px] bg-[#061629] text-white font-semibold text-xs border-l-[3.5px] border-[#E2B14C] shadow-sm' : 'flex items-center justify-between px-3.5 py-2 rounded-[10px] text-[#9AB1C9] hover:text-white hover:bg-white/5 text-xs font-medium transition' }}"
            >
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ $isSurahActive ? 'text-[#E2B14C]' : 'text-[#7F9AB5]' }} shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M 18.71 4.15 L 16.63 4.91 L 14.39 5.38 L 13.46 5.80 L 12.49 6.52 L 12.36 8.51 L 12.36 14.56 L 13.38 13.67 L 15.37 12.53 L 17.52 11.60 L 20.74 10.50 Z M 5.33 4.11 L 4.99 4.95 L 4.87 5.63 L 4.40 6.81 L 3.30 10.41 L 3.64 10.62 L 5.63 11.26 L 7.32 11.94 L 8.97 12.70 L 10.37 13.50 L 11.64 14.56 L 11.60 6.56 L 10.75 5.93 L 9.61 5.38 L 6.94 4.78 Z M 3.85 4.19 L 1.65 11.56 L 7.03 14.18 L 6.43 14.86 L 6.56 15.62 L 8.21 14.86 L 8.55 14.98 L 7.37 15.79 L 5.80 17.52 L 3.85 18.58 L 3.64 19.47 L 3.94 19.85 L 11.68 16.04 L 12.40 16.04 L 19.98 19.85 L 20.28 19.64 L 20.36 19.01 L 19.81 18.24 L 18.20 17.52 L 15.45 14.98 L 15.79 14.86 L 17.44 15.62 L 17.65 14.98 L 16.97 14.18 L 22.26 11.60 L 20.11 4.15 L 19.34 4.44 L 21.29 11.09 L 12.06 15.45 L 2.71 11.09 L 4.66 4.53 L 4.53 4.23 Z" />
                    </svg>
                    <span>Surah &amp; Ayat</span>
                </span>
                @if($isSurahActive)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#E2B14C]"></span>
                @endif
            </a>

            {{-- Tahlil (Open Quran / Book Icon) --}}
            <a
                href="{{ route('admin.tahlil.index') }}"
                wire:navigate
                wire:navigate.hover
                class="{{ $isTahlilActive ? 'relative flex items-center justify-between px-3.5 py-2.5 rounded-[10px] bg-[#061629] text-white font-semibold text-xs border-l-[3.5px] border-[#E2B14C] shadow-sm' : 'flex items-center justify-between px-3.5 py-2 rounded-[10px] text-[#9AB1C9] hover:text-white hover:bg-white/5 text-xs font-medium transition' }}"
            >
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ $isTahlilActive ? 'text-[#E2B14C]' : 'text-[#7F9AB5]' }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Tahlil</span>
                </span>
                @if($isTahlilActive)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#E2B14C]"></span>
                @endif
            </a>

            {{-- Doa (Dua Hands / Telapak Berdoa) --}}
            <a
                href="{{ route('admin.doa.index') }}"
                wire:navigate
                wire:navigate.hover
                class="{{ $isDoaActive ? 'relative flex items-center justify-between px-3.5 py-2.5 rounded-[10px] bg-[#061629] text-white font-semibold text-xs border-l-[3.5px] border-[#E2B14C] shadow-sm' : 'flex items-center justify-between px-3.5 py-2 rounded-[10px] text-[#9AB1C9] hover:text-white hover:bg-white/5 text-xs font-medium transition' }}"
            >
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ $isDoaActive ? 'text-[#E2B14C]' : 'text-[#7F9AB5]' }} shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M 16.89 6.06 L 16.69 5.97 L 16.37 5.97 L 16.19 6.06 L 15.93 6.41 L 15.93 6.76 L 16.95 10.78 L 16.98 11.04 L 16.89 11.13 L 16.72 11.01 L 15.47 6.03 L 15.15 5.80 L 14.74 5.80 L 14.48 5.97 L 14.33 6.26 L 14.33 6.52 L 15.50 11.16 L 15.50 11.33 L 15.41 11.42 L 15.23 11.27 L 14.21 7.22 L 13.95 7.02 L 13.57 6.99 L 13.34 7.11 L 13.17 7.34 L 13.14 7.72 L 14.13 11.65 L 14.07 11.85 L 13.95 11.85 L 13.86 11.77 L 13.11 8.62 L 12.93 8.36 L 12.70 8.24 L 12.41 8.24 L 12.20 8.33 L 12.00 8.62 L 11.77 8.36 L 11.59 8.27 L 11.24 8.27 L 10.95 8.48 L 10.83 8.74 L 10.11 11.80 L 10.02 11.88 L 9.84 11.83 L 10.83 7.75 L 10.78 7.31 L 10.63 7.14 L 10.40 7.02 L 10.11 7.02 L 9.90 7.11 L 9.67 7.43 L 8.74 11.30 L 8.59 11.45 L 8.48 11.36 L 9.64 6.55 L 9.64 6.29 L 9.50 6.00 L 9.12 5.80 L 8.74 5.85 L 8.50 6.06 L 8.42 6.23 L 7.25 11.04 L 7.14 11.16 L 7.05 11.13 L 6.99 10.92 L 8.04 6.79 L 8.04 6.44 L 7.89 6.17 L 7.60 6.00 L 7.19 6.03 L 6.90 6.26 L 5.85 10.51 L 6.73 13.05 L 7.11 13.40 L 7.89 13.69 L 8.71 14.18 L 9.23 14.71 L 9.67 15.47 L 9.50 15.58 L 9.00 14.83 L 8.45 14.30 L 7.78 13.92 L 7.05 13.66 L 6.61 13.31 L 6.35 12.87 L 5.62 10.57 L 5.45 10.28 L 5.24 10.11 L 4.83 9.96 L 4.28 10.08 L 4.14 10.25 L 4.11 10.57 L 4.86 14.56 L 5.21 15.47 L 5.59 16.17 L 6.09 16.86 L 6.61 17.45 L 7.14 17.83 L 7.98 18.15 L 8.80 18.20 L 9.52 18.06 L 11.56 17.01 L 11.71 16.75 L 11.97 15.79 L 12.03 15.82 L 12.23 16.63 L 12.44 17.01 L 14.27 17.97 L 14.77 18.12 L 15.58 18.17 L 16.22 18.06 L 16.98 17.71 L 17.59 17.18 L 18.47 15.99 L 18.79 15.38 L 19.11 14.53 L 19.86 10.54 L 19.83 10.22 L 19.69 10.05 L 19.17 9.93 L 18.84 10.02 L 18.61 10.17 L 18.35 10.54 L 17.62 12.84 L 17.36 13.28 L 16.98 13.60 L 16.19 13.89 L 15.52 14.27 L 15.00 14.77 L 14.48 15.55 L 14.39 15.55 L 14.30 15.44 L 14.65 14.80 L 15.26 14.16 L 16.02 13.69 L 16.86 13.37 L 17.24 13.02 L 18.12 10.49 L 17.16 6.44 L 17.07 6.23 Z M 12.00 9.06 L 12.64 11.62 L 12.70 12.20 L 12.61 12.70 L 12.17 13.66 L 11.97 14.39 L 11.80 13.69 L 11.36 12.73 L 11.27 12.03 L 11.91 9.20 Z" />
                    </svg>
                    <span>Doa</span>
                </span>
                @if($isDoaActive)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#E2B14C]"></span>
                @endif
            </a>

            {{-- Kategori Doa (Triangle, Square, Circle Shapes Icon) --}}
            <a
                href="{{ route('admin.doa-category.index') }}"
                wire:navigate
                wire:navigate.hover
                class="{{ $isDoaCategoryActive ? 'relative flex items-center justify-between px-3.5 py-2.5 rounded-[10px] bg-[#061629] text-white font-semibold text-xs border-l-[3.5px] border-[#E2B14C] shadow-sm' : 'flex items-center justify-between px-3.5 py-2 rounded-[10px] text-[#9AB1C9] hover:text-white hover:bg-white/5 text-xs font-medium transition' }}"
            >
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ $isDoaCategoryActive ? 'text-[#E2B14C]' : 'text-[#7F9AB5]' }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l4.5 7.5h-9L12 3z" />
                        <rect x="4" y="14" width="6" height="6" rx="1" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="17" cy="17" r="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Kategori Doa</span>
                </span>
                @if($isDoaCategoryActive)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#E2B14C]"></span>
                @endif
            </a>

            {{-- Pengguna & Jamaah --}}
            <a
                href="{{ route('admin.users.index') }}"
                wire:navigate
                wire:navigate.hover
                class="{{ $isUsersActive ? 'relative flex items-center justify-between px-3.5 py-2.5 rounded-[10px] bg-[#061629] text-white font-semibold text-xs border-l-[3.5px] border-[#E2B14C] shadow-sm' : 'flex items-center justify-between px-3.5 py-2 rounded-[10px] text-[#9AB1C9] hover:text-white hover:bg-white/5 text-xs font-medium transition' }}"
            >
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ $isUsersActive ? 'text-[#E2B14C]' : 'text-[#7F9AB5]' }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <span>Pengguna &amp; Jamaah</span>
                </span>
                @if($isUsersActive)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#E2B14C]"></span>
                @endif
            </a>
        </div>
    </div>

    {{-- Bottom Part of Sidebar (Pinned to bottom of viewport) --}}
    <div class="p-3.5 border-t border-white/10 bg-[#0A1E34]">
        {{-- Footer Action: Keluar --}}
        @auth
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs text-[#FF6B6B] hover:text-white hover:bg-[#FF6B6B]/20 font-semibold transition"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    <span>Keluar dari Admin</span>
                </button>
            </form>
        @else
            <a
                href="{{ route('beranda') }}"
                class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs text-[#FF6B6B] hover:text-white hover:bg-[#FF6B6B]/20 font-semibold transition"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                <span>Keluar</span>
            </a>
        @endauth
    </div>
</aside>
