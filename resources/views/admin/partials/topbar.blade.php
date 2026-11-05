{{-- Top Header Bar --}}
<header
    class="sticky top-0 z-30 bg-[#FFFDF7] dark:bg-[#0D213A] border-b border-[#EAE3D2] dark:border-white/10 px-5 sm:px-7 py-3.5 flex items-center justify-between gap-4 shadow-xs"
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
            </div>
        @elseif(request()->routeIs('admin.surah.*'))
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
                    Surah &amp; Ayat
                </h1>
            </div>
        @elseif(request()->routeIs('admin.tahlil.*'))
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
                    Bacaan Tahlil
                </h1>
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
            </div>
        @elseif(request()->routeIs('admin.users.*'))
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
                    Kelola Pengguna &amp; Peran
                </h1>
            </div>
        @endif
    </div>

    {{-- Right Actions: Logo --}}
    <div class="flex items-center gap-3 sm:gap-4 ml-auto shrink-0">
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
