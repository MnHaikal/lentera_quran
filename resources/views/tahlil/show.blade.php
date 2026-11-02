@php
    $toArabicDigits = static function (int $number): string {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($western, $eastern, (string) $number);
    };

    $showBasmalah = $tahlilItem->urutan !== 3;
@endphp

<x-app-layout
    :title="$tahlilItem->judul . ' — Bacaan Tahlil #' . $tahlilItem->urutan"
    :description="'Bacaan Tahlil urutan ke-' . $tahlilItem->urutan . ': ' . $tahlilItem->judul . ' lengkap dengan teks Arab, transliterasi Latin, dan terjemahan Bahasa Indonesia.'"
>
    <div
        x-data="{
            showLatin: true,
            showTranslation: true,
            fontSize: 36,
            showGuide: false,
            counter: 0,
            targetCount: {{ (int) $tahlilItem->jumlah_baca }},
            copiedUrutan: null,
            decreaseFont() {
                this.fontSize = Math.max(24, this.fontSize - 2);
                document.documentElement.style.setProperty('--quran-font-size', this.fontSize + 'px');
            },
            increaseFont() {
                this.fontSize = Math.min(52, this.fontSize + 2);
                document.documentElement.style.setProperty('--quran-font-size', this.fontSize + 'px');
            },
            incrementCounter() {
                if (this.counter < this.targetCount) {
                    this.counter++;
                } else {
                    this.counter = 0;
                }
            },
            copyTahlilText(urutan, judul, arab, latin, translation) {
                const text = judul + '\n\n' + arab + '\n\n' + (latin || '') + '\n\n' + (translation || '') + ' (Tahlil Urutan #' + urutan + ')';
                navigator.clipboard.writeText(text).then(() => {
                    this.copiedUrutan = urutan;
                    setTimeout(() => { this.copiedUrutan = null; }, 2000);
                });
            }
        }"
        x-init="document.documentElement.style.setProperty('--quran-font-size', fontSize + 'px')"
    >
        {{-- Sticky Sub-Header / Toolbar Kontrol Bacaan (Persis Detail Surah) --}}
        <div class="sticky top-20 z-30 bg-surface-card/95 backdrop-blur border-b border-line shadow-sm">
            <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-2.5 flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2.5">
                    <a
                        href="{{ route('tahlil.index') }}"
                        wire:navigate
                        class="inline-flex items-center gap-2 rounded-full bg-surface-low hover:bg-brand-gold-pale/60 border border-line hover:border-brand-gold px-3.5 py-2 text-label-md font-semibold text-ink hover:text-brand-navy transition"
                        title="Kembali ke Daftar Bacaan Tahlil"
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
                        <label for="jump-tahlil-select" class="text-label-md text-ink-muted whitespace-nowrap">Lompat ke Urutan:</label>
                        <select
                            id="jump-tahlil-select"
                            onchange="window.location.href = this.value"
                            class="bg-surface-card border border-line rounded-lg text-body-sm font-semibold text-ink py-1 pl-3 pr-7 focus:border-brand-teal focus:ring-0 max-w-[220px]"
                        >
                            @foreach ($allItems as $optItem)
                                <option value="{{ route('tahlil.show', $optItem->urutan) }}" @selected($optItem->urutan === $tahlilItem->urutan)>
                                    Urutan {{ $optItem->urutan }} — {{ \Illuminate\Support\Str::limit($optItem->judul, 24) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full bg-brand-teal/15 text-brand-teal text-label-md font-semibold">
                        Dibaca {{ $tahlilItem->jumlah_baca }}x
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
                        <svg class="w-4 h-4 text-brand-gold shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <span class="font-medium">{{ $tahlilItem->keterangan ?? 'Susunan Tahlil Nusantara' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kontainer Utama Mushaf (max-w-mushaf = 840px sesuai halaman Detail Surah) --}}
        <div class="max-w-mushaf mx-auto px-gutter-mobile md:px-gutter py-8 md:py-10 space-y-6">
            {{-- Banner Header Bacaan Tahlil (Deep Navy persis Detail Surah) --}}
            <section class="rounded-card bg-gradient-to-b from-[#0A223D] via-[#0F2D4F] to-[#0A223D] text-white p-6 sm:p-10 shadow-lg border border-white/10 text-center space-y-5">
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="px-3.5 py-1 rounded-full bg-white/10 border border-white/10 text-label-sm font-bold uppercase tracking-wider text-brand-gold">
                        Urutan Ke-{{ $tahlilItem->urutan }}
                    </span>
                    <span class="px-3.5 py-1 rounded-full bg-white/10 border border-white/10 text-label-sm font-bold uppercase tracking-wider text-white">
                        Dibaca {{ $tahlilItem->jumlah_baca }} Kali
                    </span>
                    <span class="px-3.5 py-1 rounded-full bg-brand-teal/35 border border-brand-teal/50 text-label-sm font-bold uppercase tracking-wider text-[#9BE8F0]">
                        {{ strtoupper($tahlilItem->keterangan ?? 'TAHLIL NUSANTARA') }}
                    </span>
                    <span class="px-3.5 py-1 rounded-full bg-white/10 border border-white/10 text-label-sm font-bold uppercase tracking-wider text-white">
                        DARI {{ $allItems->count() }} URUTAN
                    </span>
                </div>

                <div class="space-y-2 pt-1">
                    <p class="font-arabic text-4xl sm:text-5xl text-brand-gold leading-relaxed" dir="rtl" lang="ar">
                        ذِكْرٌ وَتَهْلِيْلٌ
                    </p>
                    <h1 class="text-headline-md sm:text-headline-lg font-bold text-white tracking-tight max-w-2xl mx-auto">
                        {{ $tahlilItem->judul }}
                    </h1>
                    <p class="text-body-sm sm:text-body-md text-[#8FB2D6] italic">
                        "{{ $tahlilItem->keterangan ?? 'Susunan Bacaan Tahlil & Doa Arwah' }}" &middot; Urutan ke-{{ $tahlilItem->urutan }} dari {{ $allItems->count() }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-3 pt-1">
                    <button
                        type="button"
                        @click="incrementCounter()"
                        class="inline-flex items-center justify-center gap-2 min-h-[44px] px-6 py-2.5 rounded-full bg-brand-gold text-brand-navy text-body-sm font-bold hover:bg-brand-gold-hover shadow-sm transition"
                    >
                        <span>&#10022;</span>
                        <span x-text="counter >= targetCount ? 'Selesai Dibaca (' + counter + '/' + targetCount + 'x) — Ulangi' : 'Hitung Bacaan (' + counter + ' / ' + targetCount + 'x) +1'"></span>
                    </button>

                    <button
                        type="button"
                        @click="showGuide = !showGuide"
                        class="inline-flex items-center justify-center gap-2 min-h-[44px] px-5 py-2.5 rounded-full border border-white/25 bg-white/5 text-white text-body-sm font-semibold hover:bg-white/10 transition"
                    >
                        <svg class="w-4 h-4 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Panduan Bacaan</span>
                    </button>
                </div>

                <div
                    x-show="showGuide"
                    x-transition
                    style="display: none;"
                    class="text-left rounded-xl bg-black/25 border border-white/15 p-4 text-body-sm text-brand-gold-pale/90 leading-relaxed"
                >
                    Bacaan <strong>{{ $tahlilItem->judul }}</strong> merupakan urutan ke-{{ $tahlilItem->urutan }} dalam susunan Tahlil &amp; Doa Arwah ({{ $tahlilItem->keterangan ?? 'Tahlil Nusantara' }}). Dianjurkan dibaca sebanyak <strong>{{ $tahlilItem->jumlah_baca }} kali</strong> dengan khusyuk dan tartil.
                </div>

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

            {{-- Kartu Bacaan Utama yang Sedang Dibuka + Rangkaian Urutan Berikutnya --}}
            <section aria-label="Detail Bacaan Tahlil" class="space-y-5">
                {{-- Kartu Utama (State Aktif Berbingkai Emas seperti Ayat yang Sedang Dipilih) --}}
                <article
                    id="urutan-{{ $tahlilItem->urutan }}"
                    class="rounded-card p-5 sm:p-7 bg-surface-card border-2 border-brand-gold shadow-ayah-active transition duration-200"
                >
                    {{-- Header Kartu --}}
                    <div class="flex items-center justify-between gap-3 pb-4 border-b border-line/60">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-brand-navy text-brand-gold ring-2 ring-brand-gold text-label-md font-bold shrink-0">
                                #{{ $tahlilItem->urutan }}
                            </span>

                            <span class="text-body-sm font-semibold text-ink">
                                Urutan {{ $tahlilItem->urutan }}
                            </span>

                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-brand-navy text-brand-gold text-label-sm font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-gold animate-pulse"></span>
                                Sedang Dibaca
                            </span>
                        </div>

                        <span class="text-label-sm font-medium text-ink-muted">
                            Dibaca {{ $tahlilItem->jumlah_baca }}x &middot; {{ $tahlilItem->keterangan ?? 'Tahlil' }}
                        </span>
                    </div>

                    {{-- Teks Arab --}}
                    <div class="py-6">
                        <p class="quran-arabic text-ink text-right leading-[2.25]" dir="rtl" lang="ar">
                            {{ $tahlilItem->teks_arab }}
                            <span class="inline-flex items-center justify-center mx-1 text-brand-teal select-none">
                                &#xFD3F;{{ $toArabicDigits($tahlilItem->urutan) }}&#xFD3E;
                            </span>
                        </p>
                    </div>

                    {{-- Transliterasi Latin & Terjemahan Indonesia --}}
                    <div class="space-y-2.5">
                        @if ($tahlilItem->teks_latin)
                            <p
                                x-show="showLatin"
                                class="text-body-md text-brand-teal italic leading-relaxed"
                            >
                                {{ $tahlilItem->teks_latin }}
                            </p>
                        @endif

                        @if ($tahlilItem->terjemahan)
                            <p
                                x-show="showTranslation"
                                class="text-body-md text-ink leading-relaxed"
                            >
                                {{ $tahlilItem->terjemahan }}
                            </p>
                        @endif
                    </div>

                    {{-- Footer Aksi Kartu --}}
                    <div class="mt-6 pt-4 border-t border-line/60 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                @click="incrementCounter()"
                                class="inline-flex items-center gap-1.5 min-h-[36px] px-4 py-1.5 rounded-full bg-brand-navy text-white text-label-md font-semibold transition hover:bg-brand-teal"
                            >
                                <span x-text="counter >= targetCount ? '✓ Selesai (' + counter + '/' + targetCount + 'x)' : 'Hitung (' + counter + '/' + targetCount + 'x) +1'"></span>
                            </button>

                            <button
                                type="button"
                                @click="copyTahlilText({{ $tahlilItem->urutan }}, @js($tahlilItem->judul), @js($tahlilItem->teks_arab), @js($tahlilItem->teks_latin), @js($tahlilItem->terjemahan))"
                                aria-label="Salin bacaan {{ $tahlilItem->judul }}"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-full text-ink-muted hover:text-brand-teal hover:bg-surface-low transition"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                </svg>
                            </button>

                            <span
                                x-show="copiedUrutan === {{ $tahlilItem->urutan }}"
                                x-transition
                                style="display: none;"
                                class="text-label-sm font-semibold text-brand-teal"
                            >
                                Tersalin!
                            </span>
                        </div>

                        @if ($nextItem)
                            <a
                                href="{{ route('tahlil.show', $nextItem->urutan) }}"
                                wire:navigate
                                class="inline-flex items-center gap-1 text-body-sm font-semibold text-brand-teal hover:underline"
                            >
                                <span>Lanjut Urutan #{{ $nextItem->urutan }}</span>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        @endif
                    </div>
                </article>

                {{-- Kartu-Kartu Urutan Tahlil Berikutnya (Desain Kartu Ayat Normal) --}}
                @foreach ($followingItems as $nextRow)
                    <article
                        id="urutan-{{ $nextRow->urutan }}"
                        class="rounded-card p-5 sm:p-7 bg-surface-card border border-line shadow-card transition duration-200 hover:border-brand-gold/60"
                    >
                        {{-- Header Kartu --}}
                        <div class="flex items-center justify-between gap-3 pb-4 border-b border-line/60">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-brand-navy text-brand-gold text-label-md font-bold shrink-0">
                                    #{{ $nextRow->urutan }}
                                </span>

                                <div>
                                    <span class="text-body-sm font-bold text-brand-navy dark:text-ink block">
                                        {{ $nextRow->judul }}
                                    </span>
                                    <span class="text-label-sm text-ink-muted">
                                        Urutan {{ $nextRow->urutan }}
                                    </span>
                                </div>
                            </div>

                            <span class="text-label-sm font-medium text-ink-muted shrink-0">
                                Dibaca {{ $nextRow->jumlah_baca }}x &middot; {{ $nextRow->keterangan ?? 'Tahlil' }}
                            </span>
                        </div>

                        {{-- Teks Arab --}}
                        <div class="py-6">
                            <p class="quran-arabic text-ink text-right leading-[2.25]" dir="rtl" lang="ar">
                                {{ $nextRow->teks_arab }}
                                <span class="inline-flex items-center justify-center mx-1 text-brand-teal select-none">
                                    &#xFD3F;{{ $toArabicDigits($nextRow->urutan) }}&#xFD3E;
                                </span>
                            </p>
                        </div>

                        {{-- Transliterasi Latin & Terjemahan Indonesia --}}
                        <div class="space-y-2.5">
                            @if ($nextRow->teks_latin)
                                <p
                                    x-show="showLatin"
                                    class="text-body-md text-brand-teal italic leading-relaxed"
                                >
                                    {{ $nextRow->teks_latin }}
                                </p>
                            @endif

                            @if ($nextRow->terjemahan)
                                <p
                                    x-show="showTranslation"
                                    class="text-body-md text-ink leading-relaxed"
                                >
                                    {{ $nextRow->terjemahan }}
                                </p>
                            @endif
                        </div>

                        {{-- Footer Aksi Kartu --}}
                        <div class="mt-6 pt-4 border-t border-line/60 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <a
                                    href="{{ route('tahlil.show', $nextRow->urutan) }}"
                                    wire:navigate
                                    class="inline-flex items-center gap-1.5 min-h-[36px] px-4 py-1.5 rounded-full bg-surface-low border border-line text-label-md font-semibold text-ink hover:border-brand-teal transition"
                                >
                                    <span>&#9654; Fokus Bacaan</span>
                                </a>

                                <button
                                    type="button"
                                    @click="copyTahlilText({{ $nextRow->urutan }}, @js($nextRow->judul), @js($nextRow->teks_arab), @js($nextRow->teks_latin), @js($nextRow->terjemahan))"
                                    aria-label="Salin bacaan {{ $nextRow->judul }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-full text-ink-muted hover:text-brand-teal hover:bg-surface-low transition"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                    </svg>
                                </button>

                                <span
                                    x-show="copiedUrutan === {{ $nextRow->urutan }}"
                                    x-transition
                                    style="display: none;"
                                    class="text-label-sm font-semibold text-brand-teal"
                                >
                                    Tersalin!
                                </span>
                            </div>

                            <a
                                href="{{ route('tahlil.show', $nextRow->urutan) }}"
                                wire:navigate
                                class="inline-flex items-center gap-1 text-body-sm font-semibold text-brand-teal hover:underline"
                            >
                                <span>Buka Detail</span>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </section>

            {{-- Banner Bacaan Terpilih (Doa Tahlil & Doa Arwah Penutup — Urutan #24) --}}
            @if ($closingDoaItem && $tahlilItem->urutan !== $closingDoaItem->urutan)
                <section aria-label="Doa Penutup Tahlil" class="rounded-card bg-brand-navy text-white p-6 sm:p-7 shadow-md space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div class="flex items-center gap-2.5">
                            <span class="px-3 py-0.5 rounded-full bg-brand-gold text-brand-navy text-label-sm font-bold">
                                Doa Penutup
                            </span>
                            <h2 class="text-title-md font-bold text-white">
                                {{ $closingDoaItem->judul }} — Urutan #{{ $closingDoaItem->urutan }}
                            </h2>
                        </div>

                        <a
                            href="{{ route('tahlil.show', $closingDoaItem->urutan) }}"
                            wire:navigate
                            class="inline-flex items-center gap-1.5 text-label-md font-semibold text-brand-gold hover:underline"
                        >
                            <span>Buka Langsung Doa Tahlil</span>
                            <span aria-hidden="true">&#8599;</span>
                        </a>
                    </div>

                    <p class="quran-arabic text-brand-gold text-right leading-[2.2]" dir="rtl" lang="ar">
                        {{ \Illuminate\Support\Str::words($closingDoaItem->teks_arab, 18, ' ...') }}
                    </p>

                    <p class="text-body-sm text-brand-gold-pale/90 italic leading-relaxed">
                        "{{ \Illuminate\Support\Str::limit($closingDoaItem->terjemahan, 160) }}"
                    </p>
                </section>
            @endif

            {{-- Footer Navigasi Urutan Sebelumnya & Berikutnya --}}
            <nav aria-label="Navigasi Urutan Bacaan Tahlil" class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-body-sm text-ink-muted">
                    Menampilkan Urutan <strong class="font-semibold text-ink">{{ $tahlilItem->urutan }}</strong> dari <strong class="font-semibold text-ink">{{ $allItems->count() }} Bacaan Tahlil</strong>
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    @if ($previousItem)
                        <a
                            href="{{ route('tahlil.show', $previousItem->urutan) }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition"
                        >
                            <span aria-hidden="true">&larr;</span>
                            <span>Urutan Sebelumnya (#{{ $previousItem->urutan }})</span>
                        </a>
                    @else
                        <a
                            href="{{ route('tahlil.index') }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition"
                        >
                            <span aria-hidden="true">&larr;</span>
                            <span>Daftar Tahlil</span>
                        </a>
                    @endif

                    @if ($nextItem)
                        <a
                            href="{{ route('tahlil.show', $nextItem->urutan) }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-brand-teal text-white text-body-sm font-semibold hover:opacity-90 transition"
                        >
                            <span>Urutan Berikutnya (#{{ $nextItem->urutan }})</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    @else
                        <a
                            href="{{ route('tahlil.index') }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-brand-teal text-white text-body-sm font-semibold hover:opacity-90 transition"
                        >
                            <span>Selesai &amp; Kembali ke Daftar</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    @endif
                </div>
            </nav>
        </div>
    </div>
</x-app-layout>

