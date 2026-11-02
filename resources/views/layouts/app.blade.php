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

        <script>
            (function () {
                try {
                    var stored = localStorage.getItem('lq_theme') || 'sistem';
                    var isDark = stored === 'gelap' || (stored === 'sistem' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                    document.documentElement.classList.toggle('dark', isDark);
                    document.documentElement.dataset.themePreference = stored;
                } catch (e) {}
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-canvas text-ink min-h-screen flex flex-col">
        <div class="min-h-screen flex flex-col">
            <x-navbar />

            <main id="main-content" class="flex-1">
                {{ $slot }}
            </main>

            @unless (request()->routeIs('login', 'register', 'password.*'))
                <x-footer />
            @endunless
        </div>

        @persist('audio-player')
            <x-audio-player />
        @endpersist

        @livewireScripts
    </body>
</html>
