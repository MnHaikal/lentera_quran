<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>503 — Pemeliharaan Sistem | {{ config('app.name', 'Lentera Quran') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo-icon-lentera-quran.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-canvas text-ink min-h-screen flex flex-col justify-between selection:bg-brand-gold/20 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-100/35 via-canvas to-canvas">
        {{-- Header Ringan --}}
        <header class="w-full max-w-browse mx-auto px-gutter-mobile md:px-gutter py-6 flex items-center justify-center">
            <div class="inline-flex items-center gap-3">
                <img src="{{ asset('images/logo-lentera-quran.png') }}" alt="Lentera Quran" class="h-10 w-auto">
            </div>
        </header>

        {{-- Konten Utama 503 --}}
        <main class="flex-1 flex items-center justify-center px-gutter-mobile py-8 md:py-12">
            <div class="max-w-xl w-full text-center space-y-4 md:space-y-6">
                {{-- Desain Angka Besar --}}
                <div class="relative flex items-center justify-center select-none -mb-4 sm:-mb-6 md:-mb-8">
                    <span class="text-[120px] sm:text-[170px] md:text-[210px] lg:text-[240px] font-black text-[#E2DACD] leading-none tracking-tight">
                        503
                    </span>
                </div>

                <div class="space-y-3 relative z-10">
                    <h1 class="text-headline-md sm:text-headline-lg md:text-display-sm font-extrabold text-brand-navy tracking-tight">
                        Sedang Dalam Pemeliharaan
                    </h1>
                    <p class="text-body-sm sm:text-body-md text-ink-muted leading-relaxed max-w-md mx-auto">
                        Lentera Quran sedang dalam proses pemeliharaan berkala untuk meningkatkan performa dan kenyamanan tilawah Anda. Sistem akan segera kembali beroperasi.
                    </p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="pt-2 relative z-10">
                    <button
                        type="button"
                        onclick="window.location.reload()"
                        class="inline-flex items-center justify-center gap-2 min-h-[46px] px-8 py-2.5 rounded-full bg-brand-gold hover:bg-[#a67a28] text-white text-body-sm font-semibold shadow-sm transition cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <span>Cek Status Sistem</span>
                    </button>
                </div>
            </div>
        </main>

        {{-- Footer Ringan --}}
        <footer class="py-6 text-center text-label-sm text-ink-muted border-t border-line/60">
            &copy; {{ date('Y') }} Lentera Quran. Hak Cipta Dilindungi.
        </footer>
    </body>
</html>
