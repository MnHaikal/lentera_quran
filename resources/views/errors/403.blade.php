<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>403 — Akses Ditolak | {{ config('app.name', 'Lentera Quran') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo-icon-lentera-quran.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-canvas text-ink min-h-screen flex flex-col justify-between selection:bg-brand-gold/20 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/35 via-canvas to-canvas">
        {{-- Header Ringan --}}
        <header class="w-full max-w-browse mx-auto px-gutter-mobile md:px-gutter py-6 flex items-center justify-between">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                <img src="{{ asset('images/logo-lentera-quran.png') }}" alt="Lentera Quran" class="h-9 w-auto">
            </a>
            <a
                href="{{ url('/') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition shadow-xs"
            >
                <svg class="w-4 h-4 text-ink-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Beranda</span>
            </a>
        </header>

        {{-- Konten Utama 403 --}}
        <main class="flex-1 flex items-center justify-center px-gutter-mobile py-8 md:py-12">
            <div class="max-w-xl w-full text-center space-y-4 md:space-y-6">
                {{-- Desain Angka Besar --}}
                <div class="relative flex items-center justify-center select-none -mb-4 sm:-mb-6 md:-mb-8">
                    <span class="text-[120px] sm:text-[170px] md:text-[210px] lg:text-[240px] font-black text-[#E2DACD] leading-none tracking-tight">
                        403
                    </span>
                </div>

                <div class="space-y-3 relative z-10">
                    <h1 class="text-headline-md sm:text-headline-lg md:text-display-sm font-extrabold text-brand-navy tracking-tight">
                        Akses Tidak Diizinkan
                    </h1>
                    <p class="text-body-sm sm:text-body-md text-ink-muted leading-relaxed max-w-md mx-auto">
                        Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Halaman ini mungkin dikhususkan untuk administrator atau memerlukan hak akses tertentu.
                    </p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 pt-2 relative z-10">
                    <a
                        href="{{ url('/') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 min-h-[46px] px-6 py-2.5 rounded-full bg-brand-gold hover:bg-[#a67a28] text-white text-body-sm font-semibold shadow-sm transition"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                    <a
                        href="{{ url('/al-quran') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 min-h-[46px] px-6 py-2.5 rounded-full bg-surface-card border border-brand-navy/30 hover:border-brand-navy text-brand-navy text-body-sm font-semibold transition shadow-xs"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Buka Daftar Surah</span>
                    </a>
                </div>
            </div>
        </main>

        {{-- Footer Ringan --}}
        <footer class="py-6 text-center text-label-sm text-ink-muted border-t border-line/60">
            &copy; {{ date('Y') }} Lentera Quran. Hak Cipta Dilindungi.
        </footer>
    </body>
</html>
