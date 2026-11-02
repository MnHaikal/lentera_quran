import './bootstrap';

const THEME_STORAGE_KEY = 'lq_theme';

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
        qariName: 'Misyari Rasyid Al-Afasi',
        src: '',

        getAudioElement() {
            return document.getElementById('lentera-audio-element');
        },

        playTrack({ surahId, surahName, ayahNumber = null, src, qariName = 'Misyari Rasyid Al-Afasi' }) {
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
            this.qariName = qariName;
            this.src = src;
            this.hasTrack = true;

            audio.src = src;
            audio.play().then(() => {
                this.isPlaying = true;
            }).catch(() => {
                this.isPlaying = false;
            });

            audio.onended = () => {
                this.isPlaying = false;
            };
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

        isCurrentAyah(surahId, ayahNumber) {
            return this.hasTrack && this.surahId === surahId && this.ayahNumber === ayahNumber;
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
