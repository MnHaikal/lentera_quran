<div
    id="lentera-audio-player-bar"
    x-data
    x-show="$store.audioPlayer && $store.audioPlayer.hasTrack"
    style="display: none;"
    class="fixed bottom-14 md:bottom-0 left-0 right-0 z-50 bg-surface-card border-t border-line shadow-overlay"
    role="region"
    aria-label="Pemutar Murotal Al-Qur'an"
>
    <audio id="lentera-audio-element" preload="none"></audio>

    <div class="h-0.5 w-full bg-surface-container">
        <div class="h-full w-1/3 bg-brand-gold"></div>
    </div>

    <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-2.5 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 min-w-0">
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

        <div class="flex items-center gap-3">
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
        </div>

        <div class="hidden sm:flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-label-sm bg-brand-teal/10 text-brand-teal font-medium">
                Mode Ayat
            </span>
        </div>
    </div>
</div>
