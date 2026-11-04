@php
    $toArabicDigits = static function (int $number): string {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        return str_replace($western, $eastern, (string) $number);
    };

    $tempatTurunUpper = (($surah->tempat_turun instanceof \BackedEnum ? $surah->tempat_turun->value : $surah->tempat_turun) === 'mekah') ? 'MAKKIYYAH' : 'MADANIYYAH';
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
            bookmarkedAyahs: @js($bookmarkedAyahIds),
            isSurahFavorited: @js($isSurahFavorited),
            async shareAyah(ayahNumber, arab, translation) {
                const shareData = {
                    title: 'QS. {{ addslashes($surah->nama_latin) }}: ' + ayahNumber,
                    text: 'QS. {{ addslashes($surah->nama_latin) }}: Ayat ' + ayahNumber + '\n\n' + arab + '\n\n"' + translation + '"\n\nBaca di Lentera Quran: ' + window.location.origin + '/al-quran/{{ $surah->id }}?ayat=' + ayahNumber,
                    url: window.location.origin + '/al-quran/{{ $surah->id }}?ayat=' + ayahNumber
                };
                if (navigator.share) {
                    try {
                        await navigator.share(shareData);
                    } catch (e) {}
                } else {
                    this.copyAyahText(ayahNumber, arab, translation);
                }
            },
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
            },
            async toggleBookmarkAyah(ayahId) {
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
                        body: JSON.stringify({ type: 'ayah', id: ayahId })
                    });

                    if (response.status === 401) {
                        window.location.href = '{{ route('login') }}';
                        return;
                    }

                    const data = await response.json();
                    if (data.bookmarked) {
                        if (!this.bookmarkedAyahs.includes(ayahId)) {
                            this.bookmarkedAyahs.push(ayahId);
                        }
                    } else {
                        this.bookmarkedAyahs = this.bookmarkedAyahs.filter(id => id !== ayahId);
                    }
                } catch (e) {
                    console.error(e);
                }
            },
            async toggleFavoriteSurah(surahId) {
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
                        body: JSON.stringify({ type: 'surah', id: surahId })
                    });

                    if (response.status === 401) {
                        window.location.href = '{{ route('login') }}';
                        return;
                    }

                    const data = await response.json();
                    this.isSurahFavorited = Boolean(data.bookmarked);
                } catch (e) {
                    console.error(e);
                }
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

                <div class="flex items-center gap-3">
                    {{-- Dropdown Pengaturan Bacaan (Font, Transliterasi, Terjemahan) --}}
                    <div x-data="{ settingsOpen: false }" class="relative">
                        <button
                            type="button"
                            @click="settingsOpen = !settingsOpen"
                            @keydown.escape.window="settingsOpen = false"
                            aria-label="Pengaturan Tampilan"
                            title="Pengaturan Tampilan Bacaan"
                            :aria-expanded="settingsOpen"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full border border-line bg-surface-low text-ink hover:text-brand-teal hover:border-brand-teal hover:bg-surface-card transition shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                            :class="settingsOpen ? 'text-brand-teal border-brand-teal bg-surface-card ring-2 ring-brand-teal/20' : ''"
                        >
                            <svg class="w-5 h-5 transition-transform duration-200" :class="settingsOpen ? 'rotate-45' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
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
                            class="absolute right-0 mt-2.5 w-72 sm:w-80 rounded-2xl bg-surface-card border border-line shadow-xl p-5 z-50 space-y-4"
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
        </div>

        {{-- Kontainer Utama Mushaf (max-w-mushaf = 840px sesuai DESIGN.md) --}}
        <div class="max-w-mushaf mx-auto px-gutter-mobile md:px-gutter py-8 md:py-10 space-y-6">
            {{-- Banner Header Surah (Deep Navy) --}}
            <section class="rounded-card bg-gradient-to-b from-[#0A223D] via-[#0F2D4F] to-[#0A223D] text-white px-6 py-8 sm:px-10 sm:py-10 shadow-lg border border-white/10 text-center space-y-6">
                <div class="flex flex-wrap items-center justify-center gap-2.5">
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

                <div class="flex flex-col items-center pt-1">
                    <p class="quran-banner-title text-brand-gold py-1" dir="rtl" lang="ar">
                        سُورَةُ {{ $surah->nama_arab }}
                    </p>
                    <h1 class="text-headline-lg sm:text-4xl font-bold text-white tracking-tight mt-2">
                        {{ $surah->nama_latin }}
                    </h1>
                    <p class="text-body-sm sm:text-body-md text-[#8FB2D6] italic mt-2">
                        "{{ $surah->arti }}"
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-3.5 pt-1">
                    @if ($surah->audio_url)
                        <button
                            type="button"
                            @click="$store.audioPlayer.playTrack({ surahId: {{ $surah->id }}, surahName: '{{ addslashes($surah->nama_latin) }}', ayahNumber: null, totalAyat: {{ $surah->jumlah_ayat }}, src: '{{ $surah->audio_url }}' })"
                            class="inline-flex items-center justify-center gap-2 min-h-[44px] px-6 py-2.5 rounded-full text-brand-navy text-body-sm font-bold transition shadow-sm"
                            :class="$store.audioPlayer?.isCurrentSurah({{ $surah->id }}) && !$store.audioPlayer?.ayahNumber && $store.audioPlayer?.isPlaying
                                ? 'bg-white ring-2 ring-brand-gold hover:bg-white/95'
                                : 'bg-brand-gold hover:bg-brand-gold-hover'"
                        >
                            <span x-show="!($store.audioPlayer?.isCurrentSurah({{ $surah->id }}) && !$store.audioPlayer?.ayahNumber && $store.audioPlayer?.isPlaying)">&#9654; Putar Surah Penuh</span>
                            <span x-show="$store.audioPlayer?.isCurrentSurah({{ $surah->id }}) && !$store.audioPlayer?.ayahNumber && $store.audioPlayer?.isPlaying" style="display: none;">&#10074;&#10074; Jeda Surah Penuh</span>
                        </button>
                    @endif

                    <button
                        type="button"
                        @click="toggleSurahBookmark()"
                        class="inline-flex items-center justify-center gap-2 min-h-[44px] px-5 py-2.5 rounded-full border text-body-sm font-semibold transition"
                        :class="isSurahBookmarked
                            ? 'bg-brand-gold text-brand-navy border-brand-gold shadow-sm font-bold'
                            : 'border-white/25 bg-white/5 text-white hover:bg-white/10'"
                    >
                        <svg class="w-4 h-4 shrink-0" :class="isSurahBookmarked ? 'fill-current' : 'fill-none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                        </svg>
                        <span x-text="isSurahBookmarked ? 'Surah Tersimpan' : 'Simpan Surah'">Simpan Surah</span>
                    </button>

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

                    @guest
                        <a
                            href="{{ route('login') }}"
                            wire:navigate
                            title="Masuk untuk menambahkan ke favorit"
                            class="inline-flex items-center justify-center gap-2 min-h-[44px] px-5 py-2.5 rounded-full border border-white/25 bg-white/5 text-white text-body-sm font-semibold hover:bg-white/10 transition"
                        >
                            <svg class="w-4 h-4 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                            <span>Favorit</span>
                        </a>
                    @else
                        <button
                            type="button"
                            @click="toggleFavoriteSurah({{ $surah->id }})"
                            class="inline-flex items-center justify-center gap-2 min-h-[44px] px-5 py-2.5 rounded-full border transition"
                            :class="isSurahFavorited ? 'border-brand-gold bg-brand-gold/20 text-brand-gold' : 'border-white/25 bg-white/5 text-white hover:bg-white/10'"
                            :title="isSurahFavorited ? 'Hapus dari favorit' : 'Tambah ke favorit'"
                        >
                            <svg class="w-4 h-4" :class="isSurahFavorited ? 'fill-current text-brand-gold' : 'fill-none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                            <span x-text="isSurahFavorited ? 'Favorit' : 'Favoritkan'">Favoritkan</span>
                        </button>
                    @endguest
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
                    <div class="pt-6 mt-2 border-t border-white/15 flex flex-col items-center gap-2.5">
                        <p class="quran-banner-basmalah text-brand-gold py-1" dir="rtl" lang="ar">
                            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                        </p>
                        <p class="text-body-sm text-[#8FB2D6]">
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
                                        @click="$store.audioPlayer.playTrack({ surahId: {{ $surah->id }}, surahName: '{{ addslashes($surah->nama_latin) }}', ayahNumber: {{ $ayah->nomor_ayat }}, totalAyat: {{ $surah->jumlah_ayat }}, src: '{{ $ayah->audio_url }}' })"
                                        class="inline-flex items-center gap-1.5 min-h-[36px] px-4 py-1.5 rounded-full text-label-md font-semibold transition"
                                        :class="$store.audioPlayer && $store.audioPlayer.isCurrentAyah({{ $surah->id }}, {{ $ayah->nomor_ayat }}) && $store.audioPlayer.isPlaying
                                            ? 'bg-brand-navy text-white'
                                            : 'bg-surface-low border border-line text-ink hover:border-brand-teal'"
                                    >
                                        <span x-show="!($store.audioPlayer && $store.audioPlayer.isCurrentAyah({{ $surah->id }}, {{ $ayah->nomor_ayat }}) && $store.audioPlayer.isPlaying)">&#9654; Putar</span>
                                        <span x-show="$store.audioPlayer && $store.audioPlayer.isCurrentAyah({{ $surah->id }}, {{ $ayah->nomor_ayat }}) && $store.audioPlayer.isPlaying" style="display: none;">&#10074;&#10074; Jeda</span>
                                    </button>
                                @endif

                                @guest
                                    <a
                                        href="{{ route('login') }}"
                                        wire:navigate
                                        aria-label="Masuk untuk menandai ayat {{ $ayah->nomor_ayat }}"
                                        title="Masuk untuk menandai ayat"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-full text-ink-muted hover:text-brand-gold hover:bg-surface-low transition"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                        </svg>
                                    </a>
                                @else
                                    <button
                                        type="button"
                                        @click="toggleBookmarkAyah({{ $ayah->id }})"
                                        :aria-label="bookmarkedAyahs.includes({{ $ayah->id }}) ? 'Hapus penanda ayat {{ $ayah->nomor_ayat }}' : 'Simpan penanda ayat {{ $ayah->nomor_ayat }}'"
                                        :title="bookmarkedAyahs.includes({{ $ayah->id }}) ? 'Hapus penanda ayat ini' : 'Tandai ayat ini'"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-full transition"
                                        :class="bookmarkedAyahs.includes({{ $ayah->id }})
                                            ? 'text-brand-gold bg-brand-gold/15'
                                            : 'text-ink-muted hover:text-brand-gold hover:bg-surface-low'"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            :class="bookmarkedAyahs.includes({{ $ayah->id }}) ? 'fill-current text-brand-gold' : 'fill-none'"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            aria-hidden="true"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                        </svg>
                                    </button>
                                @endguest

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

                                <button
                                    type="button"
                                    @click="shareAyah({{ $ayah->nomor_ayat }}, @js($ayah->teks_arab), @js($ayah->terjemahan))"
                                    aria-label="Bagikan ayat {{ $ayah->nomor_ayat }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-full text-ink-muted hover:text-brand-gold hover:bg-surface-low transition"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
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

    @auth
        @if ($ayahs->isNotEmpty())
            <script>
                (function () {
                    try {
                        fetch('{{ route('terakhir-dibaca.store', $surah->id) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ ayah_id: {{ $ayahs->first()->id }} })
                        }).catch(function () {});
                    } catch (e) {}
                })();
            </script>
        @endif
    @endauth
</x-app-layout>

