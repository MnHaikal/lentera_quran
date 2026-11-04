<x-app-layout
    title="Kumpulan Doa"
    description="Kumpulan doa harian, doa shalat, doa perjalanan, doa menuntut ilmu, doa keluarga, dan dzikir mustajab bersumber dari Al-Qur'an dan As-Sunnah Ash-Shahihah."
>
    <div
        x-data="{
            favoritedCategories: @js($favoritedCategoryIds),
            async toggleFavoriteCategory(categoryId) {
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
                        body: JSON.stringify({ type: 'doa_category', id: categoryId })
                    });

                    if (response.status === 401) {
                        window.location.href = '{{ route('login') }}';
                        return;
                    }

                    const data = await response.json();
                    if (data.bookmarked) {
                        if (!this.favoritedCategories.includes(categoryId)) {
                            this.favoritedCategories.push(categoryId);
                        }
                    } else {
                        this.favoritedCategories = this.favoritedCategories.filter(id => id !== categoryId);
                    }
                } catch (e) {
                    console.error(e);
                }
            }
        }"
        class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-10 md:py-12 space-y-8"
    >
        {{-- Header & Search Bar --}}
        <header class="text-center max-w-3xl mx-auto space-y-4">
            <h1 class="text-display-mobile md:text-[42px] md:leading-[50px] font-bold text-brand-navy dark:text-ink tracking-tight">
                Kumpulan Doa &amp; Dzikir Mustajab
            </h1>
            <p class="text-body-md text-ink-muted max-w-2xl mx-auto leading-relaxed">
                Kumpulan doa shalat, doa perjalanan, doa menuntut ilmu, doa harian, dan dzikir perlindungan bersumber dari Al-Qur'an dan As-Sunnah Ash-Shahihah.
            </p>

            <div class="pt-3">
                <form action="{{ route('doa.index') }}" method="GET" class="max-w-2xl mx-auto">
                    @if ($sort !== 'urutan')
                        <input type="hidden" name="sort" value="{{ $sort }}">
                    @endif

                    <div class="relative flex items-center rounded-full bg-surface-card border border-line shadow-card p-1.5 pl-5 focus-within:border-brand-teal focus-within:shadow-teal-ring transition">
                        <svg class="w-5 h-5 text-brand-teal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <input
                            type="search"
                            name="q"
                            value="{{ $search }}"
                            placeholder="Cari kategori atau nama doa (misal: shalat, tahajud, tarawih, perjalanan, ilmu)..."
                            aria-label="Cari doa"
                            class="w-full bg-transparent border-0 text-body-md text-ink placeholder-ink-muted focus:ring-0 px-3 py-2"
                        >
                        @if ($search !== '')
                            <a
                                href="{{ route('doa.index', $sort !== 'urutan' ? ['sort' => $sort] : []) }}"
                                wire:navigate
                                aria-label="Hapus pencarian"
                                class="p-2 text-ink-muted hover:text-ink transition"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                        <button
                            type="submit"
                            class="px-6 py-2.5 rounded-full bg-brand-teal hover:bg-brand-navy text-white text-body-sm font-semibold transition shrink-0"
                        >
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </header>

        {{-- Baris Info Jumlah & Pengurutan --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-2 border-b border-line/70 pb-4">
            <div class="flex flex-wrap items-center gap-3">
                <h2 class="text-headline-sm font-bold text-brand-navy dark:text-ink">
                    Daftar Kategori Doa Pilihan
                </h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-surface-low border border-line text-label-sm font-semibold text-ink-muted">
                    {{ $categories->total() }} Kategori &middot; {{ $totalDoaCount }} Doa
                </span>
                @if ($search !== '')
                    <span class="text-body-sm text-ink-muted">
                        untuk kata kunci <strong class="text-ink">"{{ $search }}"</strong>
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-2 self-start sm:self-auto">
                <label for="doa-sort" class="text-body-sm text-ink-muted whitespace-nowrap">Urutkan:</label>
                <div class="relative inline-flex items-center">
                    <select
                        id="doa-sort"
                        onchange="window.location.href = this.value"
                        class="bg-transparent border-0 py-1 pl-1 pr-7 text-body-sm font-semibold text-ink focus:ring-0 cursor-pointer"
                    >
                        <option value="{{ route('doa.index', array_filter(['q' => $search, 'sort' => 'urutan'])) }}" @selected($sort === 'urutan')>
                            Rekomendasi Utama
                        </option>
                        <option value="{{ route('doa.index', array_filter(['q' => $search, 'sort' => 'nama'])) }}" @selected($sort === 'nama')>
                            Nama Kategori (A–Z)
                        </option>
                        <option value="{{ route('doa.index', array_filter(['q' => $search, 'sort' => 'jumlah-doa'])) }}" @selected($sort === 'jumlah-doa')>
                            Jumlah Doa Terbanyak
                        </option>
                    </select>
                </div>
                <svg class="w-4 h-4 text-ink-muted shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                </svg>
            </div>
        </div>

        {{-- Grid 4 Kolom Kartu Kategori Doa --}}
        <section aria-label="Daftar Kategori Doa" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse ($categories as $category)
                @php
                    $sampleDoa = $category->doas->first();
                    $doaTitlesPreview = $category->doas->pluck('judul')->take(3)->implode(', ');
                @endphp

                <article
                    class="rounded-card p-5 flex flex-col justify-between transition duration-150 group bg-surface-card border border-line shadow-card hover:border-brand-gold/70"
                >
                    {{-- Baris Pill Atas & Ikon Bintang Favorit --}}
                    <div class="flex items-center justify-between gap-2 mb-3.5">
                        <div class="flex flex-wrap items-center gap-1.5">
                            <span class="px-2.5 py-0.5 rounded-full bg-brand-teal/15 text-brand-teal text-label-sm font-semibold">
                                {{ $category->doas_count }} Doa Pilihan
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-label-sm font-semibold bg-surface-low text-ink-muted">
                                Shahih
                            </span>
                        </div>

                        @guest
                            <a
                                href="{{ route('login') }}"
                                wire:navigate
                                title="Masuk untuk menambahkan ke kategori favorit"
                                aria-label="Masuk untuk menambahkan {{ $category->nama }} ke kategori favorit"
                                class="inline-flex items-center justify-center w-7 h-7 rounded-full text-ink-muted hover:text-brand-gold transition shrink-0"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            </a>
                        @else
                            <button
                                type="button"
                                @click="toggleFavoriteCategory({{ $category->id }})"
                                :title="favoritedCategories.includes({{ $category->id }}) ? 'Hapus dari favorit' : 'Tambah ke kategori favorit'"
                                :aria-label="favoritedCategories.includes({{ $category->id }}) ? 'Hapus {{ $category->nama }} dari favorit' : 'Tambah {{ $category->nama }} ke kategori favorit'"
                                class="inline-flex items-center justify-center w-7 h-7 rounded-full transition shrink-0"
                                :class="favoritedCategories.includes({{ $category->id }}) ? 'text-brand-gold' : 'text-ink-muted hover:text-brand-gold'"
                            >
                                <svg
                                    class="w-4 h-4"
                                    :class="favoritedCategories.includes({{ $category->id }}) ? 'fill-current text-brand-gold' : 'fill-none'"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            </button>
                        @endguest
                    </div>

                    <a
                        href="{{ route('doa.show', $category->slug) }}"
                        wire:navigate
                        class="block flex-1 focus:outline-none"
                    >
                        {{-- Judul Kategori & Subjudul Sumber --}}
                        <h3 class="text-title-md font-bold text-brand-navy dark:text-ink leading-snug line-clamp-2 min-h-[48px] group-hover:text-brand-teal transition">
                            {{ $category->nama }}
                        </h3>
                        <p class="text-label-sm text-ink-muted mt-1 truncate">
                            {{ $sampleDoa?->sumber ?? "Al-Qur'an & Hadits Shahih" }}
                        </p>

                        {{-- Kotak Cuplikan Teks Arab Doa Utama --}}
                        <div class="rounded-xl bg-surface-low/90 dark:bg-surface-low p-4 my-3.5 min-h-[112px] flex items-center justify-end">
                            <p class="font-arabic text-2xl leading-[1.95] text-right text-brand-navy dark:text-ink line-clamp-2 w-full" dir="rtl" lang="ar">
                                {{ \Illuminate\Support\Str::limit($sampleDoa?->teks_arab ?? 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', 70, '...') }}
                            </p>
                        </div>

                        {{-- Daftar Isi Doa di Dalam Kategori --}}
                        <p class="text-body-sm text-ink-muted leading-relaxed line-clamp-2 mb-4">
                            Memuat: {{ $doaTitlesPreview }}{{ $category->doas_count > 3 ? ', dan lainnya.' : '.' }}
                        </p>
                    </a>

                    {{-- Footer Kartu --}}
                    <div class="pt-3.5 border-t border-line/70 flex items-center justify-between gap-2 mt-auto">
                        <div class="inline-flex items-center gap-1.5 text-label-sm text-ink-muted min-w-0 truncate">
                            <svg class="w-4 h-4 text-brand-teal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="truncate">{{ $category->doas_count }} Bacaan Doa</span>
                        </div>

                        <a
                            href="{{ route('doa.show', $category->slug) }}"
                            wire:navigate
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-label-sm font-semibold transition shrink-0 bg-surface-low hover:bg-brand-gold-pale text-brand-navy dark:text-ink dark:hover:text-brand-navy"
                        >
                            <span>Buka Doa</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full lq-card text-center py-12 space-y-3">
                    <p class="text-headline-sm text-ink">Kategori atau Doa tidak ditemukan</p>
                    <p class="text-body-sm text-ink-muted">Tidak ada doa yang cocok dengan kata kunci pencarian Anda.</p>
                    <a href="{{ route('doa.index') }}" wire:navigate class="lq-btn-outline text-body-sm mt-2">
                        Tampilkan Semua Kategori Doa
                    </a>
                </div>
            @endforelse
        </section>

        {{-- Baris Paginasi Real (Desain Sama dengan Halaman Al-Qur'an & Tahlil) --}}
        @if ($categories->lastPage() > 1)
            <nav aria-label="Navigasi Halaman Kategori Doa" class="lq-card py-4 px-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-body-sm text-ink-muted">
                    Menampilkan Halaman <strong class="font-semibold text-ink">{{ $categories->currentPage() }}</strong> dari <strong class="font-semibold text-ink">{{ $categories->lastPage() }}</strong> (Total {{ $categories->total() }} Kategori Doa)
                </p>

                <div class="flex flex-wrap items-center gap-1.5">
                    @if ($categories->onFirstPage())
                        <span class="inline-flex items-center gap-1 min-h-[36px] px-4 py-1.5 rounded-full border border-line/60 text-body-sm text-ink-muted/60 cursor-not-allowed">
                            <span aria-hidden="true">&lsaquo;</span>
                            <span>Sebelumnya</span>
                        </span>
                    @else
                        <a
                            href="{{ $categories->previousPageUrl() }}"
                            wire:navigate
                            class="inline-flex items-center gap-1 min-h-[36px] px-4 py-1.5 rounded-full border border-line bg-surface-card text-body-sm font-semibold text-ink hover:border-brand-teal transition"
                        >
                            <span aria-hidden="true">&lsaquo;</span>
                            <span>Sebelumnya</span>
                        </a>
                    @endif

                    @for ($page = 1; $page <= $categories->lastPage(); $page++)
                        @if ($page === $categories->currentPage())
                            <span aria-current="page" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#B9892E] text-white text-body-sm font-bold">
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $categories->url($page) }}"
                                wire:navigate
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-ink hover:bg-surface-low text-body-sm font-semibold transition"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    @if ($categories->hasMorePages())
                        <a
                            href="{{ $categories->nextPageUrl() }}"
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
