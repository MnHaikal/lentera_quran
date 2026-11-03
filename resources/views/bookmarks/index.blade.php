<x-app-layout
    title="Penanda & Favorit"
    description="Koleksi surah favorit, penanda ayat Al-Qur'an, bacaan tahlil, dan doa tersimpan Anda di Lentera Quran."
>
    <div
        x-data="{
            activeTab: 'semua',
            surahList: @js($surahBookmarks->pluck('bookmarkable_id')),
            ayahList: @js($ayahBookmarks->pluck('bookmarkable_id')),
            tahlilList: @js($tahlilBookmarks->pluck('bookmarkable_id')),
            tahlilBacaanList: @js($tahlilBacaanBookmarks->pluck('bookmarkable_id')),
            doaCategoryList: @js($doaCategoryBookmarks->pluck('bookmarkable_id')),
            doaList: @js($doaBookmarks->pluck('bookmarkable_id')),
            totalCount() {
                return this.surahList.length + this.ayahList.length + this.tahlilList.length + this.tahlilBacaanList.length + this.doaCategoryList.length + this.doaList.length;
            },
            async removeBookmark(type, id, domId) {
                try {
                    const response = await fetch('{{ route('bookmarks.toggle') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ type: type, id: id })
                    });

                    if (response.ok) {
                        const el = document.getElementById(domId);
                        if (el) {
                            el.remove();
                        }
                        if (type === 'surah') {
                            this.surahList = this.surahList.filter(item => item !== id);
                        } else if (type === 'ayah') {
                            this.ayahList = this.ayahList.filter(item => item !== id);
                        } else if (type === 'tahlil') {
                            this.tahlilList = this.tahlilList.filter(item => item !== id);
                        } else if (type === 'tahlil_bacaan') {
                            this.tahlilBacaanList = this.tahlilBacaanList.filter(item => item !== id);
                        } else if (type === 'doa_category') {
                            this.doaCategoryList = this.doaCategoryList.filter(item => item !== id);
                        } else if (type === 'doa') {
                            this.doaList = this.doaList.filter(item => item !== id);
                        }
                    }
                } catch (e) {
                    console.error(e);
                }
            }
        }"
        class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-8 md:py-12 space-y-8"
    >
        {{-- Header Halaman Penanda --}}
        <div class="space-y-3">
            <h1 class="text-headline-lg sm:text-display-sm font-bold text-ink tracking-tight">
                Penanda &amp; Koleksi Favorit
            </h1>
            <p class="text-body-md text-ink-muted max-w-2xl leading-relaxed">
                Kelola surah favorit, penanda ayat, bacaan tahlil, dan doa yang telah Anda simpan untuk memudahkan tilawah dan ibadah harian Anda.
            </p>
        </div>

        {{-- Navigasi Tab Filter --}}
        <div class="flex flex-wrap items-center gap-2 border-b border-line pb-3">
            <button
                type="button"
                @click="activeTab = 'semua'"
                class="px-4 py-2 rounded-full text-label-md font-semibold transition"
                :class="activeTab === 'semua' ? 'bg-brand-teal text-white shadow-sm' : 'bg-surface-low text-ink hover:text-brand-teal'"
            >
                Semua Koleksi (<span x-text="totalCount()"></span>)
            </button>
            <button
                type="button"
                @click="activeTab = 'surah'"
                class="px-4 py-2 rounded-full text-label-md font-semibold transition"
                :class="activeTab === 'surah' ? 'bg-brand-teal text-white shadow-sm' : 'bg-surface-low text-ink hover:text-brand-teal'"
            >
                Surah Favorit (<span x-text="surahList.length"></span>)
            </button>
            <button
                type="button"
                @click="activeTab = 'ayah'"
                class="px-4 py-2 rounded-full text-label-md font-semibold transition"
                :class="activeTab === 'ayah' ? 'bg-brand-teal text-white shadow-sm' : 'bg-surface-low text-ink hover:text-brand-teal'"
            >
                Penanda Ayat (<span x-text="ayahList.length"></span>)
            </button>
            <button
                type="button"
                @click="activeTab = 'tahlil'"
                class="px-4 py-2 rounded-full text-label-md font-semibold transition"
                :class="activeTab === 'tahlil' ? 'bg-brand-teal text-white shadow-sm' : 'bg-surface-low text-ink hover:text-brand-teal'"
            >
                Tahlil Favorit (<span x-text="tahlilList.length"></span>)
            </button>
            <button
                type="button"
                @click="activeTab = 'tahlil_bacaan'"
                class="px-4 py-2 rounded-full text-label-md font-semibold transition"
                :class="activeTab === 'tahlil_bacaan' ? 'bg-brand-teal text-white shadow-sm' : 'bg-surface-low text-ink hover:text-brand-teal'"
            >
                Penanda Tahlil (<span x-text="tahlilBacaanList.length"></span>)
            </button>
            <button
                type="button"
                @click="activeTab = 'doa_category'"
                class="px-4 py-2 rounded-full text-label-md font-semibold transition"
                :class="activeTab === 'doa_category' ? 'bg-brand-teal text-white shadow-sm' : 'bg-surface-low text-ink hover:text-brand-teal'"
            >
                Kategori Doa (<span x-text="doaCategoryList.length"></span>)
            </button>
            <button
                type="button"
                @click="activeTab = 'doa'"
                class="px-4 py-2 rounded-full text-label-md font-semibold transition"
                :class="activeTab === 'doa' ? 'bg-brand-teal text-white shadow-sm' : 'bg-surface-low text-ink hover:text-brand-teal'"
            >
                Penanda Doa (<span x-text="doaList.length"></span>)
            </button>
        </div>

        {{-- State Kosong Jika Belum Ada Penanda / Sesuai Tab yang Dipilih --}}
        <div
            x-show="(activeTab === 'semua' && totalCount() === 0) ||
                    (activeTab === 'surah' && surahList.length === 0) ||
                    (activeTab === 'ayah' && ayahList.length === 0) ||
                    (activeTab === 'tahlil' && tahlilList.length === 0) ||
                    (activeTab === 'tahlil_bacaan' && tahlilBacaanList.length === 0) ||
                    (activeTab === 'doa_category' && doaCategoryList.length === 0) ||
                    (activeTab === 'doa' && doaList.length === 0)"
            style="display: none;"
            class="text-center py-16 px-4 rounded-card bg-surface-card border border-line shadow-card space-y-4"
        >
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-brand-gold/10 text-brand-gold">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                </svg>
            </div>
            <h2
                class="text-title-lg font-bold text-ink"
                x-text="
                    activeTab === 'ayah' ? 'Belum Ada Penanda Ayat' :
                    (activeTab === 'surah' ? 'Belum Ada Surah Favorit' :
                    (activeTab === 'tahlil' ? 'Belum Ada Tahlil Favorit' :
                    (activeTab === 'tahlil_bacaan' ? 'Belum Ada Penanda Bacaan Tahlil' :
                    (activeTab === 'doa_category' ? 'Belum Ada Kategori Doa Favorit' :
                    (activeTab === 'doa' ? 'Belum Ada Penanda Doa' : 'Belum Ada Penanda atau Favorit')))))
                "
            >
                Belum Ada Penanda atau Favorit
            </h2>
            <p
                class="text-body-md text-ink-muted max-w-md mx-auto"
                x-text="
                    activeTab === 'ayah' ? 'Tandai ayat favorit dengan ikon bookmark saat membaca Al-Qur\'an untuk memudahkan tilawah Anda.' :
                    (activeTab === 'surah' ? 'Simpan surah favorit dengan ikon bintang pada daftar surah untuk akses cepat.' :
                    (activeTab === 'tahlil' ? 'Simpan susunan bacaan tahlil favorit dengan ikon bintang pada daftar tahlil.' :
                    (activeTab === 'tahlil_bacaan' ? 'Tandai bacaan tahlil yang sedang Anda amalkan dengan ikon bookmark.' :
                    (activeTab === 'doa_category' ? 'Simpan kumpulan kategori doa favorit Anda dengan ikon bintang.' :
                    (activeTab === 'doa' ? 'Tandai doa harian favorit Anda dengan ikon bookmark pada halaman doa.' :
                    'Tandai ayat, tahlil, atau doa dengan ikon bookmark atau simpan ke favorit dengan ikon bintang.')))))
                "
            >
                Tandai ayat favorit dengan ikon bookmark atau simpan surah dengan ikon bintang saat membaca Al-Qur'an.
            </p>
            <div class="pt-2">
                <template x-if="activeTab === 'tahlil' || activeTab === 'tahlil_bacaan'">
                    <a
                        href="{{ route('tahlil.index') }}"
                        wire:navigate
                        class="inline-flex items-center justify-center gap-2 min-h-[44px] px-6 py-2.5 rounded-full bg-brand-gold text-brand-navy font-bold hover:bg-brand-gold-hover shadow-sm transition"
                    >
                        <span>Mulai Jelajahi Tahlil</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </template>
                <template x-if="activeTab === 'doa_category' || activeTab === 'doa'">
                    <a
                        href="{{ route('doa.index') }}"
                        wire:navigate
                        class="inline-flex items-center justify-center gap-2 min-h-[44px] px-6 py-2.5 rounded-full bg-brand-gold text-brand-navy font-bold hover:bg-brand-gold-hover shadow-sm transition"
                    >
                        <span>Mulai Jelajahi Doa</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </template>
                <template x-if="activeTab !== 'tahlil' && activeTab !== 'tahlil_bacaan' && activeTab !== 'doa_category' && activeTab !== 'doa'">
                    <a
                        href="{{ route('quran.index') }}"
                        wire:navigate
                        class="inline-flex items-center justify-center gap-2 min-h-[44px] px-6 py-2.5 rounded-full bg-brand-gold text-brand-navy font-bold hover:bg-brand-gold-hover shadow-sm transition"
                    >
                        <span>Mulai Jelajahi Al-Qur'an</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </template>
            </div>
        </div>

        {{-- Seksi 1: Surah Favorit --}}
        <div
            x-show="(activeTab === 'semua' || activeTab === 'surah') && surahList.length > 0"
            class="space-y-4"
        >
            <div class="flex items-center gap-2">
                <h2 class="text-title-lg font-bold text-ink">Surah Favorit</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($surahBookmarks as $b)
                    @php $s = $b->bookmarkable; @endphp
                    @if ($s)
                        <div
                            id="surah-bookmark-{{ $s->id }}"
                            class="rounded-card p-5 bg-surface-card border border-line hover:border-brand-gold shadow-card transition flex items-center justify-between gap-4"
                        >
                            <a href="{{ route('quran.show', $s->id) }}" wire:navigate class="flex items-center gap-3.5 min-w-0 flex-1">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-body-sm font-bold shrink-0 bg-surface-low text-ink border border-line/60">
                                    {{ $s->id }}
                                </span>
                                <div class="min-w-0">
                                    <p class="text-title-md font-semibold truncate text-ink">
                                        {{ $s->nama_latin }}
                                    </p>
                                    <p class="text-label-sm truncate mt-0.5 text-ink-muted">
                                        {{ $s->arti }} &middot; {{ $s->jumlah_ayat }} Ayat
                                    </p>
                                </div>
                            </a>

                            <div class="flex items-center gap-2 shrink-0">
                                <p class="font-arabic text-xl leading-normal text-ink" dir="rtl" lang="ar">
                                    {{ $s->nama_arab }}
                                </p>
                                <button
                                    type="button"
                                    @click="removeBookmark('surah', {{ $s->id }}, 'surah-bookmark-{{ $s->id }}')"
                                    title="Hapus dari favorit"
                                    aria-label="Hapus {{ $s->nama_latin }} dari favorit"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-brand-gold hover:text-red-500 hover:bg-surface-low transition ml-1"
                                >
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Seksi 2: Penanda Ayat --}}
        <div
            x-show="(activeTab === 'semua' || activeTab === 'ayah') && ayahList.length > 0"
            class="space-y-4"
        >
            <div class="flex items-center gap-2">
                <h2 class="text-title-lg font-bold text-ink">Penanda Ayat Tersimpan</h2>
            </div>

            <div class="space-y-4">
                @foreach ($ayahBookmarks as $b)
                    @php
                        $ayah = $b->bookmarkable;
                        $surah = $ayah?->surah;
                    @endphp
                    @if ($ayah && $surah)
                        <article
                            id="ayah-bookmark-{{ $ayah->id }}"
                            class="rounded-card p-5 sm:p-6 bg-surface-card border border-line hover:border-brand-gold shadow-card transition space-y-4"
                        >
                            <div class="flex items-center justify-between gap-3 pb-3 border-b border-line/60">
                                <div class="flex items-center gap-2.5">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-brand-navy text-brand-gold text-label-md font-bold">
                                        QS. {{ $surah->nama_latin }}: {{ $ayah->nomor_ayat }}
                                    </span>
                                    <span class="text-label-sm text-ink-muted">
                                        Juz {{ $ayah->juz }}{{ $ayah->halaman ? ' · Hal. ' . $ayah->halaman : '' }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <a
                                        href="{{ route('quran.show', ['surah' => $surah->id, 'ayat' => $ayah->nomor_ayat]) }}"
                                        wire:navigate
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-label-sm font-semibold bg-brand-teal/10 text-brand-teal hover:bg-brand-teal hover:text-white transition"
                                    >
                                        <span>Buka di Mushaf</span>
                                        <span aria-hidden="true">&rarr;</span>
                                    </a>

                                    <button
                                        type="button"
                                        @click="removeBookmark('ayah', {{ $ayah->id }}, 'ayah-bookmark-{{ $ayah->id }}')"
                                        title="Hapus penanda ini"
                                        aria-label="Hapus penanda QS. {{ $surah->nama_latin }}: {{ $ayah->nomor_ayat }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full text-ink-muted hover:text-red-500 hover:bg-surface-low transition"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <p class="quran-arabic text-ink text-right text-xl sm:text-2xl leading-[2.2]" dir="rtl" lang="ar">
                                {{ $ayah->teks_arab }}
                            </p>

                            <p class="text-body-sm text-ink leading-relaxed">
                                {{ $ayah->terjemahan }}
                            </p>
                        </article>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Seksi 3: Tahlil Favorit --}}
        <div
            x-show="(activeTab === 'semua' || activeTab === 'tahlil') && tahlilList.length > 0"
            class="space-y-4"
        >
            <div class="flex items-center gap-2">
                <h2 class="text-title-lg font-bold text-ink">Tahlil Favorit</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($tahlilBookmarks as $b)
                    @php $item = $b->bookmarkable; @endphp
                    @if ($item)
                        <div
                            id="tahlil-bookmark-{{ $item->id }}"
                            class="rounded-card p-5 bg-surface-card border border-line hover:border-brand-gold shadow-card transition flex items-center justify-between gap-4"
                        >
                            <a href="{{ route('tahlil.show', $item->urutan) }}" wire:navigate class="flex items-center gap-3.5 min-w-0 flex-1">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-body-sm font-bold shrink-0 bg-surface-low text-ink border border-line/60">
                                    {{ $item->urutan }}
                                </span>
                                <div class="min-w-0">
                                    <p class="text-title-md font-semibold truncate text-ink">
                                        {{ $item->judul }}
                                    </p>
                                    <p class="text-label-sm truncate mt-0.5 text-ink-muted">
                                        Dibaca {{ $item->jumlah_baca }}x &middot; {{ $item->keterangan ?? 'Bacaan Tahlil' }}
                                    </p>
                                </div>
                            </a>

                            <div class="flex items-center gap-2 shrink-0">
                                <button
                                    type="button"
                                    @click="removeBookmark('tahlil', {{ $item->id }}, 'tahlil-bookmark-{{ $item->id }}')"
                                    title="Hapus dari favorit"
                                    aria-label="Hapus {{ $item->judul }} dari favorit"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-brand-gold hover:text-red-500 hover:bg-surface-low transition ml-1"
                                >
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Seksi 4: Penanda Bacaan Tahlil --}}
        <div
            x-show="(activeTab === 'semua' || activeTab === 'tahlil_bacaan') && tahlilBacaanList.length > 0"
            class="space-y-4"
        >
            <div class="flex items-center gap-2">
                <h2 class="text-title-lg font-bold text-ink">Penanda Bacaan Tahlil</h2>
            </div>

            <div class="space-y-4">
                @foreach ($tahlilBacaanBookmarks as $b)
                    @php $item = $b->bookmarkable; @endphp
                    @if ($item)
                        <article
                            id="tahlil-bacaan-bookmark-{{ $item->id }}"
                            class="rounded-card p-5 sm:p-6 bg-surface-card border border-line hover:border-brand-gold shadow-card transition space-y-4"
                        >
                            <div class="flex items-center justify-between gap-3 pb-3 border-b border-line/60">
                                <div class="flex items-center gap-2.5">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-brand-navy text-brand-gold text-label-md font-bold">
                                        Urutan {{ $item->urutan }}
                                    </span>
                                    <span class="text-title-sm font-semibold text-ink">
                                        {{ $item->judul }}
                                    </span>
                                    <span class="text-label-sm text-ink-muted">
                                        &middot; Dibaca {{ $item->jumlah_baca }}x
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <a
                                        href="{{ route('tahlil.show', $item->urutan) }}"
                                        wire:navigate
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-label-sm font-semibold bg-brand-teal/10 text-brand-teal hover:bg-brand-teal hover:text-white transition"
                                    >
                                        <span>Buka Bacaan</span>
                                        <span aria-hidden="true">&rarr;</span>
                                    </a>

                                    <button
                                        type="button"
                                        @click="removeBookmark('tahlil_bacaan', {{ $item->id }}, 'tahlil-bacaan-bookmark-{{ $item->id }}')"
                                        title="Hapus penanda ini"
                                        aria-label="Hapus penanda {{ $item->judul }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full text-ink-muted hover:text-red-500 hover:bg-surface-low transition"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <p class="quran-arabic text-ink text-right text-xl sm:text-2xl leading-[2.2]" dir="rtl" lang="ar">
                                {{ $item->teks_arab }}
                            </p>

                            @if ($item->terjemahan)
                                <p class="text-body-sm text-ink leading-relaxed">
                                    {{ $item->terjemahan }}
                                </p>
                            @endif
                        </article>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Seksi 5: Kategori Doa Favorit --}}
        <div
            x-show="(activeTab === 'semua' || activeTab === 'doa_category') && doaCategoryList.length > 0"
            class="space-y-4"
        >
            <div class="flex items-center gap-2">
                <h2 class="text-title-lg font-bold text-ink">Kategori Doa Favorit</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($doaCategoryBookmarks as $b)
                    @php $cat = $b->bookmarkable; @endphp
                    @if ($cat)
                        <div
                            id="doa-category-bookmark-{{ $cat->id }}"
                            class="rounded-card p-5 bg-surface-card border border-line hover:border-brand-gold shadow-card transition flex items-center justify-between gap-4"
                        >
                            <a href="{{ route('doa.show', $cat->slug) }}" wire:navigate class="flex items-center gap-3.5 min-w-0 flex-1">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-body-sm font-bold shrink-0 bg-surface-low text-ink border border-line/60">
                                    {{ $cat->urutan }}
                                </span>
                                <div class="min-w-0">
                                    <p class="text-title-md font-semibold truncate text-ink">
                                        {{ $cat->nama }}
                                    </p>
                                    <p class="text-label-sm truncate mt-0.5 text-ink-muted">
                                        {{ $cat->doas_count ?? $cat->doas->count() }} Doa Pilihan &middot; Shahih
                                    </p>
                                </div>
                            </a>

                            <div class="flex items-center gap-2 shrink-0">
                                <button
                                    type="button"
                                    @click="removeBookmark('doa_category', {{ $cat->id }}, 'doa-category-bookmark-{{ $cat->id }}')"
                                    title="Hapus dari favorit"
                                    aria-label="Hapus {{ $cat->nama }} dari favorit"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-brand-gold hover:text-red-500 hover:bg-surface-low transition ml-1"
                                >
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Seksi 6: Penanda Doa Tersimpan --}}
        <div
            x-show="(activeTab === 'semua' || activeTab === 'doa') && doaList.length > 0"
            class="space-y-4"
        >
            <div class="flex items-center gap-2">
                <h2 class="text-title-lg font-bold text-ink">Penanda Doa Tersimpan</h2>
            </div>

            <div class="space-y-4">
                @foreach ($doaBookmarks as $b)
                    @php
                        $doa = $b->bookmarkable;
                        $cat = $doa?->doaCategory;
                    @endphp
                    @if ($doa && $cat)
                        <article
                            id="doa-bookmark-{{ $doa->id }}"
                            class="rounded-card p-5 sm:p-6 bg-surface-card border border-line hover:border-brand-gold shadow-card transition space-y-4"
                        >
                            <div class="flex items-center justify-between gap-3 pb-3 border-b border-line/60">
                                <div class="flex items-center gap-2.5">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-brand-navy text-brand-gold text-label-md font-bold">
                                        {{ $cat->nama }}
                                    </span>
                                    <span class="text-title-sm font-semibold text-ink">
                                        {{ $doa->judul }}
                                    </span>
                                    @if ($doa->sumber)
                                        <span class="text-label-sm text-ink-muted">
                                            &middot; {{ $doa->sumber }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <a
                                        href="{{ route('doa.show', [$cat->slug, 'doa' => $doa->slug]) }}"
                                        wire:navigate
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-label-sm font-semibold bg-brand-teal/10 text-brand-teal hover:bg-brand-teal hover:text-white transition"
                                    >
                                        <span>Buka Doa</span>
                                        <span aria-hidden="true">&rarr;</span>
                                    </a>

                                    <button
                                        type="button"
                                        @click="removeBookmark('doa', {{ $doa->id }}, 'doa-bookmark-{{ $doa->id }}')"
                                        title="Hapus penanda ini"
                                        aria-label="Hapus penanda {{ $doa->judul }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full text-ink-muted hover:text-red-500 hover:bg-surface-low transition"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <p class="quran-arabic text-ink text-right text-xl sm:text-2xl leading-[2.2]" dir="rtl" lang="ar">
                                {{ $doa->teks_arab }}
                            </p>

                            @if ($doa->terjemahan)
                                <p class="text-body-sm text-ink leading-relaxed">
                                    {{ $doa->terjemahan }}
                                </p>
                            @endif
                        </article>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
