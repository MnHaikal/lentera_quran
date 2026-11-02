@php
    $shortcuts = [
        ['label' => 'Ayat Kursi', 'url' => route('quran.show', ['surah' => 2, 'ayat' => 255])],
        ['label' => 'Surah Yasin', 'url' => route('quran.show', 36)],
        ['label' => 'Al-Mulk', 'url' => route('quran.show', 67)],
        ['label' => 'Al-Kahf', 'url' => route('quran.show', 18)],
        ['label' => 'Ar-Rahman', 'url' => route('quran.show', 55)],
        ['label' => "Al-Waqi'ah", 'url' => route('quran.show', 56)],
        ['label' => 'Al-Ikhlas', 'url' => route('quran.show', 112)],
    ];
@endphp

<x-app-layout title="Beranda" description="Beranda Lentera Quran — Al-Qur'an digital berbahasa Indonesia, bacaan tahlil, dan doa harian.">
    {{-- Hero Section (Full-Width Background Biru seperti Footer) --}}
    <div class="bg-footer-bg text-footer-text border-b border-white/10 overflow-hidden">
        <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-10 md:py-14">
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
                {{-- Left Column: Hero Copy & CTA --}}
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/15 px-4 py-1.5 text-label-md text-brand-gold-pale">
                        <svg class="w-4 h-4 text-brand-gold" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span>Mushaf Standar Indonesia Kemenag RI</span>
                    </div>

                    <h1 class="text-display-mobile md:text-display-lg text-footer-text tracking-tight">
                        Terangi Hari dengan Cahaya Al-Qur'an
                    </h1>

                    <p class="text-body-lg text-footer-muted max-w-2xl leading-relaxed">
                        Baca, dengarkan, dan simpan Al-Qur'an lengkap dengan latin dan terjemahan Indonesia. Disertai lantunan murottal syahdu serta panduan tajwid berwarna.
                    </p>

                    <div class="flex flex-wrap items-center gap-3.5 pt-1">
                        <a href="{{ route('quran.index') }}" wire:navigate class="lq-btn-accent gap-2.5 shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Mulai Membaca</span>
                        </a>

                        <a
                            href="{{ route('quran.show', 1) }}"
                            wire:navigate
                            class="inline-flex items-center justify-center gap-2 min-h-[44px] px-6 py-2.5 rounded-full border-[1.5px] border-white/30 bg-white/10 text-footer-text text-body-md font-semibold hover:border-brand-gold hover:bg-white/15 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                        >
                            <svg class="w-4 h-4 text-brand-gold" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                            </svg>
                            <span>Dengarkan Murottal</span>
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 pt-2 text-body-sm text-footer-muted">
                        <span class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $totalSurahs }} Surah &amp; 30 Juz
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Audio Qari Internasional
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Bebas Iklan
                        </span>
                    </div>
                </div>

                {{-- Right Column: Transparent Hero Illustration --}}
                <div class="lg:col-span-5 flex items-center justify-center lg:justify-end">
                    <img
                        src="{{ asset('images/hero-mushaf.png') }}"
                        alt="Ilustrasi Mushaf Al-Qur'an Digital dan Audio Murottal"
                        class="w-full max-w-[440px] lg:max-w-[520px] h-auto object-contain select-none"
                    >
                </div>
            </section>
        </div>
    </div>

    <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-8 md:py-12 space-y-10">

        {{-- Search & Filter Pill Bar --}}
        <section aria-label="Pencarian Cepat">
            <form action="{{ route('quran.index') }}" method="GET" class="rounded-full bg-surface-card border border-line shadow-card p-2 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2">
                <div class="flex items-center gap-3 px-4 py-1.5 flex-1">
                    <svg class="w-5 h-5 text-ink-muted shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input
                        type="search"
                        name="q"
                        aria-label="Cari surah, nomor ayat, atau kata kunci terjemahan"
                        placeholder="Cari surah, nomor ayat, atau kata kunci terjemahan..."
                        class="w-full bg-transparent border-0 p-0 text-body-md text-ink placeholder-ink-muted focus:ring-0 focus:outline-none"
                    >
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-1.5 px-2 sm:px-0">
                    <div class="inline-flex items-center rounded-full bg-surface-low p-1 border border-line/60">
                        <a href="{{ route('quran.index') }}" wire:navigate class="px-4 py-1.5 rounded-full bg-brand-navy text-white text-label-md">Surah</a>
                        <a href="{{ route('quran.index', ['filter' => 'juz-amma']) }}" wire:navigate class="px-3.5 py-1.5 rounded-full text-ink-muted hover:text-ink text-label-md">Juz</a>
                        <a href="{{ route('quran.index', ['filter' => 'mekah']) }}" wire:navigate class="px-3.5 py-1.5 rounded-full text-ink-muted hover:text-ink text-label-md hidden md:inline-block">Tempat Turun</a>
                    </div>

                    <button
                        type="submit"
                        aria-label="Cari Al-Qur'an"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-brand-teal text-white hover:opacity-90 transition shrink-0"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </section>

        {{-- Lanjutkan Bacaan Terakhir & Ayat Harian --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-5 lq-card flex flex-col justify-between space-y-5">
                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-teal/10 text-brand-teal text-label-sm font-semibold">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Riwayat Membaca
                        </span>
                        <span class="text-label-sm text-ink-muted">Kemarin, 20:15 WIB</span>
                    </div>

                    <h2 class="text-headline-sm text-ink">Lanjutkan Bacaan Terakhir</h2>

                    <div class="rounded-xl bg-surface-low border border-line p-4 space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-body-md font-bold text-ink">QS. Al-Baqarah: Ayat 255</p>
                            <span class="text-label-md text-brand-gold font-bold">Juz {{ $dailyAyah?->juz ?? 3 }}</span>
                        </div>
                        <p class="text-body-sm text-ink-muted">Ayat Kursi · Surah ke-2</p>

                        <div class="space-y-1.5 pt-1">
                            <div class="flex items-center justify-between text-label-sm text-ink-muted">
                                <span>Progress Surah</span>
                                <span class="font-semibold text-ink">89%</span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-surface-container overflow-hidden">
                                <div class="h-full w-[89%] rounded-full bg-brand-teal"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <span class="text-body-sm text-ink-muted">Ayat 255 dari 286</span>
                    <a
                        href="{{ route('quran.show', ['surah' => 2, 'ayat' => 255]) }}"
                        wire:navigate
                        class="inline-flex items-center gap-2 min-h-[40px] px-5 py-2 rounded-full bg-brand-gold text-brand-navy text-body-sm font-semibold hover:bg-brand-gold-hover transition"
                    >
                        <span>Lanjutkan</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7 lq-card flex flex-col justify-between space-y-4">
                <div class="flex items-center justify-between gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-gold-pale text-brand-navy text-label-sm font-semibold">
                        <span class="text-brand-gold">&#10022;</span> Ayat Harian
                    </span>
                    <a
                        href="{{ route('quran.show', ['surah' => 2, 'ayat' => 255]) }}"
                        wire:navigate
                        class="text-label-sm text-ink-muted hover:text-brand-teal font-medium transition"
                    >
                        QS. {{ $dailyAyah?->surah?->nama_latin ?? 'Al-Baqarah' }} · {{ $dailyAyah?->nomor_ayat ?? 255 }}
                    </a>
                </div>

                <p class="quran-arabic text-ink text-right py-1" dir="rtl" lang="ar">
                    {{ $dailyAyah ? \Illuminate\Support\Str::words($dailyAyah->teks_arab, 10, ' ...') : 'اللّٰهُ لَآ اِلٰهَ اِلَّا هُوَ الْحَيُّ الْقَيُّوْمُ' }}
                </p>

                <div class="space-y-1.5">
                    <p class="text-body-sm text-brand-teal italic">
                        {{ $dailyAyah ? \Illuminate\Support\Str::limit($dailyAyah->teks_latin, 95) : 'Allāhu lā ilāha illā huwal-ḥayyul-qayyūm(u)...' }}
                    </p>
                    <p class="text-body-sm text-ink-muted leading-relaxed">
                        "{{ $dailyAyah ? \Illuminate\Support\Str::limit($dailyAyah->terjemahan, 165) : 'Allah, tidak ada tuhan selain Dia, Yang Maha Hidup lagi terus-menerus mengurus (makhluk-Nya)...' }}"
                    </p>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-line/60">
                    <div class="flex items-center gap-2">
                        @if ($dailyAyah?->audio_url)
                            <button
                                type="button"
                                x-data
                                @click="$store.audioPlayer.playTrack({ surahId: 2, surahName: 'Al-Baqarah', ayahNumber: 255, src: '{{ $dailyAyah->audio_url }}' })"
                                class="inline-flex items-center gap-1.5 min-h-[36px] px-3.5 py-1 rounded-full bg-surface-low border border-line text-label-sm font-semibold text-ink hover:border-brand-teal transition"
                            >
                                <span class="text-brand-teal">&#9654;</span> Putar
                            </button>
                        @endif
                        <a
                            href="{{ route('quran.show', ['surah' => 2, 'ayat' => 255]) }}"
                            wire:navigate
                            class="inline-flex items-center gap-1.5 min-h-[36px] px-3.5 py-1 rounded-full bg-surface-low border border-line text-label-sm font-medium text-ink-muted hover:text-ink transition"
                        >
                            Baca Lengkap
                        </a>
                    </div>

                    <a
                        href="{{ route('quran.show', ['surah' => 2, 'ayat' => 255]) }}"
                        wire:navigate
                        aria-label="Buka Ayat Harian"
                        class="inline-flex items-center justify-center w-9 h-9 rounded-full text-ink-muted hover:text-brand-gold transition"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- Baris Pintasan --}}
        <section aria-label="Pintasan Surah dan Doa" class="flex flex-wrap items-center gap-2.5">
            <span class="inline-flex items-center gap-1.5 text-label-md text-ink-muted mr-1">
                <span class="text-brand-gold">&#9889;</span> Pintasan:
            </span>
            @foreach ($shortcuts as $shortcut)
                <a
                    href="{{ $shortcut['url'] }}"
                    wire:navigate
                    class="inline-flex items-center min-h-[36px] px-4 py-1.5 rounded-full bg-surface-card border border-line text-body-sm font-medium text-ink hover:border-brand-teal hover:text-brand-teal transition"
                >
                    {{ $shortcut['label'] }}
                </a>
            @endforeach
        </section>

        {{-- Daftar Mushaf (12 Surah Real dari Database) --}}
        <section class="space-y-6 pt-2">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div class="space-y-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-teal/10 text-brand-teal text-label-sm font-semibold">
                        Daftar Mushaf
                    </span>
                    <h2 class="text-headline-lg text-ink">Mulai Perjalanan Cahayamu</h2>
                    <p class="text-body-md text-ink-muted">
                        Pilih surah untuk mulai membaca dengan teks Arab Utsmani, transliterasi, dan audio per ayat.
                    </p>
                </div>
                <p class="text-body-sm text-ink-muted">
                    Menampilkan <span class="font-semibold text-ink">1 - {{ $previewSurahs->count() ?: 12 }} dari {{ $totalSurahs }} Surah</span>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($previewSurahs as $surah)
                    @php
                        $isActiveCard = $surah->id === 2;
                        $minJuz = (int) ($surah->ayahs_min_juz ?: 1);
                        $maxJuz = (int) ($surah->ayahs_max_juz ?: $minJuz);
                        $juzBadge = $minJuz === $maxJuz ? "Juz {$minJuz}" : "Juz {$minJuz}-{$maxJuz}";
                        $turunLabel = $surah->tempat_turun === 'mekah' ? 'Makkiyah' : 'Madaniyah';
                    @endphp
                    <a
                        href="{{ route('quran.show', $surah->id) }}"
                        wire:navigate
                        class="rounded-card p-5 border transition duration-150 flex items-center justify-between gap-4 {{ $isActiveCard ? 'bg-brand-navy border-brand-navy text-white shadow-md' : 'bg-surface-card border-line text-ink hover:border-brand-gold shadow-card' }}"
                    >
                        <div class="flex items-center gap-3.5 min-w-0">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-body-sm font-bold shrink-0 {{ $isActiveCard ? 'bg-brand-gold text-brand-navy' : 'bg-surface-low text-ink border border-line/60' }}">
                                {{ $surah->id }}
                            </span>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-title-md font-semibold truncate {{ $isActiveCard ? 'text-white' : 'text-ink' }}">
                                        {{ $surah->nama_latin }}
                                    </p>
                                    @if ($isActiveCard)
                                        <span class="px-2 py-0.5 rounded-full text-label-sm bg-brand-gold text-brand-navy font-semibold">
                                            {{ $juzBadge }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-label-sm truncate mt-0.5 {{ $isActiveCard ? 'text-brand-gold-pale' : 'text-ink-muted' }}">
                                    {{ $surah->arti }} · {{ $surah->jumlah_ayat }} Ayat
                                </p>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <p class="font-arabic text-xl leading-normal {{ $isActiveCard ? 'text-brand-gold' : 'text-ink' }}" dir="rtl" lang="ar">
                                {{ $surah->nama_arab }}
                            </p>
                            <p class="text-label-sm mt-0.5 {{ $isActiveCard ? 'text-brand-gold-pale/80' : 'text-ink-muted' }}">
                                {{ $turunLabel }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="flex justify-center pt-2">
                <a href="{{ route('quran.index') }}" wire:navigate class="lq-btn-accent gap-2">
                    <span>Lihat Semua Surah ({{ $totalSurahs }} Surah)</span>
                    <span aria-hidden="true">&darr;</span>
                </a>
            </div>
        </section>

        {{-- Dua Kartu Fitur: Tahlil & Doa Harian --}}
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-2">
            <div class="lq-card relative overflow-hidden flex flex-col justify-between space-y-6">
                <div class="space-y-4 relative z-10">
                    <span class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-brand-teal/10 text-brand-teal">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-label-md uppercase text-brand-teal">Panduan Ibadah</p>
                        <h2 class="text-headline-md text-ink mt-1">Tahlil &amp; Doa Arwah</h2>
                    </div>

                    <p class="text-body-md text-ink-muted leading-relaxed">
                        Bacaan susunan tahlil lengkap dengan panduan suara, dzikir, dan terjemahan. Disusun berurutan untuk memudahkan majelis taklim maupun bacaan mandiri di rumah.
                    </p>

                    <ul class="space-y-2 text-body-sm text-ink-muted pt-1">
                        <li class="flex items-center gap-2.5">
                            <span class="text-brand-teal font-bold">&#10003;</span>
                            <span>Urutan bacaan tahlil standar Kemenag</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-brand-teal font-bold">&#10003;</span>
                            <span>Dilengkapi doa arwah khusus orang tua</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-brand-teal font-bold">&#10003;</span>
                            <span>Teks Arab besar nyaman dibaca bersama</span>
                        </li>
                    </ul>
                </div>

                <div class="pt-2 relative z-10">
                    <a href="{{ route('tahlil.index') }}" wire:navigate class="lq-btn-primary gap-2 text-body-sm">
                        <span>Buka Tahlil</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="lq-card relative overflow-hidden flex flex-col justify-between space-y-6">
                <div class="space-y-4 relative z-10">
                    <span class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-brand-gold-pale text-brand-navy">
                        <svg class="w-6 h-6 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </span>

                    <div>
                        <p class="text-label-md uppercase text-brand-gold">Hisnul Muslim</p>
                        <h2 class="text-headline-md text-ink mt-1">Doa Harian &amp; Dzikir Pagi Petang</h2>
                    </div>

                    <p class="text-body-md text-ink-muted leading-relaxed">
                        Kumpulan doa mustajab sehari-hari dari Al-Qur'an dan Hadits Shahih. Dilengkapi counter tasbih digital dan pengingat waktu dzikir pagi-petang.
                    </p>

                    <ul class="space-y-2 text-body-sm text-ink-muted pt-1">
                        <li class="flex items-center gap-2.5">
                            <span class="text-brand-gold font-bold">&#10003;</span>
                            <span>Dzikir pagi dan petang Al-Ma'tsurat</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-brand-gold font-bold">&#10003;</span>
                            <span>Doa perlindungan keluarga dan rezeki</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-brand-gold font-bold">&#10003;</span>
                            <span>Audio pelafalan untuk hafalan doa</span>
                        </li>
                    </ul>
                </div>

                <div class="pt-2 relative z-10">
                    <a
                        href="{{ route('doa.index') }}"
                        wire:navigate
                        class="inline-flex items-center justify-center gap-2 min-h-[44px] px-6 py-2.5 rounded-full bg-brand-teal text-white text-body-sm font-semibold hover:opacity-90 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                    >
                        <span>Jelajahi Doa</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
