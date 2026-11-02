@php
    $toArabicDigits = static function (int $number): string {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($western, $eastern, (string) $number);
    };

    $firstDoaSlug = $targetDoaSlug ?? ($doas->first()?->slug ?? '');
    $doaSummaryList = $doas->pluck('judul')->implode(' • ');
@endphp

<x-app-layout
    :title="$category->nama . ' — Kumpulan Doa'"
    :description="'Kumpulan lengkap ' . $category->nama . ' (' . $doaSummaryList . ') beserta teks Arab, transliterasi Latin, terjemahan Indonesia, dan sumber dalil.'"
>
    <div
        x-data="{
            showLatin: true,
            showTranslation: true,
            fontSize: 36,
            showGuide: false,
            activeDoaSlug: @js($firstDoaSlug),
            copiedDoaId: null,
            decreaseFont() {
                this.fontSize = Math.max(24, this.fontSize - 2);
                document.documentElement.style.setProperty('--quran-font-size', this.fontSize + 'px');
            },
            increaseFont() {
                this.fontSize = Math.min(52, this.fontSize + 2);
                document.documentElement.style.setProperty('--quran-font-size', this.fontSize + 'px');
            },
            jumpToDoa(slug) {
                if (!slug) return;
                this.activeDoaSlug = slug;
                const el = document.getElementById('doa-' + slug);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            },
            copyDoaText(id, judul, arab, latin, translation, sumber) {
                const text = judul + '\n\n' + arab + '\n\n' + (latin || '') + '\n\n' + (translation || '') + (sumber ? '\n(' + sumber + ')' : '');
                navigator.clipboard.writeText(text).then(() => {
                    this.copiedDoaId = id;
                    setTimeout(() => { this.copiedDoaId = null; }, 2000);
                });
            }
        }"
        x-init="
            document.documentElement.style.setProperty('--quran-font-size', fontSize + 'px');
            @if ($targetDoaSlug)
                setTimeout(() => {
                    const targetEl = document.getElementById('doa-{{ $targetDoaSlug }}');
                    if (targetEl) targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 250);
            @endif
        "
    >
        {{-- Sticky Sub-Header / Toolbar Kontrol Bacaan (Persis Detail Surah & Detail Tahlil) --}}
        <div class="sticky top-20 z-30 bg-surface-card/95 backdrop-blur border-b border-line shadow-sm">
            <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-2.5 flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2.5">
                    <a
                        href="{{ route('doa.index') }}"
                        wire:navigate
                        class="inline-flex items-center gap-2 rounded-full bg-surface-low hover:bg-brand-gold-pale/60 border border-line hover:border-brand-gold px-3.5 py-2 text-label-md font-semibold text-ink hover:text-brand-navy transition"
                        title="Kembali ke Daftar Kategori Doa"
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
                        <label for="jump-doa-select" class="text-label-md text-ink-muted whitespace-nowrap">Lompat ke Doa:</label>
                        <select
                            id="jump-doa-select"
                            @change="jumpToDoa($event.target.value)"
                            class="bg-surface-card border border-line rounded-lg text-body-sm font-semibold text-ink py-1 pl-3 pr-7 focus:border-brand-teal focus:ring-0 max-w-[230px]"
                        >
                            @foreach ($doas as $index => $doaOption)
                                <option value="{{ $doaOption->slug }}" @selected($doaOption->slug === $firstDoaSlug)>
                                    {{ $index + 1 }}. {{ $doaOption->judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full bg-brand-teal/15 text-brand-teal text-label-md font-semibold">
                        {{ $doas->count() }} Doa Pilihan
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
                    <select
                        aria-label="Pilih kategori doa lainnya"
                        onchange="window.location.href = this.value"
                        class="rounded-full bg-surface-low border border-line px-4 py-1.5 pr-8 text-body-sm font-medium text-ink focus:border-brand-teal focus:ring-0"
                    >
                        @foreach ($allCategories as $catItem)
                            <option value="{{ route('doa.show', $catItem->slug) }}" @selected($catItem->id === $category->id)>
                                {{ $catItem->nama }} ({{ $catItem->doas_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Kontainer Utama Mushaf (max-w-mushaf = 840px sesuai halaman Detail Surah) --}}
        <div class="max-w-mushaf mx-auto px-gutter-mobile md:px-gutter py-8 md:py-10 space-y-6">
            {{-- Banner Header Kategori Doa (Deep Navy) --}}
            <section class="rounded-card bg-gradient-to-b from-[#0A223D] via-[#0F2D4F] to-[#0A223D] text-white p-6 sm:p-10 shadow-lg border border-white/10 text-center space-y-5">
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="px-3.5 py-1 rounded-full bg-white/10 border border-white/10 text-label-sm font-bold uppercase tracking-wider text-brand-gold">
                        Kategori Ke-{{ $category->urutan }}
                    </span>
                    <span class="px-3.5 py-1 rounded-full bg-white/10 border border-white/10 text-label-sm font-bold uppercase tracking-wider text-white">
                        {{ $doas->count() }} Doa Lengkap
                    </span>
                    <span class="px-3.5 py-1 rounded-full bg-brand-teal/35 border border-brand-teal/50 text-label-sm font-bold uppercase tracking-wider text-[#9BE8F0]">
                        AL-QUR'AN &amp; AS-SUNNAH
                    </span>
                </div>

                <div class="space-y-2 pt-1">
                    <p class="font-arabic text-4xl sm:text-5xl text-brand-gold leading-relaxed" dir="rtl" lang="ar">
                        أَدْعِيَةٌ مَأْثُوْرَةٌ
                    </p>
                    <h1 class="text-headline-lg sm:text-4xl font-bold text-white tracking-tight">
                        {{ $category->nama }}
                    </h1>
                    <p class="text-body-sm sm:text-body-md text-[#8FB2D6] italic max-w-2xl mx-auto">
                        "{{ $doaSummaryList }}"
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-3 pt-1">
                    @if ($doas->isNotEmpty())
                        <button
                            type="button"
                            @click="jumpToDoa('{{ $doas->first()->slug }}')"
                            class="inline-flex items-center justify-center gap-2 min-h-[44px] px-6 py-2.5 rounded-full bg-brand-gold text-brand-navy text-body-sm font-bold hover:bg-brand-gold-hover shadow-sm transition"
                        >
                            <span>&#9654;</span>
                            <span>Mulai Baca ({{ $doas->count() }} Doa)</span>
                        </button>
                    @endif

                    <button
                        type="button"
                        @click="showGuide = !showGuide"
                        class="inline-flex items-center justify-center gap-2 min-h-[44px] px-5 py-2.5 rounded-full border border-white/25 bg-white/5 text-white text-body-sm font-semibold hover:bg-white/10 transition"
                    >
                        <svg class="w-4 h-4 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Adab Berdoa</span>
                    </button>
                </div>

                <div
                    x-show="showGuide"
                    x-transition
                    style="display: none;"
                    class="text-left rounded-xl bg-black/25 border border-white/15 p-4 text-body-sm text-brand-gold-pale/90 leading-relaxed"
                >
                    Awali doa dengan memuji Allah SWT (tahmid) dan membaca shalawat kepada Rasulullah SAW, hadirkan hati dengan penuh harap (raja’) serta keyakinan bahwa Allah mengabulkan doa.
                </div>

                <div class="pt-5 mt-4 border-t border-white/10 space-y-1.5">
                    <p class="font-arabic text-3xl sm:text-4xl text-brand-gold leading-relaxed" dir="rtl" lang="ar">
                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </p>
                    <p class="text-label-sm text-[#8FB2D6]">
                        Dengan nama Allah Yang Maha Pengasih, Maha Penyayang.
                    </p>
                </div>
            </section>

            {{-- Daftar Keseluruhan Kartu Doa dalam Kategori Ini --}}
            <section aria-label="Daftar Doa {{ $category->nama }}" class="space-y-5">
                @foreach ($doas as $index => $doa)
                    @php
                        $nomorUrut = $index + 1;
                    @endphp

                    <article
                        id="doa-{{ $doa->slug }}"
                        @click="activeDoaSlug = '{{ $doa->slug }}'"
                        class="rounded-card p-5 sm:p-7 transition duration-200 cursor-pointer"
                        :class="activeDoaSlug === '{{ $doa->slug }}'
                            ? 'bg-surface-card border-2 border-brand-gold shadow-ayah-active'
                            : 'bg-surface-card border border-line shadow-card hover:border-brand-gold/60'"
                    >
                        {{-- Header Kartu Doa --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-line/60">
                            <div class="flex items-center gap-3">
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-brand-navy text-brand-gold text-label-md font-bold shrink-0"
                                    :class="activeDoaSlug === '{{ $doa->slug }}' ? 'ring-2 ring-brand-gold' : ''"
                                >
                                    {{ $category->urutan }}:{{ $nomorUrut }}
                                </span>

                                <div>
                                    <h2 class="text-title-md font-bold text-brand-navy dark:text-ink">
                                        {{ $doa->judul }}
                                    </h2>
                                    <span class="text-label-sm text-ink-muted">
                                        Doa ke-{{ $nomorUrut }} dari {{ $doas->count() }} &middot; {{ $category->nama }}
                                    </span>
                                </div>

                                <span
                                    x-show="activeDoaSlug === '{{ $doa->slug }}'"
                                    style="display: none;"
                                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-brand-navy text-brand-gold text-label-sm font-semibold"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-gold animate-pulse"></span>
                                    Sedang Dibaca
                                </span>
                            </div>

                            <span class="text-label-sm font-medium text-ink-muted">
                                {{ $doa->sumber ?? "Al-Qur'an & Hadits" }}
                            </span>
                        </div>

                        {{-- Teks Arab Doa --}}
                        <div class="py-6">
                            <p class="quran-arabic text-ink text-right leading-[2.25]" dir="rtl" lang="ar">
                                {{ $doa->teks_arab }}
                                <span class="inline-flex items-center justify-center mx-1 text-brand-teal select-none">
                                    &#xFD3F;{{ $toArabicDigits($nomorUrut) }}&#xFD3E;
                                </span>
                            </p>
                        </div>

                        {{-- Transliterasi Latin & Terjemahan Indonesia --}}
                        <div class="space-y-2.5">
                            @if ($doa->teks_latin)
                                <p
                                    x-show="showLatin"
                                    class="text-body-md text-brand-teal italic leading-relaxed"
                                >
                                    {{ $doa->teks_latin }}
                                </p>
                            @endif

                            <p
                                x-show="showTranslation"
                                class="text-body-md text-ink leading-relaxed"
                            >
                                {{ $doa->terjemahan }}
                            </p>
                        </div>

                        {{-- Footer Aksi Kartu Doa --}}
                        <div class="mt-6 pt-4 border-t border-line/60 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    @click.stop="activeDoaSlug = '{{ $doa->slug }}'"
                                    class="inline-flex items-center gap-1.5 min-h-[36px] px-4 py-1.5 rounded-full text-label-md font-semibold transition"
                                    :class="activeDoaSlug === '{{ $doa->slug }}'
                                        ? 'bg-brand-navy text-white'
                                        : 'bg-surface-low border border-line text-ink hover:border-brand-teal'"
                                >
                                    <span x-text="activeDoaSlug === '{{ $doa->slug }}' ? '✓ Sedang Dibaca' : 'Fokus Bacaan'"></span>
                                </button>

                                <button
                                    type="button"
                                    @click.stop="copyDoaText({{ $doa->id }}, @js($doa->judul), @js($doa->teks_arab), @js($doa->teks_latin), @js($doa->terjemahan), @js($doa->sumber))"
                                    aria-label="Salin teks {{ $doa->judul }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-full text-ink-muted hover:text-brand-teal hover:bg-surface-low transition"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                    </svg>
                                </button>

                                <span
                                    x-show="copiedDoaId === {{ $doa->id }}"
                                    x-transition
                                    style="display: none;"
                                    class="text-label-sm font-semibold text-brand-teal"
                                >
                                    Tersalin!
                                </span>
                            </div>

                            <span class="inline-flex items-center gap-1.5 text-label-sm font-semibold text-brand-teal">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $doa->sumber ?? 'Sanad Shahih' }}</span>
                            </span>
                        </div>
                    </article>
                @endforeach
            </section>

            {{-- Footer Navigasi Kategori Sebelumnya & Berikutnya --}}
            <nav aria-label="Navigasi Kategori Doa" class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-body-sm text-ink-muted">
                    Menampilkan <strong class="font-semibold text-ink">1 - {{ $doas->count() }} Doa</strong> dalam kategori <strong class="font-semibold text-ink">{{ $category->nama }}</strong>
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    @if ($previousCategory)
                        <a
                            href="{{ route('doa.show', $previousCategory->slug) }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition"
                        >
                            <span aria-hidden="true">&larr;</span>
                            <span>{{ $previousCategory->nama }}</span>
                        </a>
                    @else
                        <a
                            href="{{ route('doa.index') }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition"
                        >
                            <span aria-hidden="true">&larr;</span>
                            <span>Semua Kategori Doa</span>
                        </a>
                    @endif

                    @if ($nextCategory)
                        <a
                            href="{{ route('doa.show', $nextCategory->slug) }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-brand-teal text-white text-body-sm font-semibold hover:opacity-90 transition"
                        >
                            <span>{{ $nextCategory->nama }}</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    @else
                        <a
                            href="{{ route('doa.index') }}"
                            wire:navigate
                            class="inline-flex items-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-brand-teal text-white text-body-sm font-semibold hover:opacity-90 transition"
                        >
                            <span>Semua Kategori Doa</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    @endif
                </div>
            </nav>
        </div>
    </div>
</x-app-layout>

