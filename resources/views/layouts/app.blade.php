<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Lentera Quran - Al-Qur\'an Digital & Doa' }}</title>
    <meta name="description" content="{{ $description ?? 'Lentera Quran - Aplikasi web Al-Qur\'an digital berbahasa Indonesia lengkap dengan murotal per ayat, tahlil, dan doa sehari-hari.' }}">
    <meta property="og:title" content="{{ $title ?? 'Lentera Quran' }}">
    <meta property="og:description" content="{{ $description ?? 'Membaca 114 surah dengan teks Arab, latin, dan terjemahan Indonesia serta audio murotal.' }}">
    <meta property="og:type" content="website">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        .font-arabic {
            font-family: 'Amiri', serif;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-full bg-slate-50 text-slate-800 antialiased flex flex-col">
    @include('layouts.navigation')

    <main class="flex-grow">
        {{ $slot }}
    </main>

    @persist('murotal-player')
    <div x-data="{
            audioUrl: '',
            surahTitle: '',
            isPlaying: false,
            init() {
                window.addEventListener('play-audio', (e) => {
                    this.audioUrl = e.detail.url;
                    this.surahTitle = e.detail.title || 'Murotal';
                    this.$nextTick(() => {
                        const audio = this.$refs.audioPlayer;
                        if (audio) {
                            audio.src = this.audioUrl;
                            audio.play();
                            this.isPlaying = true;
                        }
                    });
                });
            },
            togglePlay() {
                const audio = this.$refs.audioPlayer;
                if (!audio) return;
                if (this.isPlaying) {
                    audio.pause();
                    this.isPlaying = false;
                } else {
                    audio.play();
                    this.isPlaying = true;
                }
            }
         }"
         x-show="audioUrl"
         x-transition
         class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur border-t border-emerald-200 p-3 shadow-lg z-40 flex items-center justify-between max-w-4xl mx-auto rounded-t-xl">
        <div class="flex items-center gap-3">
            <button @click="togglePlay" class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shadow hover:bg-emerald-700">
                <span x-text="isPlaying ? '⏸' : '▶'"></span>
            </button>
            <div>
                <p class="text-xs text-slate-500 font-medium">Sedang Memutar</p>
                <p class="text-sm font-semibold text-slate-800" x-text="surahTitle"></p>
            </div>
        </div>
        <audio x-ref="audioPlayer" preload="none" @ended="isPlaying = false" @pause="isPlaying = false" @play="isPlaying = true"></audio>
    </div>
    @endpersist

    <footer class="bg-white border-t border-slate-200 mt-12 py-6 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            <p class="font-medium text-slate-700">Lentera Quran © {{ date('Y') }}</p>
            <p class="text-xs mt-1">Sumber Data: EQuran.id API & Kemenag RI | Riwayat Hafs 'an 'Ashim</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
