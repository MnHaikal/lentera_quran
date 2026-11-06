<div
    id="lentera-audio-player-bar"
    x-data
    x-init="$store.audioPlayer?.initAudio?.()"
    x-show="$store.audioPlayer && $store.audioPlayer.hasTrack"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="transform translate-y-full opacity-0"
    x-transition:enter-end="transform translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="transform translate-y-0 opacity-100"
    x-transition:leave-end="transform translate-y-full opacity-0"
    style="display: none;"
    class="fixed bottom-14 md:bottom-0 left-0 right-0 z-50 bg-surface-card border-t border-line shadow-overlay"
    role="region"
    aria-label="Pemutar Murotal Al-Qur'an"
>
    <audio id="lentera-audio-element" preload="none"></audio>

    {{-- Progress bar audio berjalan sesuai pemutaran audio --}}
    <div
        class="h-1 w-full bg-surface-container overflow-hidden cursor-pointer relative group"
        @click="$store.audioPlayer?.seekByEvent($event)"
        title="Klik untuk melompat durasi"
    >
        <div
            class="h-full bg-brand-gold transition-[width] duration-150 ease-linear"
            :style="'width: ' + ($store.audioPlayer ? $store.audioPlayer.progress : 0) + '%'"
        ></div>
    </div>

    <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-2.5 flex items-center justify-between gap-4">
        {{-- Kiri: Informasi Track Audio --}}
        <div class="flex items-center gap-3 min-w-0 flex-1">
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-brand-teal/10 text-brand-teal shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" />
                </svg>
            </span>
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <p class="text-body-sm font-semibold text-ink truncate" x-text="$store.audioPlayer ? $store.audioPlayer.surahName : ''"></p>
                    <span
                        x-show="$store.audioPlayer && $store.audioPlayer.ayahNumber"
                        x-text="$store.audioPlayer && $store.audioPlayer.ayahNumber ? 'Ayat ' + $store.audioPlayer.ayahNumber : ''"
                        class="px-2 py-0.5 rounded text-label-sm bg-brand-navy text-white"
                    ></span>
                </div>
                <p class="text-label-sm text-ink-muted truncate" x-text="$store.audioPlayer ? $store.audioPlayer.qariName : '{{ config('quran.qari_name', 'Misyari Rasyid Al-Afasi') }}'"></p>
            </div>
        </div>

        {{-- Tengah: Kontrol Pemutar (Sebelum, Putar/Jeda, Lanjut) --}}
        <div class="flex items-center justify-center gap-1.5 sm:gap-2.5 shrink-0">
            {{-- Tombol Sebelum (Previous Track / Ayat) --}}
            <button
                type="button"
                @click="$store.audioPlayer.previous()"
                :disabled="!$store.audioPlayer || !$store.audioPlayer.canGoPrevious()"
                :class="(!$store.audioPlayer || !$store.audioPlayer.canGoPrevious())
                    ? 'opacity-30 cursor-not-allowed text-ink-muted'
                    : 'text-ink hover:text-brand-gold hover:bg-surface-low active:scale-95'"
                aria-label="Audio sebelumnya"
                :title="$store.audioPlayer?.ayahNumber ? 'Ayat Sebelumnya' : 'Surah Sebelumnya'"
                class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-full transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-navy shrink-0"
            >
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 5v14M19 5l-9 7 9 7V5z" />
                </svg>
            </button>

            {{-- Tombol Putar / Jeda --}}
            <button
                type="button"
                @click="$store.audioPlayer.toggle()"
                aria-label="Putar atau jeda murotal"
                class="inline-flex items-center justify-center min-h-[44px] min-w-[44px] rounded-full bg-brand-gold text-brand-navy hover:bg-brand-gold-hover shadow-sm transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-navy"
            >
                <svg x-show="!$store.audioPlayer || !$store.audioPlayer.isPlaying" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                </svg>
                <svg x-show="$store.audioPlayer && $store.audioPlayer.isPlaying" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" style="display: none;">
                    <path fill-rule="evenodd" d="M5.5 3.5A1.5 1.5 0 017 5v10a1.5 1.5 0 01-3 0V5a1.5 1.5 0 011.5-1.5zm9 0A1.5 1.5 0 0116 5v10a1.5 1.5 0 01-3 0V5a1.5 1.5 0 011.5-1.5z" clip-rule="evenodd" />
                </svg>
            </button>

            {{-- Tombol Lanjut (Next Track / Ayat) --}}
            <button
                type="button"
                @click="$store.audioPlayer.next()"
                :disabled="!$store.audioPlayer || !$store.audioPlayer.canGoNext()"
                :class="(!$store.audioPlayer || !$store.audioPlayer.canGoNext())
                    ? 'opacity-30 cursor-not-allowed text-ink-muted'
                    : 'text-ink hover:text-brand-gold hover:bg-surface-low active:scale-95'"
                aria-label="Audio berikutnya"
                :title="$store.audioPlayer?.ayahNumber ? 'Ayat Berikutnya' : 'Surah Berikutnya'"
                class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-full transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-navy shrink-0"
            >
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 5v14M5 5l9 7-9 7V5z" />
                </svg>
            </button>
        </div>

        {{-- Kanan: Penunjuk Waktu & Tombol Tutup (Close) --}}
        <div class="flex items-center justify-end gap-2.5 sm:gap-4 flex-1 min-w-0">
            {{-- Waktu Audio --}}
            <div class="inline-flex items-center gap-1 text-label-xs sm:text-label-sm font-mono text-ink-muted whitespace-nowrap bg-surface-low/80 px-2.5 py-1 rounded-md border border-line/60">
                <span class="text-ink font-semibold" x-text="$store.audioPlayer ? $store.audioPlayer.formattedCurrentTime : '00:00'">00:00</span>
                <span class="text-ink-muted/50">/</span>
                <span x-text="$store.audioPlayer ? $store.audioPlayer.formattedDuration : '00:00'">00:00</span>
            </div>

            {{-- Tombol Close --}}
            <button
                type="button"
                @click="$store.audioPlayer.close()"
                aria-label="Tutup pemutar audio"
                title="Tutup pemutar audio"
                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-ink-muted hover:text-ink hover:bg-surface-low border border-transparent hover:border-line transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-navy shrink-0"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    (function() {
        let streamTimer = null;
        let lastPlayedTime = 0;
        let accumulatedSeconds = 0;
        let lastPingedTrackKey = null;

        function getAudioEl() {
            return document.getElementById('lentera-audio-element');
        }

        function sendImmediatePing() {
            const player = window.Alpine?.store?.('audioPlayer');
            if (!player || !player.surahId) return;

            const currentKey = `${player.surahId}_${player.ayahNumber || 'full'}`;
            if (lastPingedTrackKey === currentKey) return;
            lastPingedTrackKey = currentKey;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) return;

            fetch('{{ route("quran.audio-stream-ping") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    surah_id: player.surahId,
                    ayah_number: player.ayahNumber || null,
                    duration_seconds: 1,
                    qari: player.qariName || 'Misyari Rasyid Al-Afasi'
                })
            }).catch(function() {});
        }

        function sendStreamPing() {
            if (accumulatedSeconds < 3) return;
            const player = window.Alpine?.store?.('audioPlayer');
            if (!player || !player.surahId) return;

            const secondsToSend = accumulatedSeconds;
            accumulatedSeconds = 0;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) return;

            fetch('{{ route("quran.audio-stream-ping") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    surah_id: player.surahId,
                    ayah_number: player.ayahNumber || null,
                    duration_seconds: secondsToSend,
                    qari: player.qariName || 'Misyari Rasyid Al-Afasi'
                })
            }).catch(function() {});
        }

        document.addEventListener('DOMContentLoaded', function() {
            const audio = getAudioEl();
            if (!audio) return;

            audio.addEventListener('play', function() {
                lastPlayedTime = audio.currentTime;
                sendImmediatePing();
                if (!streamTimer) {
                    streamTimer = setInterval(function() {
                        if (!audio.paused && !audio.ended) {
                            const now = audio.currentTime;
                            const diff = Math.floor(now - lastPlayedTime);
                            if (diff > 0 && diff < 30) {
                                accumulatedSeconds += diff;
                            }
                            lastPlayedTime = now;
                            if (accumulatedSeconds >= 15) {
                                sendStreamPing();
                            }
                        }
                    }, 5000);
                }
            });

            audio.addEventListener('pause', function() {
                const now = audio.currentTime;
                const diff = Math.floor(now - lastPlayedTime);
                if (diff > 0 && diff < 30) {
                    accumulatedSeconds += diff;
                }
                lastPlayedTime = now;
                sendStreamPing();
            });

            audio.addEventListener('ended', function() {
                sendStreamPing();
            });

            window.addEventListener('beforeunload', function() {
                sendStreamPing();
            });
        });
    })();
</script>
