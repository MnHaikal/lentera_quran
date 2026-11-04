<x-app-layout title="Beranda" description="Beranda Lentera Quran — Al-Qur'an digital berbahasa Indonesia, bacaan tahlil, dan doa harian.">
    {{-- Hero Section (Full-Width Background Biru seperti Footer) --}}
    <div class="bg-footer-bg text-footer-text border-b border-white/10 overflow-hidden flex items-center" style="min-height: calc(100vh - 80px);">
        <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-12 md:py-16 w-full">
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
                {{-- Left Column: Hero Copy & CTA --}}
                <div class="lg:col-span-7 space-y-6">
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
        @auth
            {{-- Bagian User Login: Lanjutkan Bacaan Terakhir (Penanda Ayat Terakhir) & Ayat Harian --}}
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-5 lq-card flex flex-col justify-between space-y-5">
                    @if ($latestAyahBookmark && $latestAyahBookmark->bookmarkable && $latestAyahBookmark->bookmarkable->surah)
                        @php
                            $lastAyah = $latestAyahBookmark->bookmarkable;
                            $lastSurah = $lastAyah->surah;
                            $lastProgress = min(100, max(1, round(($lastAyah->nomor_ayat / max(1, $lastSurah->jumlah_ayat)) * 100)));
                        @endphp
                        <div class="space-y-4">
                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-teal/10 text-brand-teal text-label-sm font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                    </svg>
                                    Penanda Terakhir
                                </span>
                                <span class="text-label-sm text-ink-muted">
                                    {{ $latestAyahBookmark->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <h2 class="text-headline-sm text-ink font-bold">Lanjutkan Bacaan Terakhir</h2>

                            <div class="rounded-xl bg-surface-low border border-line p-4 space-y-3">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-body-md font-bold text-ink">QS. {{ $lastSurah->nama_latin }}: Ayat {{ $lastAyah->nomor_ayat }}</p>
                                    <span class="text-label-md text-brand-gold font-bold">Juz {{ $lastAyah->juz }}</span>
                                </div>
                                <p class="text-body-sm text-ink-muted">{{ $lastSurah->arti }} &middot; Surah ke-{{ $lastSurah->id }}</p>

                                <div class="space-y-1.5 pt-1">
                                    <div class="flex items-center justify-between text-label-sm text-ink-muted">
                                        <span>Progress Surah</span>
                                        <span class="font-semibold text-ink">{{ $lastProgress }}%</span>
                                    </div>
                                    <div class="h-2 w-full rounded-full bg-surface-container overflow-hidden">
                                        <div class="h-full rounded-full bg-brand-teal transition-all duration-300" style="width: {{ $lastProgress }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <span class="text-body-sm text-ink-muted">Ayat {{ $lastAyah->nomor_ayat }} dari {{ $lastSurah->jumlah_ayat }}</span>
                            <a
                                href="{{ route('quran.show', ['surah' => $lastSurah->id, 'ayat' => $lastAyah->nomor_ayat]) }}"
                                wire:navigate
                                class="inline-flex items-center gap-2 min-h-[40px] px-5 py-2 rounded-full bg-brand-gold text-brand-navy text-body-sm font-semibold hover:bg-brand-gold-hover transition"
                            >
                                <span>Lanjutkan</span>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-teal/10 text-brand-teal text-label-sm font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                    </svg>
                                    Penanda Bacaan
                                </span>
                                <span class="text-label-sm text-ink-muted">Belum ada penanda</span>
                            </div>

                            <h2 class="text-headline-sm text-ink font-bold">Lanjutkan Bacaan Terakhir</h2>

                            <div class="rounded-xl bg-surface-low border border-line p-5 text-center space-y-2">
                                <div class="w-10 h-10 mx-auto rounded-full bg-brand-gold/15 flex items-center justify-center text-brand-gold">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <p class="text-body-md font-bold text-ink">Belum Ada Penanda Ayat</p>
                                <p class="text-body-sm text-ink-muted max-w-xs mx-auto">
                                    Tandai ayat dengan ikon penanda saat membaca Al-Qur'an untuk menyimpan bacaan terakhir Anda di sini.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <span class="text-body-sm text-ink-muted">114 Surah Tersedia</span>
                            <a
                                href="{{ route('quran.index') }}"
                                wire:navigate
                                class="inline-flex items-center gap-2 min-h-[40px] px-5 py-2 rounded-full bg-brand-gold text-brand-navy text-body-sm font-semibold hover:bg-brand-gold-hover transition"
                            >
                                <span>Mulai Membaca</span>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Kartu Kanan: Ayat Harian --}}
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
                                    @click="$store.audioPlayer.playTrack({ surahId: 2, surahName: 'Al-Baqarah', ayahNumber: 255, totalAyat: 286, src: '{{ $dailyAyah->audio_url }}' })"
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
        @endauth

        {{-- Daftar Mushaf (12 Surah Real dari Database) --}}
        <section class="space-y-6 pt-2">
            <div class="space-y-2">
                <h2 class="text-headline-lg text-ink">Mulai Perjalanan Cahayamu</h2>
                <p class="text-body-md text-ink-muted">
                    Pilih surah untuk mulai membaca dengan teks Arab Utsmani, transliterasi, dan audio per ayat.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($previewSurahs as $surah)
                    @php
                        $turunLabel = $surah->tempat_turun === 'mekah' ? 'Makkiyah' : 'Madaniyah';
                    @endphp
                    <a
                        href="{{ route('quran.show', $surah->id) }}"
                        wire:navigate
                        class="rounded-card p-5 border border-line bg-surface-card text-ink hover:border-brand-gold shadow-card transition duration-150 flex items-center justify-between gap-4"
                    >
                        <div class="flex items-center gap-3.5 min-w-0">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-body-sm font-bold shrink-0 bg-surface-low text-ink border border-line/60">
                                {{ $surah->id }}
                            </span>
                            <div class="min-w-0">
                                <p class="text-title-md font-semibold truncate text-ink">
                                    {{ $surah->nama_latin }}
                                </p>
                                <p class="text-label-sm truncate mt-0.5 text-ink-muted">
                                    {{ $surah->arti }} · {{ $surah->jumlah_ayat }} Ayat
                                </p>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <p class="font-arabic text-xl leading-normal text-ink" dir="rtl" lang="ar">
                                {{ $surah->nama_arab }}
                            </p>
                            <p class="text-label-sm mt-0.5 text-ink-muted">
                                {{ $turunLabel }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="flex justify-center pt-2">
                <a href="{{ route('quran.index') }}" wire:navigate class="lq-btn-accent">
                    <span>Lihat Semua Surah</span>
                </a>
            </div>
        </section>

        {{-- Dua Kartu Fitur: Tahlil & Doa Harian --}}
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-2">
            <div class="rounded-card border border-line bg-surface-card shadow-card overflow-hidden flex flex-col justify-between group hover:border-brand-gold/50 transition duration-200">
                <div>
                    {{-- Foto Tahlil & Doa Arwah --}}
                    <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-surface-low">
                        <img
                            src="{{ asset('images/tahlil.jpg') }}"
                            alt="Tahlil & Doa Arwah"
                            class="w-full h-full object-cover object-[center_60%] group-hover:scale-105 transition-transform duration-500"
                            loading="lazy"
                        >
                    </div>

                    <div class="p-6 sm:p-7 space-y-4">
                        <h2 class="text-headline-md text-ink">Tahlil &amp; Doa Arwah</h2>

                        <p class="text-body-md text-ink-muted leading-relaxed">
                            Bacaan susunan tahlil lengkap dengan panduan suara, dzikir, dan terjemahan. Disusun berurutan untuk memudahkan majelis taklim maupun bacaan mandiri di rumah.
                        </p>

                        <ul class="space-y-2 text-body-sm text-ink-muted pt-1">
                            <li class="flex items-center gap-2.5">
                                <span class="text-brand-gold font-bold">&#10003;</span>
                                <span>Urutan bacaan tahlil standar Kemenag</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-brand-gold font-bold">&#10003;</span>
                                <span>Dilengkapi doa arwah khusus orang tua</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-brand-gold font-bold">&#10003;</span>
                                <span>Teks Arab besar nyaman dibaca bersama</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="p-6 sm:p-7 pt-0">
                    <a href="{{ route('tahlil.index') }}" wire:navigate class="lq-btn-primary text-body-sm">
                        <span>Buka Tahlil</span>
                    </a>
                </div>
            </div>

            <div class="rounded-card border border-line bg-surface-card shadow-card overflow-hidden flex flex-col justify-between group hover:border-brand-gold/50 transition duration-200">
                <div>
                    {{-- Foto Doa Harian & Dzikir Pagi Petang --}}
                    <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-surface-low">
                        <img
                            src="{{ asset('images/doa-harian.jpg') }}"
                            alt="Doa Harian & Dzikir Pagi Petang"
                            class="w-full h-full object-cover object-[center_45%] group-hover:scale-105 transition-transform duration-500"
                            loading="lazy"
                        >
                    </div>

                    <div class="p-6 sm:p-7 space-y-4">
                        <h2 class="text-headline-md text-ink">Doa Harian &amp; Dzikir Pagi Petang</h2>

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
                </div>

                <div class="p-6 sm:p-7 pt-0">
                    <a href="{{ route('doa.index') }}" wire:navigate class="lq-btn-primary text-body-sm">
                        <span>Jelajahi Doa</span>
                    </a>
                </div>
            </div>
        </section>

        @guest
            {{-- Banner CTA Pendaftaran Akun dengan Background Foto bacaquran.jpg --}}
            <div class="rounded-card text-white border border-brand-gold/30 shadow-card relative overflow-hidden bg-[#071a2a] min-h-[400px] flex items-center">
                {{-- Foto Background --}}
                <img
                    src="{{ asset('images/bacaquran.jpg') }}"
                    alt="Membaca Al-Qur'an Digital Lentera Quran"
                    class="absolute inset-0 w-full h-full object-cover object-left md:object-[12%_center] select-none"
                    loading="lazy"
                >

                {{-- Overlay Gradasi untuk Menjaga Kontras & Keterbacaan Teks --}}
                <div class="absolute inset-0 bg-gradient-to-t from-[#061623]/95 via-[#061623]/85 to-[#061623]/40 md:bg-gradient-to-r md:from-black/10 md:via-[#061623]/80 md:to-[#061623]/95 pointer-events-none"></div>
                <div class="absolute -right-12 -top-12 w-80 h-80 rounded-full bg-brand-gold/15 blur-3xl pointer-events-none"></div>

                {{-- Tata Letak Konten: Sisi Kiri Terbuka untuk Foto Anak Membaca Quran, Sisi Kanan untuk Teks & Tombol Aksi --}}
                <div class="relative z-10 w-full p-6 sm:p-8 lg:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-8 items-center">
                        {{-- Kolom Kiri Kosong agar Visual Anak Membaca Al-Qur'an Terlihat Jelas --}}
                        <div class="hidden md:block md:col-span-5 pointer-events-none"></div>

                        {{-- Kolom Kanan: Teks Persuasif & Tombol Registrasi --}}
                        <div class="md:col-span-7 space-y-4 sm:space-y-5">
                            <h3 class="text-headline-md sm:text-headline-lg font-bold tracking-tight text-white leading-snug">
                                Jangan Biarkan Tilawah &amp; Amalan Doa Anda Terputus
                            </h3>

                            <p class="text-body-md text-white/85 leading-relaxed max-w-xl">
                                Pernahkah Anda lupa terakhir membaca ayat ke berapa? Dengan membuat akun Lentera Quran, semua tilawah Anda tersimpan otomatis di cloud dan bisa diakses dari perangkat mana pun.
                            </p>

                            <div class="flex flex-wrap items-center gap-x-5 gap-y-2.5 pt-1">
                                <div class="inline-flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-brand-gold text-brand-navy text-xs font-bold shrink-0">&#10003;</span>
                                    <span class="text-body-sm text-white font-medium">Penanda Ayat</span>
                                </div>
                                <div class="inline-flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-brand-gold text-brand-navy text-xs font-bold shrink-0">&#10003;</span>
                                    <span class="text-body-sm text-white font-medium">Koleksi Doa Favorit</span>
                                </div>
                                <div class="inline-flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-brand-gold text-brand-navy text-xs font-bold shrink-0">&#10003;</span>
                                    <span class="text-body-sm text-white font-medium">100% Bebas Iklan</span>
                                </div>
                            </div>

                            <div class="pt-2">
                                <a
                                    href="{{ route('register') }}"
                                    wire:navigate
                                    class="inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-brand-gold hover:bg-brand-gold-hover text-brand-navy font-bold text-body-md shadow-lg hover:shadow-xl transition-all duration-200 text-center"
                                >
                                    <span>Daftar Akun Gratis Sekarang</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</x-app-layout>
