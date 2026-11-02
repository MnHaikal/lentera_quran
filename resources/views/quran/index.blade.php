<x-app-layout title="Al-Qur'an" description="Daftar 114 surah Al-Qur'an lengkap dengan terjemahan dan tajwid digital standar Kemenag RI.">
    <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-8 md:py-12 space-y-8">
        {{-- Header Daftar Surah --}}
        <section class="text-center space-y-4 max-w-2xl mx-auto">
            <h1 class="text-display-mobile md:text-display-lg font-bold text-ink tracking-tight">
                Daftar Surah
            </h1>
            <p class="text-body-md md:text-body-lg text-ink-muted leading-relaxed">
                Baca, telusuri, dan renungkan 114 surah dalam Al-Qur'an lengkap dengan terjemahan dan tajwid digital standar Kemenag RI.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-2.5 pt-1">
                <span class="inline-flex items-center gap-2 rounded-full bg-surface-card border border-line px-4 py-1.5 text-label-md text-ink shadow-card">
                    <span class="w-2 h-2 rounded-full bg-brand-gold"></span>
                    {{ $totalSurahCount }} Surah
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-surface-card border border-line px-4 py-1.5 text-label-md text-ink shadow-card">
                    <span class="w-2 h-2 rounded-full bg-brand-teal"></span>
                    30 Juz
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-surface-card border border-line px-4 py-1.5 text-label-md text-ink shadow-card">
                    <span class="w-2 h-2 rounded-full bg-brand-navy"></span>
                    {{ number_format($totalAyahCount, 0, ',', '.') }} Ayat
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-surface-card border border-line px-4 py-1.5 text-label-md text-ink shadow-card">
                    <svg class="w-3.5 h-3.5 text-brand-gold" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    Mushaf Standar Indonesia
                </span>
            </div>
        </section>

        {{-- Panel Filter & Pencarian --}}
        <section aria-label="Filter dan Pencarian Surah" class="lq-card space-y-4">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-2">
                    <a
                        href="{{ route('quran.index', array_filter(['q' => $searchQuery, 'sort' => $sortDirection !== 'asc' ? $sortDirection : null])) }}"
                        wire:navigate
                        class="inline-flex items-center gap-2 min-h-[40px] px-5 py-2 rounded-full text-body-sm font-semibold transition {{ $activeFilter === 'semua' && !$activeJuz ? 'bg-[#B9892E] text-white shadow-sm' : 'text-ink hover:bg-surface-low' }}"
                    >
                        <span>Semua Surah</span>
                        <span class="px-2 py-0.5 rounded-full text-label-sm {{ $activeFilter === 'semua' && !$activeJuz ? 'bg-white/20 text-white' : 'bg-surface-low text-ink-muted' }}">{{ $totalSurahCount }}</span>
                    </a>

                    <a
                        href="{{ route('quran.index', array_filter(['filter' => 'juz-amma', 'q' => $searchQuery, 'sort' => $sortDirection !== 'asc' ? $sortDirection : null])) }}"
                        wire:navigate
                        class="inline-flex items-center min-h-[40px] px-4 py-2 rounded-full text-body-sm font-semibold transition {{ $activeFilter === 'juz-amma' ? 'bg-[#B9892E] text-white shadow-sm' : 'text-ink hover:bg-surface-low' }}"
                    >
                        Juz 'Amma (30)
                    </a>

                    <div x-data="{ juzDropdownOpen: false }" class="relative">
                        <button
                            type="button"
                            @click="juzDropdownOpen = !juzDropdownOpen"
                            @keydown.escape.window="juzDropdownOpen = false"
                            class="inline-flex items-center gap-1.5 min-h-[40px] px-4 py-2 rounded-full text-body-sm font-semibold transition {{ $activeJuz ? 'bg-[#B9892E] text-white shadow-sm' : 'text-ink hover:bg-surface-low' }}"
                        >
                            <span>{{ $activeJuz ? "Juz {$activeJuz}" : 'Juz 1–30' }}</span>
                            <svg class="w-3.5 h-3.5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            x-show="juzDropdownOpen"
                            @click.outside="juzDropdownOpen = false"
                            x-transition
                            style="display: none;"
                            class="absolute left-0 mt-2 w-64 rounded-card bg-surface-card border border-line shadow-card p-3 z-50 grid grid-cols-5 gap-1.5"
                        >
                            @for ($j = 1; $j <= 30; $j++)
                                <a
                                    href="{{ route('quran.index', ['juz' => $j]) }}"
                                    wire:navigate
                                    class="inline-flex items-center justify-center h-8 rounded-lg text-label-md font-semibold transition {{ $activeJuz === $j ? 'bg-brand-navy text-white' : 'bg-surface-low text-ink hover:border hover:border-brand-gold' }}"
                                >
                                    {{ $j }}
                                </a>
                            @endfor
                        </div>
                    </div>

                    <a
                        href="{{ route('quran.index', array_filter(['filter' => 'mekah', 'q' => $searchQuery, 'sort' => $sortDirection !== 'asc' ? $sortDirection : null])) }}"
                        wire:navigate
                        class="inline-flex items-center gap-1 min-h-[40px] px-4 py-2 rounded-full text-body-sm font-semibold transition {{ $activeFilter === 'mekah' ? 'bg-[#B9892E] text-white shadow-sm' : 'text-ink hover:bg-surface-low' }}"
                    >
                        <span>Mekah</span>
                        <span class="{{ $activeFilter === 'mekah' ? 'text-white/80' : 'text-ink-muted' }} font-normal">({{ $makkiyahCount }})</span>
                    </a>

                    <a
                        href="{{ route('quran.index', array_filter(['filter' => 'madinah', 'q' => $searchQuery, 'sort' => $sortDirection !== 'asc' ? $sortDirection : null])) }}"
                        wire:navigate
                        class="inline-flex items-center gap-1 min-h-[40px] px-4 py-2 rounded-full text-body-sm font-semibold transition {{ $activeFilter === 'madinah' ? 'bg-[#B9892E] text-white shadow-sm' : 'text-ink hover:bg-surface-low' }}"
                    >
                        <span>Madinah</span>
                        <span class="{{ $activeFilter === 'madinah' ? 'text-white/80' : 'text-ink-muted' }} font-normal">({{ $madaniyahCount }})</span>
                    </a>
                </div>

                <div>
                    <span class="inline-flex items-center gap-2 min-h-[38px] px-4 py-1.5 rounded-full bg-surface-low border border-line text-label-md font-medium text-ink">
                        <svg class="w-4 h-4 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                        <span>Tampilkan: Teks Arab &amp; Latin</span>
                    </span>
                </div>
            </div>

            <div class="pt-4 border-t border-line/60 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
                <form action="{{ route('quran.index') }}" method="GET" class="flex-1 max-w-xl rounded-full bg-surface-low border border-line pl-4 pr-1.5 py-1 flex items-center justify-between gap-2">
                    @if ($activeFilter !== 'semua')
                        <input type="hidden" name="filter" value="{{ $activeFilter }}">
                    @endif
                    @if ($activeJuz)
                        <input type="hidden" name="juz" value="{{ $activeJuz }}">
                    @endif
                    @if ($sortDirection !== 'asc')
                        <input type="hidden" name="sort" value="{{ $sortDirection }}">
                    @endif

                    <div class="flex items-center gap-2.5 flex-1 min-w-0">
                        <svg class="w-4 h-4 text-ink-muted shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input
                            type="search"
                            name="q"
                            value="{{ $searchQuery }}"
                            aria-label="Cari nama atau nomor surah"
                            placeholder="Cari nama atau nomor surah (misal: Al-Kahf, 18, Yasin)..."
                            class="w-full bg-transparent border-0 p-0 text-body-sm text-ink placeholder-ink-muted focus:ring-0 focus:outline-none"
                        >
                    </div>
                    <button
                        type="submit"
                        class="px-5 py-1.5 rounded-full bg-brand-teal text-white text-label-md font-semibold hover:opacity-90 transition shrink-0"
                    >
                        Cari
                    </button>
                </form>

                <div class="flex items-center justify-end gap-2.5">
                    <a
                        href="{{ route('quran.index', array_filter(['filter' => $activeFilter !== 'semua' ? $activeFilter : null, 'juz' => $activeJuz, 'q' => $searchQuery, 'sort' => $sortDirection === 'asc' ? 'desc' : null])) }}"
                        wire:navigate
                        class="inline-flex items-center gap-2 min-h-[40px] px-4 py-1.5 rounded-full bg-surface-low border border-line text-body-sm text-ink hover:border-brand-teal transition"
                    >
                        <svg class="w-4 h-4 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12" />
                        </svg>
                        <span>Urutkan: <strong class="font-semibold">Nomor ({{ $sortDirection === 'asc' ? 'Naik' : 'Turun' }})</strong></span>
                        <svg class="w-3.5 h-3.5 text-ink-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>

                    <div class="inline-flex items-center rounded-full bg-surface-low border border-line p-1" role="group" aria-label="Mode tampilan daftar surah">
                        <button type="button" aria-label="Tampilan Grid" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-surface-card text-ink shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </button>
                        <button type="button" aria-label="Tampilan Baris" class="inline-flex items-center justify-center w-8 h-8 rounded-full text-ink-muted hover:text-ink">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Info Jumlah & Petunjuk Klik --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-body-sm">
            <p class="text-ink-muted">
                Menampilkan <strong class="font-semibold text-ink">{{ $surahs->firstItem() ?? 0 }} – {{ $surahs->lastItem() ?? 0 }}</strong> dari <strong class="font-semibold text-ink">{{ $surahs->total() }} Surah</strong>
            </p>
            <p class="inline-flex items-center gap-1.5 text-brand-teal font-medium">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Klik surah untuk membuka lembar mushaf &amp; tafsir</span>
            </p>
        </div>

        {{-- Grid Kartu Surah dari Database --}}
        <section aria-label="Daftar Surah Al-Qur'an" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($surahs as $surah)
                @php
                    $isReading = $surah->id === 18 && $activeFilter === 'semua' && !$searchQuery;
                    $isMadaniyah = $surah->tempat_turun === 'madinah';
                    $minJuz = (int) ($surah->ayahs_min_juz ?: 1);
                    $maxJuz = (int) ($surah->ayahs_max_juz ?: $minJuz);
                    $juzText = $minJuz === $maxJuz ? "Juz {$minJuz}" : "Juz {$minJuz}–{$maxJuz}";
                    $turunText = $isMadaniyah ? 'Madaniyah' : 'Makkiyah';
                @endphp

                <article
                    class="relative rounded-card p-5 transition duration-150 flex flex-col justify-between {{ $isReading ? 'bg-brand-navy border-2 border-brand-gold text-white shadow-ayah-active' : 'bg-surface-card border border-line text-ink hover:border-brand-gold shadow-card' }}"
                >
                    @if ($isReading)
                        <span class="absolute -top-3 right-5 inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-[#C59434] text-white text-[10px] font-bold uppercase tracking-wider shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            Sedang Dibaca
                        </span>
                    @endif

                    <a
                        href="{{ route('quran.show', $surah->id) }}"
                        wire:navigate
                        class="flex items-start justify-between gap-4 focus:outline-none"
                    >
                        <div class="flex items-center gap-3.5 min-w-0">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-body-sm font-bold shrink-0 {{ $isReading ? 'bg-[#C59434] text-brand-navy' : 'bg-surface-low text-ink border border-line/60' }}">
                                {{ $surah->id }}
                            </span>
                            <div class="min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <h2 class="text-title-md font-bold truncate {{ $isReading ? 'text-white' : 'text-ink' }}">
                                        {{ $surah->nama_latin }}
                                    </h2>
                                    @if ($isReading)
                                        <svg class="w-4 h-4 text-brand-gold shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414z" />
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-label-sm truncate mt-0.5 {{ $isReading ? 'text-brand-gold-pale/90' : 'text-ink-muted' }}">
                                    {{ $surah->arti }}
                                </p>
                            </div>
                        </div>

                        <p class="font-arabic text-2xl leading-none shrink-0 pt-1 {{ $isReading ? 'text-brand-gold' : 'text-ink' }}" dir="rtl" lang="ar">
                            {{ $surah->nama_arab }}
                        </p>
                    </a>

                    <div class="mt-4 pt-3 border-t flex items-center justify-between gap-2 {{ $isReading ? 'border-white/15' : 'border-line/60' }}">
                        <a
                            href="{{ route('quran.show', $surah->id) }}"
                            wire:navigate
                            class="flex items-center gap-1.5 text-label-sm min-w-0 truncate"
                        >
                            @if ($isReading)
                                <span class="px-2.5 py-0.5 rounded bg-white/15 text-white font-semibold">
                                    {{ $turunText }}
                                </span>
                            @elseif ($isMadaniyah)
                                <span class="px-2.5 py-0.5 rounded bg-brand-teal/15 text-brand-teal font-semibold">
                                    Madaniyah
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded bg-surface-low text-ink-muted font-semibold">
                                    Makkiyah
                                </span>
                            @endif

                            <span class="{{ $isReading ? 'text-brand-gold-pale/90' : 'text-ink-muted' }}">
                                &middot; {{ $surah->jumlah_ayat }} Ayat &middot; {{ $juzText }}
                            </span>
                        </a>

                        <div class="flex items-center gap-2 shrink-0" x-data>
                            @if ($surah->audio_url)
                                <button
                                    type="button"
                                    @click="$store.audioPlayer.playTrack({ surahId: {{ $surah->id }}, surahName: '{{ addslashes($surah->nama_latin) }}', ayahNumber: null, src: '{{ $surah->audio_url }}' })"
                                    aria-label="Putar audio {{ $surah->nama_latin }}"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-full transition {{ $isReading ? 'bg-[#C59434] text-brand-navy' : 'text-ink-muted hover:text-brand-teal' }}"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" />
                                    </svg>
                                </button>
                            @endif
                            <a
                                href="{{ route('quran.show', $surah->id) }}"
                                wire:navigate
                                aria-label="Buka {{ $surah->nama_latin }}"
                                class="inline-flex items-center justify-center w-7 h-7 rounded-full transition {{ $isReading ? 'text-brand-gold' : 'text-ink-muted hover:text-brand-gold' }}"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full lq-card text-center py-12 space-y-3">
                    <p class="text-headline-sm text-ink">Surah tidak ditemukan</p>
                    <p class="text-body-sm text-ink-muted">Tidak ada surah yang cocok dengan kata kunci atau filter yang dipilih.</p>
                    <a href="{{ route('quran.index') }}" wire:navigate class="lq-btn-outline text-body-sm mt-2">
                        Tampilkan Semua Surah
                    </a>
                </div>
            @endforelse
        </section>

        {{-- Baris Paginasi Real --}}
        @if ($surahs->lastPage() > 1)
            <nav aria-label="Navigasi Halaman Surah" class="lq-card py-4 px-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-body-sm text-ink-muted">
                    Menampilkan Halaman <strong class="font-semibold text-ink">{{ $surahs->currentPage() }}</strong> dari <strong class="font-semibold text-ink">{{ $surahs->lastPage() }}</strong> (Total {{ $surahs->total() }} Surah)
                </p>

                <div class="flex flex-wrap items-center gap-1.5">
                    @if ($surahs->onFirstPage())
                        <span class="inline-flex items-center gap-1 min-h-[36px] px-4 py-1.5 rounded-full border border-line/60 text-body-sm text-ink-muted/60 cursor-not-allowed">
                            <span aria-hidden="true">&lsaquo;</span>
                            <span>Sebelumnya</span>
                        </span>
                    @else
                        <a
                            href="{{ $surahs->previousPageUrl() }}"
                            wire:navigate
                            class="inline-flex items-center gap-1 min-h-[36px] px-4 py-1.5 rounded-full border border-line bg-surface-card text-body-sm font-semibold text-ink hover:border-brand-teal transition"
                        >
                            <span aria-hidden="true">&lsaquo;</span>
                            <span>Sebelumnya</span>
                        </a>
                    @endif

                    @for ($page = 1; $page <= $surahs->lastPage(); $page++)
                        @if ($page === $surahs->currentPage())
                            <span aria-current="page" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#B9892E] text-white text-body-sm font-bold">
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $surahs->url($page) }}"
                                wire:navigate
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-ink hover:bg-surface-low text-body-sm font-semibold transition"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    @if ($surahs->hasMorePages())
                        <a
                            href="{{ $surahs->nextPageUrl() }}"
                            wire:navigate
                            class="inline-flex items-center gap-1 min-h-[36px] px-4 py-1.5 rounded-full border border-line bg-surface-card text-body-sm font-semibold text-ink hover:border-brand-teal transition"
                        >
                            <span>Selanjutnya</span>
                            <span aria-hidden="true">&rsaquo;</span>
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1 min-h-[36px] px-4 py-1.5 rounded-full border border-line/60 text-body-sm text-ink-muted/60 cursor-not-allowed">
                            <span>Selanjutnya</span>
                            <span aria-hidden="true">&rsaquo;</span>
                        </span>
                    @endif
                </div>
            </nav>
        @endif
    </div>
</x-app-layout>
