{{-- Row 1: Quick Action Banner --}}
<section
    id="pusat-kendali"
    class="bg-white dark:bg-[#0D213A] rounded-2xl border border-[#EAE3D2] dark:border-white/10 px-5 py-4 sm:px-6 sm:py-4 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-4"
>
    <div class="max-w-2xl">
        <p class="text-xs sm:text-[13px] text-[#5B6B7A] dark:text-[#A9BDD3] leading-relaxed">
            Kelola basis data ayat, kurasi rangkaian doa &amp; tahlil, serta pantau aktivitas tilawah jamaah secara terintegrasi dengan Mushaf Standar Indonesia Kemenag RI.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3 shrink-0">
        <a
            href="{{ route('quran.index') }}"
            wire:navigate
            wire:navigate.hover
            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-full border border-[#9BB0C5] dark:border-white/20 bg-white dark:bg-[#132C4B] text-[#0F2D4F] dark:text-white text-xs font-bold hover:border-[#2A7B84] transition shadow-2xs"
        >
            <svg class="w-3.5 h-3.5 text-[#2A7B84]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            <span>Ekspor Data (.xlsx)</span>
        </a>

        <a
            href="{{ route('admin.doa.index') }}"
            wire:navigate
            wire:navigate.hover
            class="inline-flex items-center justify-center gap-1.5 px-5 py-2 rounded-full bg-[#E2B14C] hover:bg-[#D19F3B] text-[#0F2D4F] text-xs font-bold shadow-sm transition"
        >
            <span class="text-sm font-bold leading-none">+</span>
            <span>Tambah Konten Baru</span>
        </a>
    </div>
</section>
