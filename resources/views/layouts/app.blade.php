<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $description ?? 'Lentera Quran — Aplikasi Al-Qur\'an digital berbahasa Indonesia dengan terjemahan Kemenag RI, bacaan tahlil, dan doa harian.' }}">
        <meta property="og:title" content="{{ $title ? $title . ' — ' . config('app.name', 'Lentera Quran') : config('app.name', 'Lentera Quran') }}">
        <meta property="og:description" content="{{ $description ?? 'Lentera Quran — Aplikasi Al-Qur\'an digital berbahasa Indonesia dengan terjemahan Kemenag RI, bacaan tahlil, dan doa harian.' }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">

        <title>{{ $title ? $title . ' — ' . config('app.name', 'Lentera Quran') : config('app.name', 'Lentera Quran') }}</title>

        {{-- Favicon --}}
        <link rel="icon" type="image/png" href="{{ asset('images/logo-icon-lentera-quran.png') }}">
        <link rel="shortcut icon" href="{{ asset('images/logo-icon-lentera-quran.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logo-icon-lentera-quran.png') }}">

        <script>
            document.documentElement.classList.remove('dark');
            try { localStorage.removeItem('lq_theme'); } catch (e) {}
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-canvas text-ink min-h-screen flex flex-col">
        <div class="min-h-screen flex flex-col">
            <x-navbar />

            @php
                $flashSuccess = session('success') ?? (
                    (!request()->routeIs('login', 'password.*', 'verification.*') && session('status') && !in_array(session('status'), ['verification-link-sent', 'password-updated'], true))
                        ? session('status')
                        : null
                );
            @endphp

            @if ($flashSuccess)
                <div class="fixed top-24 inset-x-0 z-50 flex justify-center px-4 pointer-events-none">
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-init="setTimeout(() => show = false, 6000)"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
                        class="pointer-events-auto max-w-lg w-full p-4 rounded-2xl bg-[#0d4f57] text-white shadow-2xl flex items-center justify-between gap-3 border border-teal-400/30"
                    >
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-brand-gold/20 text-brand-gold shrink-0">
                                <svg class="w-5 h-5 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <p class="text-body-sm font-semibold leading-snug">{{ $flashSuccess }}</p>
                        </div>
                        <button @click="show = false" aria-label="Tutup notifikasi" class="text-white/70 hover:text-white p-1.5 rounded-lg transition shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <main id="main-content" class="flex-1">
                {{ $slot }}
            </main>

            @unless (request()->routeIs('login', 'register', 'register.otp.*', 'password.*'))
                <x-footer />
            @endunless
        </div>

        @persist('audio-player')
            <x-audio-player />
        @endpersist

        @livewireScripts
    </body>
</html>
