@php
    $toArabicDigits = static function (int $number): string {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($western, $eastern, (string) $number);
    };

    $tempatTurunUpper = $surah->tempat_turun === 'mekah' ? 'MAKKIYYAH' : 'MADANIYYAH';
    $showBasmalah = $surah->id !== 1 && $surah->id !== 9;
@endphp

<x-app-layout
    :title="'Surah ' . $surah->nama_latin"
    :description="'Baca Surah ' . $surah->nama_latin . ' (' . $surah->arti . ') lengkap ' . $surah->jumlah_ayat . ' ayat dengan teks Arab, transliterasi Latin, terjemahan Kemenag RI, dan audio murottal.'"
>
    <div
        x-data="{
            showLatin: true,
            showTranslation: true,
            fontSize: 36,
            showDescriptionModal: false,
            copiedAyah: null,
            decreaseFont() {
                this.fontSize = Math.max(24, this.fontSize - 2);
                document.documentElement.style.setProperty('--quran-font-size', this.fontSize + 'px');
            },
            increaseFont() {
                this.fontSize = Math.min(52, this.fontSize + 2);
                document.documentElement.style.setProperty('--quran-font-size', this.fontSize + 'px');
            },
            jumpToAyah(ayahNumber) {
                if (!ayahNumber) return;
                const el = document.getElementById('ayat-' + ayahNumber);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    window.location.href = '{{ route('quran.show', $surah->id) }}?ayat=' + ayahNumber;
                }
            },
            copyAyahText(ayahNumber, arab, translation) {
                const text = arab + '\n\n' + translation + ' (QS. {{ addslashes($surah->nama_latin) }}: ' + ayahNumber + ')';
                navigator.clipboard.writeText(text).then(() => {
                    this.copiedAyah = ayahNumber;
                    setTimeout(() => { this.copiedAyah = null; }, 2000);
                });
            }
        }"
        x-init="
            document.documentElement.style.setProperty('--quran-font-size', fontSize + 'px');
            @if ($targetAyahNumber)
                setTimeout(() => {
                    const targetEl = document.getElementById('ayat-{{ $targetAyahNumber }}');
                    if (targetEl) targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 250);
            @endif
        "
    >
        {{-- Sticky Sub-Header / Toolbar Kontrol Bacaan --}}
        <div class="sticky top-20 z-30 bg-surface-card/95 backdrop-blur border-b border-line shadow-sm">
            <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-2.5 flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2.5">
                    <a
                        href="{{ route('quran.index') }}"
                        wire:navigate
                        class="inline-flex items-center gap-2 rounded-full bg-surface-low hover:bg-brand-gold-pale/60 border border-line hover:border-brand-gold px-3.5 py-2 text-label-md font-semibold text-ink hover:text-brand-navy transition"
                        title="Kembali ke Daftar Surah"
                    >
                        <svg class="w-4 h-4 text-brand-teal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali</span>
                    </a>

                    <div class="inline-flex items-center gap-2 rounded-full bg-surface-low border border-line px-3.5 py-1.5">
                        <svg class="w-4 h-4 text-brand-teal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <label for="jump-ayah-select" class="text-label-md text-ink-muted whitespace-nowrap">Lompat ke Ayat:</label>
                        <select
                            id="jump-ayah-select"
                            @change="jumpToAyah($event.target.value)"
                            class="bg-surface-card border border-line rounded-lg text-body-sm font-semibold text-ink py-1 pl-3 pr-7 focus:border-brand-teal focus:ring-0"
                        >
                            @for ($num = 1; $num <= $surah->jumlah_ayat; $num++)
                                <option value="{{ $num }}" @selected(($targetAyahNumber ?? $ayahs->firstItem() ?? 1) === $num)>
                                    Ayat {{ $num }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full bg-brand-teal/15 text-brand-teal text-label-md font-semibold">
                        {{ $juzRangeLabel }}
                    </span>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button
                        type="button"
                        @click="showLatin = !showLatin"
                        :aria-pressed="showLatin"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-label-md font-semibold transition"
                        :class="showLatin ? 'bg-brand-teal/15 text-brand-teal' : 'bg-surface-low text-ink-muted'"
                    >
                        <span>Transliterasi</span>
                    </button>

                    <button
                        type="button"
                        @click="showTranslation = !showTranslation"
                        :aria-pressed="showTranslation"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-label-md font-semibold transition"
                        :class="showTranslation ? 'bg-brand-teal/15 text-brand-teal' : 'bg-surface-low text-ink-muted'"
                    >
                        <span>Terjemahan</span>
                    </button>

                    <div class="inline-flex items-center rounded-full bg-surface-low border border-line px-2 py-1 gap-2" role="group" aria-label="Pengaturan ukuran huruf Arab">
                        <button
                            type="button"
                            @click="decreaseFont()"
                            aria-label="Perkecil huruf Arab"
                            class="w-7 h-7 rounded-full text-label-md font-bold text-ink hover:bg-surface-card transition"
                        >
                            A-
                        </button>
                        <span class="text-label-sm font-semibold text-ink-muted min-w-[36px] text-center" x-text="fontSize + 'px'">36px</span>
                        <button
                            type="button"
                            @click="increaseFont()"
                            aria-label="Perbesar huruf Arab"
                            class="w-7 h-7 rounded-full text-label-md font-bold text-ink hover:bg-surface-card transition"
                        >
                            A+
                        </button>
                    </div>
                </div>

                <div class="hidden lg:flex items-center">
                    <div class="inline-flex items-center gap-2 rounded-full bg-surface-low border border-line px-4 py-1.5 text-body-sm text-ink">
                        <svg class="w-4 h-4 text-brand-gold shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M7 4a3 3 0 016 0v6a3 3 0 11-6 0V4z" />
                            <path d="M5.5 9.643a.75.75 0 00-1.5 0V10c0 3.06 2.29 5.585 5.25 5.954V17.5h-1.5a.75.75 0 000 1.5h4.5a.75.75 0 000-1.5h-1.5v-1.546A6.001 6.001 0 0016 10v-.357a.75.75 0 00-1.5 0V10a4.5 4.5 0 01-9 0v-.357z" />
                        </svg>
                        <span class="font-medium">Syaikh {{ config('quran.qari_name', 'Misyari Rasyid Al-Afasi') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kontainer Utama Mushaf (max-w-mushaf = 840px sesuai DESIGN.md) --}}
        <div class="max-w-mushaf mx-auto px-gutter-mobile md:px-gutter py-8 md:py-10 space-y-6">
            {{-- Banner Header Surah (Deep Navy) --}}
            <section class="rounded-card bg-gradient-to-b from-[#0A223D] via-[#0F2D4F] to-[#0A223D] text-white p-6 sm:p-10 shadow-lg border border-white/10 text-center space-y-5">
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="px-3.5 py-1 rounded-full bg-white/10 border border-white/10 text-label-sm font-bold uppercase tracking-wider text-brand-gold">
                        Surah Ke-{{ $surah->id }}
                    </span>
                    <span class="px-3.5 py-1 rounded-full bg-white/10 border border-white/10 text-label-sm font-bold uppercase tracking-wider text-white">
                        {{ $surah->jumlah_ayat }} Ayat
                    </span>
                    <span class="px-3.5 py-1 rounded-full bg-brand-teal/35 border border-brand-teal/50 text-label-sm font-bold uppercase tracking-wider text-[#9BE8F0]">
                        {{ $tempatTurunUpper }}
                    </span>
                    <span class="px-3.5 py-1 rounded-full bg-white/10 border border-white/10 text-label-sm font-bold uppercase tracking-wider text-white">
                        {{ strtoupper($juzRangeLabel) }}
                    </span>
                </div>

                <div class="space-y-2 pt-1">
                    <p class="font-arabic text-4xl sm:text-5xl text-brand-gold leading-relaxed" dir="rtl" lang="ar">
                        سُورَةُ {{ $surah->nama_arab }}
                    </p>
                    <h1 class="text-headline-lg sm:text-4xl font-bold text-white tracking-tight">
                        {{ $surah->nama_latin }}
                    </h1>
                    <p class="text-body-sm sm:text-body-md text-[#8FB2D6] italic">
                        "{{ $surah->arti }}"
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-3 pt-1">
                    @if ($surah->audio_url)
                        <button
                            type="button"
                            @click="$store.audioPlayer.playTrack({ surahId: {{ $surah->id }}, surahName: '{{ addslashes($surah->nama_latin) }}', ayahNumber: null, src: '{{ $surah->audio_url }}' })"
                            class="inline-flex items-center justify-center gap-2 min-h-[44px] px-6 py-2.5 rounded-full bg-brand-gold text-brand-navy text-body-sm font-bold hover:bg-brand-gold-hover shadow-sm transition"
                        >
                            <span>&#9654;</span>
                            <span>Putar Surah Penuh</span>
                        </button>
                    @endif

                    @if ($surah->deskripsi)
                        <button
                            type="button"
                            @click="showDescriptionModal = !showDescriptionModal"
                            class="inline-flex items-center justify-center gap-2 min-h-[44px] px-5 py-2.5 rounded-full border border-white/25 bg-white/5 text-white text-body-sm font-semibold hover:bg-white/10 transition"
                        >
                            <svg class="w-4 h-4 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Pengantar Surah</span>
                        </button>
                    @endif
                </div>

                @if ($surah->deskripsi)
                    <div
                        x-show="showDescriptionModal"
                        x-transition
                        style="display: none;"
                        class="text-left rounded-xl bg-black/25 border border-white/15 p-4 text-body-sm text-brand-gold-pale/90 leading-relaxed"
                    >
                        {!! strip_tags($surah->deskripsi, '<i><em><b><strong><br>') !!}
                    </div>
                @endif

                @if ($showBasmalah)
                    <div class="pt-5 mt-4 border-t border-white/10 space-y-1.5">
                        <p class="font-arabic text-3xl sm:text-4xl text-brand-gold leading-relaxed" dir="rtl" lang="ar">
                            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                        </p>
                        <p class="text-label-sm text-[#8FB2D6]">
                            Dengan nama Allah Yang Maha Pengasih, Maha Penyayang.
                        </p>
                    </div>
                @endif
            </section>

            {{-- Daftar Kartu Ayat Real dari Database --}}
            <section aria-label="Daftar Ayat Surah {{ $surah->nama_latin }}" class="space-y-5">
                @foreach ($ayahs as $ayah)
                    <article
                        id="ayat-{{ $ayah->nomor_ayat }}"
                        class="rounded-card p-5 sm:p-7 transition duration-200"
                        :class="$store.audioPlayer && $store.audioPlayer.isCurrentAyah({{ $surah->id }}, {{ $ayah->nomor_ayat }})
                            ? 'bg-surface-card border-2 border-brand-gold shadow-ayah-active'
                            : 'bg-surface-card border border-line shadow-card'"
                    >
                        {{-- Header Kartu Ayat --}}
                        <div class="flex items-center justify-between gap-3 pb-4 border-b border-line/60">
                            <div class="flex items-center gap-3">
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-brand-navy text-brand-gold text-label-md font-bold shrink-0"
                                    :class="$store.audioPlayer && $store.audioPlayer.isCurrentAyah({{ $surah->id }}, {{ $ayah->nomor_ayat }}) ? 'ring-2 ring-brand-gold' : ''"
                                >
                                    {{ $surah->id }}:{{ $ayah->nomor_ayat }}
                                </span>

                                <span class="text-body-sm font-semibold text-ink-muted">
                                    Ayat {{ $ayah->nomor_ayat }}
                                </span>

                                <span
                                    x-show="$store.audioPlayer && $store.audioPlayer.isCurrentAyah({{ $surah->id }}, {{ $ayah->nomor_ayat }})"
                                    style="display: none;"
                                    class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-brand-navy text-brand-gold text-label-sm font-semibold"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-gold animate-pulse"></span>
                                    Sedang Diputar
                                </span>
                            </div>

                            <span class="text-label-sm font-medium text-ink-muted">
                                Juz {{ $ayah->juz }}{{ $ayah->halaman ? ' · Hal. ' . $ayah->halaman : '' }}
                            </span>
                        </div>

                        {{-- Teks Arab Ayat --}}
                        <div class="py-6">
                            <p class="quran-arabic text-ink text-right leading-[2.25]" dir="rtl" lang="ar">
                                {{ $ayah->teks_arab }}
                                <span class="inline-flex items-center justify-center mx-1 text-brand-teal select-none">
                                    &#xFD3F;{{ $toArabicDigits($ayah->nomor_ayat) }}&#xFD3E;
                                </span>
                            </p>
                        </div>

                        {{-- Transliterasi Latin & Terjemahan Indonesia --}}
                        <div class="space-y-2.5">
                            <p
                                x-show="showLatin"
                                class="text-body-md text-brand-teal italic leading-relaxed"
                            >
                                {{ $ayah->teks_latin }}
                            </p>

                            <p
                                x-show="showTranslation"
                                class="text-body-md text-ink leading-relaxed"
                            >
                                {{ $ayah->terjemahan }}
                            </p>
                        </div>

                        {{-- Footer Aksi Kartu Ayat --}}
                        <div class="mt-6 pt-4 border-t border-line/60 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                @if ($ayah->audio_url)
                                    <button
                                        type="button"
                                        @click="$store.audioPlayer.playTrack({ surahId: {{ $surah->id }}, surahName: '{{ addslashes($surah->nama_latin) }}', ayahNumber: {{ $ayah->nomor_ayat }}, src: '{{ $ayah->audio_url }}' })"
                                        class="inline-flex items-center gap-1.5 min-h-[36px] px-4 py-1.5 rounded-full text-label-md font-semibold transition"
                                        :class="$store.audioPlayer && $store.audioPlayer.isCurrentAyah({{ $surah->id }}, {{ $ayah->nomor_ayat }}) && $store.audioPlayer.isPlaying
                                            ? 'bg-brand-navy text-white'
                                            : 'bg-surface-low border border-line text-ink hover:border-brand-teal'"
                                    >
                                        <span x-show="!($store.audioPlayer && $store.audioPlayer.isCurrentAyah({{ $surah->id }}, {{ $ayah->nomor_ayat }}) && $store.audioPlayer.isPlaying)">&#9654; Putar</span>
                                        <span x-show="$store.audioPlayer && $store.audioPlayer.isCurrentAyah({{ $surah->id }}, {{ $ayah->nomor_ayat }}) && $store.audioPlayer.isPlaying" style="display: none;">&#10074;&#10074; Jeda</span>
                                    </button>
                                @endif

                                <button
                                    type="button"
                                    aria-label="Simpan penanda ayat {{ $ayah->nomor_ayat }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-full text-ink-muted hover:text-brand-gold hover:bg-surface-low transition"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                    </svg>
                                </button>

                                <button
                                    type="button"
                                    @click="copyAyahText({{ $ayah->nomor_ayat }}, @js($ayah->teks_arab), @js($ayah->terjemahan))"
                                    aria-label="Salin teks ayat {{ $ayah->nomor_ayat }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-full text-ink-muted hover:text-brand-teal hover:bg-surface-low transition"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                    </svg>
                                </button>

                                <span
                                    x-show="copiedAyah === {{ $ayah->nomor_ayat }}"
                                    x-transition
                                    style="display: none;"
                                    class="text-label-sm font-semibold text-brand-teal"
                                >
                                    Tersalin!
                                </span>
                            </div>

                            <a
                                href="#ayat-{{ $ayah->nomor_ayat }}"
                                class="inline-flex items-center gap-1 text-body-sm font-semibold text-brand-teal hover:underline"
                            >
                                <span>Tafsir Tahlili</span>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </section>

            {{-- Banner Ayat Terpilih (Ayat Kursi pada Surah Al-Baqarah) --}}
            @if ($featuredAyah)
                <section aria-label="Ayat Terpilih" class="rounded-card bg-brand-navy text-white p-6 sm:p-7 shadow-md space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div class="flex items-center gap-2.5">
                            <span class="px-3 py-0.5 rounded-full bg-brand-gold text-brand-navy text-label-sm font-bold">
                                Ayat Terpilih
                            </span>
                            <h2 class="text-title-md font-bold text-white">
                                Ayat Kursi — QS. Al-Baqarah: 255
                            </h2>
                        </div>

                        <a
                            href="{{ route('quran.show', ['surah' => 2, 'ayat' => 255]) }}"
                            wire:navigate
                            class="inline-flex items-center gap-1.5 text-label-md font-semibold text-brand-gold hover:underline"
                        >
                            <span>Buka Langsung Ayat 255</span>
                            <span aria-hidden="true">&#8599;</span>
                        </a>
                    </div>

                    <p class="quran-arabic text-brand-gold text-right leading-[2.2]" dir="rtl" lang="ar">
                        {{ \Illuminate\Support\Str::words($featuredAyah->teks_arab, 18, ' ...') }}
                    </p>

                    <p class="text-body-sm text-brand-gold-pale/90 italic leading-relaxed">
                        "{{ \Illuminate\Support\Str::limit($featuredAyah->terjemahan, 160) }}"
                    </p>
                </section>
            @endif

            {{-- Footer Navigasi Ayat & Halaman Berikutnya --}}
            <nav aria-label="Navigasi Halaman Ayat" class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-body-sm text-ink-muted">
                    Menampilkan Ayat <strong class="font-semibold text-ink">{{ $ayahs->firstItem() ?? 1 }} - {{ $ayahs->lastItem() ?? $surah->jumlah_ayat }}</strong> dari <strong class="font-semibold text-ink">{{ $surah->jumlah_ayat }} Ayat</strong>
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    @if (! $ayahs->onFirstPage())
                        <a
                            href="{{ $ayahs->previousPageUrl() }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition"
                        >
                            <span aria-hidden="true">&larr;</span>
                            <span>Ayat Sebelumnya</span>
                        </a>
                    @elseif ($previousSurah)
                        <a
                            href="{{ route('quran.show', $previousSurah->id) }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition"
                        >
                            <span aria-hidden="true">&larr;</span>
                            <span>QS. {{ $previousSurah->nama_latin }}</span>
                        </a>
                    @endif

                    @if ($ayahs->hasMorePages())
                        <a
                            href="{{ $ayahs->nextPageUrl() }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition"
                        >
                            <span>Tampilkan 20 Ayat Berikutnya</span>
                        </a>

                        <a
                            href="{{ $ayahs->nextPageUrl() }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-brand-teal text-white text-body-sm font-semibold hover:opacity-90 transition"
                        >
                            <span>Halaman Berikutnya (Hal. {{ $ayahs->currentPage() + 1 }})</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    @elseif ($nextSurah)
                        <a
                            href="{{ route('quran.show', $nextSurah->id) }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-brand-teal text-white text-body-sm font-semibold hover:opacity-90 transition"
                        >
                            <span>Surah Berikutnya: {{ $nextSurah->nama_latin }}</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    @endif
                </div>
            </nav>
        </div>
    </div>
</x-app-layout>

