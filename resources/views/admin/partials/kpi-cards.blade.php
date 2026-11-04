{{-- Row 2: 3 KPI Cards --}}
<section aria-label="Ringkasan Metrik Utama" class="grid grid-cols-1 md:grid-cols-3 gap-4">
    {{-- KPI 1: Total Bookmark & Catatan --}}
    <article
        :class="darkPreview ? 'bg-[#0F2440] border-white/10' : 'bg-white border-[#EAE3D2]'"
        class="bg-white rounded-2xl border border-[#EAE3D2] p-4 sm:p-5 shadow-sm flex flex-col justify-between"
    >
        <div class="flex items-start justify-between gap-3">
            <p :class="darkPreview ? 'text-[#A9BDD3]' : 'text-[#5B6B7A]'" class="text-xs font-semibold text-[#5B6B7A]">
                Total Bookmark &amp; Catatan
            </p>
            <span class="w-8 h-8 rounded-lg bg-[#FDF3D7] text-[#D9A94A] flex items-center justify-center shrink-0">
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
    </article>

    {{-- KPI 2: Surah Terfavorit --}}
    <article
        :class="darkPreview ? 'bg-[#0F2440] border-white/10' : 'bg-white border-[#EAE3D2]'"
        class="bg-white rounded-2xl border border-[#EAE3D2] p-4 sm:p-5 shadow-sm flex flex-col justify-between"
    >
        <div class="flex items-start justify-between gap-3">
            <p :class="darkPreview ? 'text-[#A9BDD3]' : 'text-[#5B6B7A]'" class="text-xs font-semibold text-[#5B6B7A]">
                Surah Terfavorit
            </p>
            <span class="w-8 h-8 rounded-lg bg-[#EBF1F8] text-[#0F2D4F] flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                </svg>
            </span>
        </div>

        <div class="mt-1">
            <p :class="darkPreview ? 'text-white' : 'text-[#0F2D4F]'" class="text-xl sm:text-[21px] font-extrabold text-[#0F2D4F] tracking-tight leading-snug">
                QS. {{ $favoriteSurah->nama_latin ?? 'Al-Baqarah' }}
            </p>
            <p :class="darkPreview ? 'text-[#A9BDD3]' : 'text-[#6E7E8D]'" class="text-[11px] text-[#6E7E8D] mt-0.5">
                {{ ($favoriteSurahBookmarks ?? 0) > 0 ? ($favoriteSurahBookmarks . ' penanda jamaah') : (($favoriteSurah->jumlah_ayat ?? 286) . ' Ayat') }} &bull; {{ ucfirst($favoriteSurah->tempat_turun ?? 'Madinah') }}
            </p>
        </div>

        <div class="h-1.5 w-full rounded-full bg-[#F2EFE4] overflow-hidden mt-3">
            <div class="h-full w-[82%] rounded-full bg-[#1C3554]"></div>
        </div>
    </article>

    {{-- KPI 3: Murottal Paling Banyak Didengar (Headphones Icon) --}}
    <article
        :class="darkPreview ? 'bg-[#0F2440] border-white/10' : 'bg-white border-[#EAE3D2]'"
        class="bg-white rounded-2xl border border-[#EAE3D2] p-4 sm:p-5 shadow-sm flex flex-col justify-between"
    >
        <div class="flex items-start justify-between gap-3">
            <p :class="darkPreview ? 'text-[#A9BDD3]' : 'text-[#5B6B7A]'" class="text-xs font-semibold text-[#5B6B7A]">
                Murottal Paling Banyak Didengar
            </p>
            <span class="w-8 h-8 rounded-lg bg-[#E4F3F3] text-[#1D6D75] flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 3a9 9 0 00-9 9v6a3 3 0 003 3h1a1 1 0 001-1v-6a1 1 0 00-1-1H5v-1a7 7 0 1114 0v1h-2a1 1 0 00-1 1v6a1 1 0 001 1h1a3 3 0 003-3v-6a9 9 0 00-9-9z" />
                </svg>
            </span>
        </div>

        <div class="mt-1">
            <p :class="darkPreview ? 'text-white' : 'text-[#0F2D4F]'" class="text-xl sm:text-[21px] font-extrabold text-[#0F2D4F] tracking-tight leading-snug">
                QS. {{ $mostStreamedSurah->nama_latin ?? 'Al-Baqarah' }}
            </p>
            <p class="text-[11px] font-semibold text-[#1D6D75] mt-0.5">
                {{ $mostStreamedSubtitle ?? 'Belum ada pemutaran' }}
            </p>
        </div>

        <div class="h-1.5 w-full rounded-full bg-[#F2EFE4] overflow-hidden mt-3">
            <div class="h-full rounded-full bg-[#2A7B84]" style="width: {{ $mostStreamedProgressPercent ?? 50 }}%;"></div>
        </div>
    </article>
</section>
