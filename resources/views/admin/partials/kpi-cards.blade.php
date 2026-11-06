{{-- Row 2: 4 KPI Cards (Clickable) --}}
<section aria-label="Ringkasan Metrik Utama" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    {{-- KPI 1: Total Bookmark & Catatan -> Menuju ke Pengguna & Jamaah --}}
    <a
        href="{{ route('admin.users.index') }}"
        wire:navigate
        wire:navigate.hover
        title="Buka Pengguna & Jamaah"
        :class="darkPreview ? 'bg-[#0F2440] border-white/10 hover:border-[#E2B14C]/70' : 'bg-white border-[#EAE3D2] hover:border-[#E2B14C]'"
        class="bg-white rounded-2xl border border-[#EAE3D2] p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group cursor-pointer block"
    >
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <p :class="darkPreview ? 'text-[#A9BDD3]' : 'text-[#5B6B7A]'" class="text-xs font-semibold text-[#5B6B7A] group-hover:text-[#0F2D4F] dark:group-hover:text-white transition-colors truncate">
                    Total Bookmark &amp; Catatan
                </p>
            </div>
            <span class="w-8 h-8 rounded-lg bg-[#FDF3D7] text-[#D9A94A] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                </svg>
            </span>
        </div>

        <div class="flex items-baseline gap-2.5 mt-1.5">
            <p :class="darkPreview ? 'text-white' : 'text-[#0F2D4F]'" class="text-2xl sm:text-[26px] font-extrabold text-[#0F2D4F] tracking-tight">
                {{ number_format($bookmarkCount ?? 0, 0, ',', '.') }}
            </p>
            <span class="inline-flex items-center gap-0.5 text-[11px] font-bold text-[#D99B26]">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                </svg>
                <span>{{ ($notesCount ?? 0) > 0 ? ($notesCount . ' Catatan') : (($bookmarkCount ?? 0) . ' Penanda') }}</span>
            </span>
        </div>

        <div class="h-1.5 w-full rounded-full bg-[#F2EFE4] overflow-hidden mt-4">
            <div class="h-full rounded-full bg-[#E2B14C]" style="width: {{ ($bookmarkCount ?? 0) > 0 ? min(100, max(25, ($bookmarkCount ?? 1) * 25)) : 25 }}%;"></div>
        </div>
    </a>

    {{-- KPI 2: Surah Terfavorit -> Menuju ke Surah & Ayat --}}
    <a
        href="{{ route('admin.surah.index') }}"
        wire:navigate
        wire:navigate.hover
        title="Buka Surah & Ayat"
        :class="darkPreview ? 'bg-[#0F2440] border-white/10 hover:border-[#4B90D8]/70' : 'bg-white border-[#EAE3D2] hover:border-[#1C3554]'"
        class="bg-white rounded-2xl border border-[#EAE3D2] p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group cursor-pointer block"
    >
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <p :class="darkPreview ? 'text-[#A9BDD3]' : 'text-[#5B6B7A]'" class="text-xs font-semibold text-[#5B6B7A] group-hover:text-[#0F2D4F] dark:group-hover:text-white transition-colors truncate">
                    Surah Terfavorit
                </p>
            </div>
            <span class="w-8 h-8 rounded-lg bg-[#EBF1F8] text-[#0F2D4F] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M 18.71 4.15 L 16.63 4.91 L 14.39 5.38 L 13.46 5.80 L 12.49 6.52 L 12.36 8.51 L 12.36 14.56 L 13.38 13.67 L 15.37 12.53 L 17.52 11.60 L 20.74 10.50 Z M 5.33 4.11 L 4.99 4.95 L 4.87 5.63 L 4.40 6.81 L 3.30 10.41 L 3.64 10.62 L 5.63 11.26 L 7.32 11.94 L 8.97 12.70 L 10.37 13.50 L 11.64 14.56 L 11.60 6.56 L 10.75 5.93 L 9.61 5.38 L 6.94 4.78 Z M 3.85 4.19 L 1.65 11.56 L 7.03 14.18 L 6.43 14.86 L 6.56 15.62 L 8.21 14.86 L 8.55 14.98 L 7.37 15.79 L 5.80 17.52 L 3.85 18.58 L 3.64 19.47 L 3.94 19.85 L 11.68 16.04 L 12.40 16.04 L 19.98 19.85 L 20.28 19.64 L 20.36 19.01 L 19.81 18.24 L 18.20 17.52 L 15.45 14.98 L 15.79 14.86 L 17.44 15.62 L 17.65 14.98 L 16.97 14.18 L 22.26 11.60 L 20.11 4.15 L 19.34 4.44 L 21.29 11.09 L 12.06 15.45 L 2.71 11.09 L 4.66 4.53 L 4.53 4.23 Z" />
                </svg>
            </span>
        </div>

        <div class="mt-1">
            <p :class="darkPreview ? 'text-white' : 'text-[#0F2D4F]'" class="text-xl sm:text-[21px] font-extrabold text-[#0F2D4F] tracking-tight leading-snug truncate" title="QS. {{ $favoriteSurah->nama_latin ?? 'Al-Baqarah' }}">
                QS. {{ $favoriteSurah->nama_latin ?? 'Al-Baqarah' }}
            </p>
            <p :class="darkPreview ? 'text-[#A9BDD3]' : 'text-[#6E7E8D]'" class="text-[11px] text-[#6E7E8D] mt-0.5 truncate">
                {{ ($favoriteSurahBookmarks ?? 0) > 0 ? ($favoriteSurahBookmarks . ' penanda jamaah') : (($favoriteSurah->jumlah_ayat ?? 286) . ' Ayat') }} &bull; {{ ucfirst($favoriteSurah->tempat_turun ?? 'Madinah') }}
            </p>
        </div>

        <div class="h-1.5 w-full rounded-full bg-[#F2EFE4] overflow-hidden mt-3">
            <div class="h-full w-[82%] rounded-full bg-[#1C3554]"></div>
        </div>
    </a>

    {{-- KPI 3: Doa Terfavorit -> Menuju ke Kumpulan Doa --}}
    <a
        href="{{ route('admin.doa.index') }}"
        wire:navigate
        wire:navigate.hover
        title="Buka Kumpulan Doa"
        :class="darkPreview ? 'bg-[#0F2440] border-white/10 hover:border-[#D35400]/70' : 'bg-white border-[#EAE3D2] hover:border-[#D35400]'"
        class="bg-white rounded-2xl border border-[#EAE3D2] p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group cursor-pointer block"
    >
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <p :class="darkPreview ? 'text-[#A9BDD3]' : 'text-[#5B6B7A]'" class="text-xs font-semibold text-[#5B6B7A] group-hover:text-[#0F2D4F] dark:group-hover:text-white transition-colors truncate">
                    Doa Terfavorit
                </p>
            </div>
            <span class="w-8 h-8 rounded-lg bg-[#FDF0ED] text-[#D35400] dark:bg-[#D35400]/20 dark:text-[#E67E22] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M 16.89 6.06 L 16.69 5.97 L 16.37 5.97 L 16.19 6.06 L 15.93 6.41 L 15.93 6.76 L 16.95 10.78 L 16.98 11.04 L 16.89 11.13 L 16.72 11.01 L 15.47 6.03 L 15.15 5.80 L 14.74 5.80 L 14.48 5.97 L 14.33 6.26 L 14.33 6.52 L 15.50 11.16 L 15.50 11.33 L 15.41 11.42 L 15.23 11.27 L 14.21 7.22 L 13.95 7.02 L 13.57 6.99 L 13.34 7.11 L 13.17 7.34 L 13.14 7.72 L 14.13 11.65 L 14.07 11.85 L 13.95 11.85 L 13.86 11.77 L 13.11 8.62 L 12.93 8.36 L 12.70 8.24 L 12.41 8.24 L 12.20 8.33 L 12.00 8.62 L 11.77 8.36 L 11.59 8.27 L 11.24 8.27 L 10.95 8.48 L 10.83 8.74 L 10.11 11.80 L 10.02 11.88 L 9.84 11.83 L 10.83 7.75 L 10.78 7.31 L 10.63 7.14 L 10.40 7.02 L 10.11 7.02 L 9.90 7.11 L 9.67 7.43 L 8.74 11.30 L 8.59 11.45 L 8.48 11.36 L 9.64 6.55 L 9.64 6.29 L 9.50 6.00 L 9.12 5.80 L 8.74 5.85 L 8.50 6.06 L 8.42 6.23 L 7.25 11.04 L 7.14 11.16 L 7.05 11.13 L 6.99 10.92 L 8.04 6.79 L 8.04 6.44 L 7.89 6.17 L 7.60 6.00 L 7.19 6.03 L 6.90 6.26 L 5.85 10.51 L 6.73 13.05 L 7.11 13.40 L 7.89 13.69 L 8.71 14.18 L 9.23 14.71 L 9.67 15.47 L 9.50 15.58 L 9.00 14.83 L 8.45 14.30 L 7.78 13.92 L 7.05 13.66 L 6.61 13.31 L 6.35 12.87 L 5.62 10.57 L 5.45 10.28 L 5.24 10.11 L 4.83 9.96 L 4.28 10.08 L 4.14 10.25 L 4.11 10.57 L 4.86 14.56 L 5.21 15.47 L 5.59 16.17 L 6.09 16.86 L 6.61 17.45 L 7.14 17.83 L 7.98 18.15 L 8.80 18.20 L 9.52 18.06 L 11.56 17.01 L 11.71 16.75 L 11.97 15.79 L 12.03 15.82 L 12.23 16.63 L 12.44 17.01 L 14.27 17.97 L 14.77 18.12 L 15.58 18.17 L 16.22 18.06 L 16.98 17.71 L 17.59 17.18 L 18.47 15.99 L 18.79 15.38 L 19.11 14.53 L 19.86 10.54 L 19.83 10.22 L 19.69 10.05 L 19.17 9.93 L 18.84 10.02 L 18.61 10.17 L 18.35 10.54 L 17.62 12.84 L 17.36 13.28 L 16.98 13.60 L 16.19 13.89 L 15.52 14.27 L 15.00 14.77 L 14.48 15.55 L 14.39 15.55 L 14.30 15.44 L 14.65 14.80 L 15.26 14.16 L 16.02 13.69 L 16.86 13.37 L 17.24 13.02 L 18.12 10.49 L 17.16 6.44 L 17.07 6.23 Z M 12.00 9.06 L 12.64 11.62 L 12.70 12.20 L 12.61 12.70 L 12.17 13.66 L 11.97 14.39 L 11.80 13.69 L 11.36 12.73 L 11.27 12.03 L 11.91 9.20 Z" />
                </svg>
            </span>
        </div>

        <div class="mt-1">
            <p :class="darkPreview ? 'text-white' : 'text-[#0F2D4F]'" class="text-xl sm:text-[21px] font-extrabold text-[#0F2D4F] tracking-tight leading-snug truncate" title="{{ $favoriteDoa->judul ?? 'Doa Pilihan' }}">
                {{ $favoriteDoa->judul ?? 'Doa Pilihan' }}
            </p>
            <p :class="darkPreview ? 'text-[#A9BDD3]' : 'text-[#6E7E8D]'" class="text-[11px] text-[#6E7E8D] mt-0.5 truncate">
                {{ ($favoriteDoaBookmarks ?? 0) > 0 ? ($favoriteDoaBookmarks . ' penanda jamaah') : ($favoriteDoa?->doaCategory?->nama ?? 'Doa Harian') }} &bull; {{ $favoriteDoa?->sumber ?? 'Al-Qur\'an' }}
            </p>
        </div>

        <div class="h-1.5 w-full rounded-full bg-[#F2EFE4] overflow-hidden mt-3">
            <div class="h-full rounded-full bg-[#D35400]" style="width: {{ $favoriteDoaProgressPercent ?? 65 }}%;"></div>
        </div>
    </a>

    {{-- KPI 4: Murottal Paling Banyak Didengar -> Menuju ke Surah & Ayat --}}
    <a
        href="{{ route('admin.surah.index') }}"
        wire:navigate
        wire:navigate.hover
        title="Buka Audio Murottal Surah"
        :class="darkPreview ? 'bg-[#0F2440] border-white/10 hover:border-[#2A7B84]/70' : 'bg-white border-[#EAE3D2] hover:border-[#2A7B84]'"
        class="bg-white rounded-2xl border border-[#EAE3D2] p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group cursor-pointer block"
    >
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <p :class="darkPreview ? 'text-[#A9BDD3]' : 'text-[#5B6B7A]'" class="text-xs font-semibold text-[#5B6B7A] group-hover:text-[#0F2D4F] dark:group-hover:text-white transition-colors truncate">
                    Murottal Paling Banyak Didengar
                </p>
            </div>
            <span class="w-8 h-8 rounded-lg bg-[#E4F3F3] text-[#1D6D75] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 3a9 9 0 00-9 9v6a3 3 0 003 3h1a1 1 0 001-1v-6a1 1 0 00-1-1H5v-1a7 7 0 1114 0v1h-2a1 1 0 00-1 1v6a1 1 0 001 1h1a3 3 0 003-3v-6a9 9 0 00-9-9z" />
                </svg>
            </span>
        </div>

        <div class="mt-1">
            <p :class="darkPreview ? 'text-white' : 'text-[#0F2D4F]'" class="text-xl sm:text-[21px] font-extrabold text-[#0F2D4F] tracking-tight leading-snug truncate" title="QS. {{ $mostStreamedSurah->nama_latin ?? 'Al-Baqarah' }}">
                QS. {{ $mostStreamedSurah->nama_latin ?? 'Al-Baqarah' }}
            </p>
            <p class="text-[11px] font-semibold text-[#1D6D75] mt-0.5 truncate">
                {{ $mostStreamedSubtitle ?? 'Belum ada pemutaran' }}
            </p>
        </div>

        <div class="h-1.5 w-full rounded-full bg-[#F2EFE4] overflow-hidden mt-3">
            <div class="h-full rounded-full bg-[#2A7B84]" style="width: {{ $mostStreamedProgressPercent ?? 50 }}%;"></div>
        </div>
    </a>
</section>
