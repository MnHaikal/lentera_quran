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
                <p class="text-[10px] font-bold tracking-wider uppercase text-[#7CE3B3] flex items-center gap-1 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#7CE3B3]"></span>
                    <span>{{ Auth::user()?->role?->isSuperAdmin() ? 'SUPER ADMIN' : 'ADMIN' }}</span>
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

            {{-- Surah & Ayat --}}
            <a
                href="{{ route('admin.surah.index') }}"
                wire:navigate
                wire:navigate.hover
                class="{{ $isSurahActive ? 'relative flex items-center justify-between px-3.5 py-2.5 rounded-[10px] bg-[#061629] text-white font-semibold text-xs border-l-[3.5px] border-[#E2B14C] shadow-sm' : 'flex items-center justify-between px-3.5 py-2 rounded-[10px] text-[#9AB1C9] hover:text-white hover:bg-white/5 text-xs font-medium transition' }}"
            >
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ $isSurahActive ? 'text-[#E2B14C]' : 'text-[#7F9AB5]' }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Surah &amp; Ayat</span>
                </span>
                @if($isSurahActive)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#E2B14C]"></span>
                @endif
            </a>

            {{-- Tahlil --}}
            <a
                href="{{ route('admin.tahlil.index') }}"
                wire:navigate
                wire:navigate.hover
                class="{{ $isTahlilActive ? 'relative flex items-center justify-between px-3.5 py-2.5 rounded-[10px] bg-[#061629] text-white font-semibold text-xs border-l-[3.5px] border-[#E2B14C] shadow-sm' : 'flex items-center justify-between px-3.5 py-2 rounded-[10px] text-[#9AB1C9] hover:text-white hover:bg-white/5 text-xs font-medium transition' }}"
            >
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ $isTahlilActive ? 'text-[#E2B14C]' : 'text-[#7F9AB5]' }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <span>Tahlil</span>
                </span>
                @if($isTahlilActive)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#E2B14C]"></span>
                @endif
            </a>

            {{-- Doa (Hand with Heart Icon) --}}
            <a
                href="{{ route('admin.doa.index') }}"
                wire:navigate
                wire:navigate.hover
                class="{{ $isDoaActive ? 'relative flex items-center justify-between px-3.5 py-2.5 rounded-[10px] bg-[#061629] text-white font-semibold text-xs border-l-[3.5px] border-[#E2B14C] shadow-sm' : 'flex items-center justify-between px-3.5 py-2 rounded-[10px] text-[#9AB1C9] hover:text-white hover:bg-white/5 text-xs font-medium transition' }}"
            >
                <span class="flex items-center gap-3">
                    <svg class="w-4 h-4 {{ $isDoaActive ? 'text-[#E2B14C]' : 'text-[#7F9AB5]' }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25c-1.35-1.5-3.6-1.5-4.95 0-1.35 1.5-1.35 3.9 0 5.4L12 18.75l4.95-5.1c1.35-1.5 1.35-3.9 0-5.4-1.35-1.5-3.6-1.5-4.95 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 19.5h18" />
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
