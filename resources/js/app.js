import './bootstrap';

const THEME_STORAGE_KEY = 'lq_theme';

function formatTime(seconds) {
    if (!seconds || isNaN(seconds) || seconds < 0) {
        return '00:00';
    }
    const hrs = Math.floor(seconds / 3600);
    const mins = Math.floor((seconds % 3600) / 60);
    const secs = Math.floor(seconds % 60);

    if (hrs > 0) {
        return `${hrs}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    }
    return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
}

function resolveEffectiveDark(preference) {
    if (preference === 'gelap') {
        return true;
    }

    if (preference === 'terang') {
        return false;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

function applyThemePreference(preference) {
    const isDark = resolveEffectiveDark(preference);
    document.documentElement.classList.toggle('dark', isDark);
    document.documentElement.dataset.themePreference = preference;
}

function getStoredThemePreference() {
    const stored = localStorage.getItem(THEME_STORAGE_KEY);

    if (stored === 'terang' || stored === 'gelap' || stored === 'sistem') {
        return stored;
    }

    return 'sistem';
}

document.addEventListener('alpine:init', () => {
    window.Alpine.store('theme', {
        current: getStoredThemePreference(),

        set(preference) {
            this.current = preference;
            localStorage.setItem(THEME_STORAGE_KEY, preference);
            applyThemePreference(preference);
        },

        cycle() {
            const order = ['sistem', 'terang', 'gelap'];
            const nextIndex = (order.indexOf(this.current) + 1) % order.length;
            this.set(order[nextIndex]);
        },
    });

    window.Alpine.store('audioPlayer', {
        hasTrack: false,
        isPlaying: false,
        surahId: null,
        surahName: '',
        ayahNumber: null,
        totalAyat: null,
        isLoadingTrack: false,
        qariName: 'Misyari Rasyid Al-Afasi',
        src: '',
        currentTime: 0,
        duration: 0,
        progress: 0,
        formattedCurrentTime: '00:00',
        formattedDuration: '00:00',

        getAudioElement() {
            const audio = document.getElementById('lentera-audio-element');
            if (audio && !audio._eventsBound) {
                this.bindAudioEvents(audio);
            }
            return audio;
        },

        initAudio() {
            this.getAudioElement();
        },

        bindAudioEvents(audio) {
            if (!audio || audio._eventsBound) {
                return;
            }
            audio._eventsBound = true;

            const updateDuration = () => {
                const dur = audio.duration;
                if (dur && !isNaN(dur) && isFinite(dur) && dur > 0) {
                    this.duration = dur;
                    this.formattedDuration = formatTime(dur);
                    if (this.currentTime > 0) {
                        this.progress = Math.min(100, Math.max(0, (this.currentTime / dur) * 100));
                    }
                }
            };

            audio.addEventListener('timeupdate', () => {
                this.currentTime = audio.currentTime || 0;
                this.formattedCurrentTime = formatTime(this.currentTime);

                const dur = audio.duration;
                if (dur && !isNaN(dur) && isFinite(dur) && dur > 0) {
                    this.duration = dur;
                    this.formattedDuration = formatTime(dur);
                    this.progress = Math.min(100, Math.max(0, (this.currentTime / dur) * 100));
                }
            });

            audio.addEventListener('loadedmetadata', updateDuration);
            audio.addEventListener('durationchange', updateDuration);

            audio.addEventListener('play', () => {
                this.isPlaying = true;
            });

            audio.addEventListener('pause', () => {
                this.isPlaying = false;
            });

            audio.addEventListener('ended', () => {
                this.isPlaying = false;
                this.currentTime = 0;
                this.progress = 0;
                this.formattedCurrentTime = '00:00';
            });
        },

        playTrack({ surahId, surahName, ayahNumber = null, totalAyat = null, src, qariName = 'Misyari Rasyid Al-Afasi' }) {
            if (!src) {
                return;
            }

            const audio = this.getAudioElement();
            if (!audio) {
                return;
            }

            if (this.src === src) {
                this.toggle();
                return;
            }

            this.surahId = surahId;
            this.surahName = surahName;
            this.ayahNumber = ayahNumber;
            this.totalAyat = totalAyat;
            this.qariName = qariName;
            this.src = src;
            this.hasTrack = true;
            this.currentTime = 0;
            this.duration = 0;
            this.progress = 0;
            this.formattedCurrentTime = '00:00';
            this.formattedDuration = '00:00';

            // Jika totalAyat belum diketahui saat pemutaran per ayat, ambil dari API secara background
            if (this.ayahNumber !== null && !this.totalAyat) {
                fetch(`/api/audio/track?surah=${surahId}`)
                    .then((res) => res.json())
                    .then((data) => {
                        if (data && data.totalAyat && Number(this.surahId) === Number(surahId)) {
                            this.totalAyat = data.totalAyat;
                        }
                    })
                    .catch(() => {});
            }

            audio.src = src;
            audio.play().then(() => {
                this.isPlaying = true;
            }).catch(() => {
                this.isPlaying = false;
            });
        },

        canGoPrevious() {
            if (!this.hasTrack || this.isLoadingTrack) {
                return false;
            }
            if (this.ayahNumber !== null && this.ayahNumber !== undefined) {
                return Number(this.ayahNumber) > 1;
            }
            return Number(this.surahId) > 1;
        },

        canGoNext() {
            if (!this.hasTrack || this.isLoadingTrack) {
                return false;
            }
            if (this.ayahNumber !== null && this.ayahNumber !== undefined) {
                if (this.totalAyat) {
                    return Number(this.ayahNumber) < Number(this.totalAyat);
                }
                return true;
            }
            return Number(this.surahId) < 114;
        },

        async next() {
            if (!this.canGoNext()) {
                return;
            }

            let targetSurah = this.surahId;
            let targetAyat = null;

            if (this.ayahNumber !== null && this.ayahNumber !== undefined) {
                targetAyat = Number(this.ayahNumber) + 1;
            } else {
                targetSurah = Number(this.surahId) + 1;
            }

            await this.loadAndPlayTrack(targetSurah, targetAyat);
        },

        async previous() {
            if (!this.canGoPrevious()) {
                return;
            }

            let targetSurah = this.surahId;
            let targetAyat = null;

            if (this.ayahNumber !== null && this.ayahNumber !== undefined) {
                targetAyat = Number(this.ayahNumber) - 1;
            } else {
                targetSurah = Number(this.surahId) - 1;
            }

            await this.loadAndPlayTrack(targetSurah, targetAyat);
        },

        async loadAndPlayTrack(surahId, ayahNumber = null) {
            if (this.isLoadingTrack) {
                return;
            }
            this.isLoadingTrack = true;

            try {
                let url = `/api/audio/track?surah=${surahId}`;
                if (ayahNumber !== null && ayahNumber !== undefined) {
                    url += `&ayat=${ayahNumber}`;
                }

                const response = await fetch(url);
                if (!response.ok) {
                    return;
                }

                const data = await response.json();
                if (data && data.src) {
                    this.playTrack({
                        surahId: data.surahId,
                        surahName: data.surahName,
                        ayahNumber: data.ayahNumber,
                        totalAyat: data.totalAyat,
                        src: data.src,
                        qariName: data.qariName,
                    });

                    // Jika berada di halaman surah yang sama dan memutar per ayat, scroll ke ayat yang diputar
                    if (data.ayahNumber) {
                        const targetEl = document.getElementById('ayat-' + data.ayahNumber);
                        if (targetEl) {
                            targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                }
            } catch (err) {
                console.error('Gagal memuat track audio:', err);
            } finally {
                this.isLoadingTrack = false;
            }
        },

        toggle() {
            const audio = this.getAudioElement();
            if (!audio || !this.src) {
                return;
            }

            if (audio.paused) {
                audio.play().then(() => {
                    this.isPlaying = true;
                }).catch(() => {});
            } else {
                audio.pause();
                this.isPlaying = false;
            }
        },

        seekByEvent(event) {
            const audio = this.getAudioElement();
            if (!audio || !this.duration) {
                return;
            }
            const rect = event.currentTarget.getBoundingClientRect();
            if (!rect.width) {
                return;
            }
            const clickX = event.clientX - rect.left;
            const percentage = Math.max(0, Math.min(1, clickX / rect.width));
            audio.currentTime = percentage * this.duration;
            this.currentTime = audio.currentTime;
            this.progress = percentage * 100;
            this.formattedCurrentTime = formatTime(this.currentTime);
        },

        close() {
            const audio = this.getAudioElement();
            if (audio) {
                audio.pause();
                audio.currentTime = 0;
                audio.removeAttribute('src');
                audio.load();
            }
            this.isPlaying = false;
            this.hasTrack = false;
            this.surahId = null;
            this.surahName = '';
            this.ayahNumber = null;
            this.totalAyat = null;
            this.isLoadingTrack = false;
            this.src = '';
            this.currentTime = 0;
            this.duration = 0;
            this.progress = 0;
            this.formattedCurrentTime = '00:00';
            this.formattedDuration = '00:00';
        },

        isCurrentAyah(surahId, ayahNumber) {
            return Boolean(
                this.hasTrack &&
                Number(this.surahId) === Number(surahId) &&
                this.ayahNumber !== null &&
                Number(this.ayahNumber) === Number(ayahNumber)
            );
        },

        isCurrentSurah(surahId) {
            return Boolean(
                this.hasTrack &&
                Number(this.surahId) === Number(surahId)
            );
        },
    });
});

document.addEventListener('livewire:navigated', () => {
    applyThemePreference(getStoredThemePreference());
});

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const current = getStoredThemePreference();
    if (current === 'sistem') {
        applyThemePreference('sistem');
    }
});
