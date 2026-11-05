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
            bookmarkedDoas: @js($bookmarkedDoaIds),
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
                const el = document.getElementById('doa-' + slug);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            },
            async toggleBookmarkDoa(doaId) {
                @guest
                    window.location.href = '{{ route('login') }}';
                    return;
                @endguest

                try {
                    const response = await fetch('{{ route('bookmarks.toggle') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ type: 'doa', id: doaId })
                    });

                    if (response.status === 401) {
                        window.location.href = '{{ route('login') }}';
                        return;
                    }

                    const data = await response.json();
                    if (data.bookmarked) {
                        if (!this.bookmarkedDoas.includes(doaId)) {
                            this.bookmarkedDoas.push(doaId);
                        }
                    } else {
                        this.bookmarkedDoas = this.bookmarkedDoas.filter(id => id !== doaId);
                    }
                } catch (e) {
                    console.error(e);
                }
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
            <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-2 sm:py-2.5 flex items-center justify-between gap-2 sm:gap-3">
                <div class="flex items-center gap-2 sm:gap-2.5 min-w-0 flex-1">
                    <a
                        href="{{ route('doa.index') }}"
                        wire:navigate
                        class="inline-flex items-center gap-1.5 sm:gap-2 rounded-full bg-surface-low hover:bg-brand-gold-pale/60 border border-line hover:border-brand-gold px-3 sm:px-3.5 py-1.5 sm:py-2 text-label-sm sm:text-label-md font-semibold text-ink hover:text-brand-navy transition shrink-0"
                        title="Kembali ke Daftar Kategori Doa"
                    >
                        <svg class="w-4 h-4 text-brand-teal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali</span>
                    </a>

                    <div class="inline-flex items-center gap-1.5 sm:gap-2 rounded-full bg-surface-low hover:bg-surface-card border border-line hover:border-brand-teal px-3 sm:px-3.5 py-1.5 sm:py-2 text-label-sm sm:text-label-md font-semibold text-ink transition shadow-sm min-w-0 flex-1 sm:flex-initial sm:max-w-[340px]">
                        <svg class="w-4 h-4 text-brand-teal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <label for="jump-doa-select" class="text-ink-muted whitespace-nowrap shrink-0">Buka:</label>
                        <select
                            id="jump-doa-select"
                            @change="jumpToDoa($event.target.value)"
                            class="bg-transparent border-0 text-body-xs sm:text-body-sm font-semibold text-ink py-0 pl-0.5 pr-6 sm:pr-7 focus:ring-0 focus:outline-none cursor-pointer truncate w-full"
                        >
                            @foreach ($doas as $doaOption)
                                <option class="bg-surface-card text-ink" value="{{ $doaOption->slug }}" @selected($doaOption->slug === $firstDoaSlug)>
                                    {{ $doaOption->judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    {{-- Dropdown Pengaturan Bacaan (Font, Transliterasi, Terjemahan) --}}
                    <div x-data="{ settingsOpen: false }" class="relative">
                        <button
                            type="button"
                            @click="settingsOpen = !settingsOpen"
                            @keydown.escape.window="settingsOpen = false"
                            aria-label="Pengaturan Tampilan"
                            title="Pengaturan Tampilan Bacaan"
                            :aria-expanded="settingsOpen"
                            class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-full border border-line bg-surface-low text-ink hover:text-brand-teal hover:border-brand-teal hover:bg-surface-card transition shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold shrink-0"
                            :class="settingsOpen ? 'text-brand-teal border-brand-teal bg-surface-card ring-2 ring-brand-teal/20' : ''"
                        >
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 transition-transform duration-200" :class="settingsOpen ? 'rotate-45' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>

                        <div
                            x-show="settingsOpen"
                            @click.outside="settingsOpen = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            style="display: none;"
                            class="absolute right-0 mt-2.5 w-[calc(100vw-2rem)] sm:w-80 max-w-sm rounded-2xl bg-surface-card border border-line shadow-xl p-5 z-50 space-y-4"
                        >
                            <div class="flex items-center justify-between pb-3 border-b border-line/60">
                                <h3 class="text-title-sm font-bold text-ink">Pengaturan Tampilan</h3>
                                <button
                                    type="button"
                                    @click="settingsOpen = false"
                                    aria-label="Tutup pengaturan"
                                    class="w-6 h-6 inline-flex items-center justify-center rounded-full text-ink-muted hover:text-ink hover:bg-surface-low transition"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Ukuran Font Arab --}}
                            <div class="flex items-center justify-between gap-3 pt-1">
                                <div>
                                    <p class="text-body-sm font-semibold text-ink">Ukuran Font</p>
                                    <p class="text-label-sm text-ink-muted">Huruf teks Arab</p>
                                </div>
                                <div class="inline-flex items-center rounded-full bg-surface-low border border-line px-2 py-1 gap-1.5" role="group" aria-label="Pengaturan ukuran huruf Arab">
                                    <button
                                        type="button"
                                        @click="decreaseFont()"
                                        aria-label="Perkecil huruf Arab"
                                        class="w-7 h-7 rounded-full text-label-md font-bold text-ink hover:bg-surface-card hover:text-brand-teal transition flex items-center justify-center"
                                    >
                                        A-
                                    </button>
                                    <span class="text-label-sm font-bold text-ink min-w-[36px] text-center select-none" x-text="fontSize + 'px'">36px</span>
                                    <button
                                        type="button"
                                        @click="increaseFont()"
                                        aria-label="Perbesar huruf Arab"
                                        class="w-7 h-7 rounded-full text-label-md font-bold text-ink hover:bg-surface-card hover:text-brand-teal transition flex items-center justify-center"
                                    >
                                        A+
                                    </button>
                                </div>
                            </div>

                            {{-- Toggle Transliterasi --}}
                            <div class="flex items-center justify-between gap-3 pt-3 border-t border-line/60">
                                <div>
                                    <p class="text-body-sm font-semibold text-ink">Transliterasi</p>
                                    <p class="text-label-sm text-ink-muted">Teks bacaan latin</p>
                                </div>
                                <button
                                    type="button"
                                    role="switch"
                                    :aria-checked="showLatin"
                                    @click="showLatin = !showLatin"
                                    aria-label="Toggle transliterasi latin"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-teal"
                                    :class="showLatin ? 'bg-brand-teal' : 'bg-gray-300 dark:bg-gray-600'"
                                >
                                    <span
                                        class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out"
                                        :class="showLatin ? 'translate-x-5' : 'translate-x-0'"
                                    ></span>
                                </button>
                            </div>

                            {{-- Toggle Terjemahan --}}
                            <div class="flex items-center justify-between gap-3 pt-3 border-t border-line/60">
                                <div>
                                    <p class="text-body-sm font-semibold text-ink">Terjemahan</p>
                                    <p class="text-label-sm text-ink-muted">Arti bahasa Indonesia</p>
                                </div>
                                <button
                                    type="button"
                                    role="switch"
                                    :aria-checked="showTranslation"
                                    @click="showTranslation = !showTranslation"
                                    aria-label="Toggle terjemahan bahasa Indonesia"
                                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-teal"
                                    :class="showTranslation ? 'bg-brand-teal' : 'bg-gray-300 dark:bg-gray-600'"
                                >
                                    <span
                                        class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out"
                                        :class="showTranslation ? 'translate-x-5' : 'translate-x-0'"
                                    ></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kontainer Utama Mushaf (max-w-mushaf = 840px sesuai halaman Detail Surah) --}}
        <div class="max-w-mushaf mx-auto px-gutter-mobile md:px-gutter py-6 md:py-10 space-y-6 pb-28 md:pb-12">
            {{-- Banner Header Kategori Doa (Deep Navy) --}}
            <section class="rounded-card bg-gradient-to-b from-[#0A223D] via-[#0F2D4F] to-[#0A223D] text-white px-6 py-8 sm:px-10 sm:py-10 shadow-lg border border-white/10 text-center space-y-6">
                <div class="flex flex-wrap items-center justify-center gap-2.5">
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

                <div class="flex flex-col items-center pt-1">
                    <p class="quran-banner-title text-brand-gold py-1" dir="rtl" lang="ar">
                        أَدْعِيَةٌ مَأْثُوْرَةٌ
                    </p>
                    <h1 class="text-headline-lg sm:text-4xl font-bold text-white tracking-tight mt-2">
                        {{ $category->nama }}
                    </h1>
                    <p class="text-body-sm sm:text-body-md text-[#8FB2D6] italic max-w-2xl mx-auto mt-2">
                        "{{ $doaSummaryList }}"
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-3.5 pt-1">
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

                <div class="pt-6 mt-2 border-t border-white/15 flex flex-col items-center gap-2.5">
                    <p class="quran-banner-basmalah text-brand-gold py-1" dir="rtl" lang="ar">
                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </p>
                    <p class="text-body-sm text-[#8FB2D6]">
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
                        class="rounded-card p-5 sm:p-7 bg-surface-card border border-line shadow-card transition duration-200 hover:border-brand-gold/60"
                    >
                        {{-- Header Kartu Doa --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-line/60">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-brand-navy text-brand-gold text-label-md font-bold shrink-0">
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
                                @guest
                                    <a
                                        href="{{ route('login') }}"
                                        wire:navigate
                                        title="Masuk untuk menandai doa"
                                        aria-label="Masuk untuk menandai {{ $doa->judul }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-full text-ink-muted hover:text-brand-gold hover:bg-surface-low transition"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                        </svg>
                                    </a>
                                @else
                                    <button
                                        type="button"
                                        @click="toggleBookmarkDoa({{ $doa->id }})"
                                        :title="bookmarkedDoas.includes({{ $doa->id }}) ? 'Hapus penanda doa ini' : 'Tandai doa ini'"
                                        :aria-label="bookmarkedDoas.includes({{ $doa->id }}) ? 'Hapus penanda {{ $doa->judul }}' : 'Simpan penanda {{ $doa->judul }}'"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-full transition"
                                        :class="bookmarkedDoas.includes({{ $doa->id }})
                                            ? 'text-brand-gold bg-brand-gold/15'
                                            : 'text-ink-muted hover:text-brand-gold hover:bg-surface-low'"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            :class="bookmarkedDoas.includes({{ $doa->id }}) ? 'fill-current text-brand-gold' : 'fill-none'"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            aria-hidden="true"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                        </svg>
                                    </button>
                                @endguest
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
            <nav aria-label="Navigasi Kategori Doa" class="pt-6 border-t border-line/60 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-body-sm text-ink-muted text-center sm:text-left sm:whitespace-nowrap leading-relaxed">
                    Menampilkan <strong class="font-semibold text-ink">1 - {{ $doas->count() }} Doa</strong> dalam kategori <strong class="font-semibold text-ink">{{ $category->nama }}</strong>
                </p>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center sm:justify-end gap-2.5 sm:gap-3 w-full sm:w-auto">
                    @if ($previousCategory)
                        <a
                            href="{{ route('doa.show', $previousCategory->slug) }}"
                            wire:navigate
                            class="inline-flex items-center justify-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition shadow-sm w-full sm:w-auto"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            <span>{{ $previousCategory->nama }}</span>
                        </a>
                    @else
                        <a
                            href="{{ route('doa.index') }}"
                            wire:navigate
                            class="inline-flex items-center justify-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition shadow-sm w-full sm:w-auto"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            <span>Semua Kategori Doa</span>
                        </a>
                    @endif

                    @if ($nextCategory)
                        <a
                            href="{{ route('doa.show', $nextCategory->slug) }}"
                            wire:navigate
                            class="inline-flex items-center justify-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-brand-teal text-white text-body-sm font-semibold hover:bg-brand-navy transition shadow-sm w-full sm:w-auto"
                        >
                            <span>{{ $nextCategory->nama }}</span>
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    @else
                        <a
                            href="{{ route('doa.index') }}"
                            wire:navigate
                            class="inline-flex items-center justify-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-brand-teal text-white text-body-sm font-semibold hover:bg-brand-navy transition shadow-sm w-full sm:w-auto"
                        >
                            <span>Semua Kategori Doa</span>
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    @endif
                </div>
            </nav>
        </div>
    </div>
</x-app-layout>

