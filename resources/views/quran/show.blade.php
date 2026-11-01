<x-app-layout>
    <x-slot name="title">Surah {{ $surah->nama_latin }} ({{ $surah->nama_arab }}) - Lentera Quran</x-slot>

    <div x-data="{
        fontSize: {{ auth()->user()?->settings?->ukuran_font_arab ?? 28 }},
        showLatin: {{ (auth()->user()?->settings?->tampilkan_latin ?? true) ? 'true' : 'false' }},
        showTranslation: {{ (auth()->user()?->settings?->tampilkan_terjemahan ?? true) ? 'true' : 'false' }},
        isSurahBookmarked: {{ $isSurahBookmarked ? 'true' : 'false' }},
        bookmarkedAyahs: {{ json_encode($bookmarkedAyahIds) }},

        toggleSurahBookmark() {
            @guest
                window.location.href = '{{ route('login') }}';
                return;
            @endguest

            fetch('{{ route('bookmark.surah', $surah->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.isSurahBookmarked = data.bookmarked;
            });
        },

        toggleAyahBookmark(ayahId) {
            @guest
                window.location.href = '{{ route('login') }}';
                return;
            @endguest

            fetch(`/ayat/${ayahId}/simpan`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.bookmarked) {
                    if (!this.bookmarkedAyahs.includes(ayahId)) {
                        this.bookmarkedAyahs.push(ayahId);
                    }
                } else {
                    this.bookmarkedAyahs = this.bookmarkedAyahs.filter(id => id !== ayahId);
                }
            });
        },

        markLastRead(ayahId) {
            @auth
            fetch('{{ route('terakhir-dibaca.store', $surah->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ ayah_id: ayahId })
            });
            @endauth
        },

        copyAyah(arabic, translation, ayahNum) {
            const text = `${arabic}\n\n${translation}\n(QS. {{ $surah->nama_latin }}: ${ayahNum})`;
            navigator.clipboard.writeText(text).then(() => {
                alert('Teks ayat berhasil disalin!');
            });
        }
    }"
    x-init="
        markLastRead(null);
        @if($targetAyat)
            $nextTick(() => {
                const el = document.getElementById('ayat-{{ $targetAyat }}');
                if (el) el.scrollIntoView({ behavior: 'smooth' });
            });
        @endif
    "
    class="max-w-5xl mx-auto px-4 py-8 space-y-6">

        <div class="bg-gradient-to-r from-emerald-700 to-teal-800 text-white rounded-2xl p-6 md:p-8 shadow-md">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
                <div class="space-y-2">
                    <div class="flex items-center justify-center md:justify-start gap-2">
                        <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold uppercase tracking-wider">
                            Surah ke-{{ $surah->id }} • {{ $surah->tempat_turun->label() }}
                        </span>
                        <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">
                            {{ $surah->jumlah_ayat }} Ayat
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold">{{ $surah->nama_latin }}</h1>
                    <p class="text-emerald-100 text-sm">Arti: {{ $surah->arti }}</p>
                </div>

                <div class="space-y-4 text-center md:text-right">
                    <span class="font-arabic text-4xl md:text-5xl font-bold" dir="rtl">{{ $surah->nama_arab }}</span>
                    <div class="flex items-center justify-center md:justify-end gap-2 pt-2">
                        @if($surah->audio_url)
                            <button type="button"
                                    @click="$dispatch('play-audio', { url: '{{ $surah->audio_url }}', title: 'Surah {{ $surah->nama_latin }} (Full)' })"
                                    class="inline-flex items-center gap-2 bg-white text-emerald-800 hover:bg-emerald-50 px-4 py-2 rounded-xl text-xs font-bold shadow transition">
                                <span>▶ Putar Murotal Surah</span>
                            </button>
                        @endif

                        <button type="button"
                                @click="toggleSurahBookmark"
                                :class="isSurahBookmarked ? 'bg-amber-400 text-amber-950 font-bold' : 'bg-white/20 text-white hover:bg-white/30'"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs transition">
                            <span x-text="isSurahBookmarked ? '★ Tersimpan' : '☆ Simpan Surah'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <span class="text-xs font-semibold text-slate-500 uppercase">Tampilan:</span>
                <label class="inline-flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer">
                    <input type="checkbox" x-model="showLatin" class="rounded text-emerald-600 focus:ring-emerald-500">
                    Latin
                </label>
                <label class="inline-flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer">
                    <input type="checkbox" x-model="showTranslation" class="rounded text-emerald-600 focus:ring-emerald-500">
                    Terjemahan
                </label>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-slate-500">Ukuran Huruf Arab:</span>
                <input type="range" min="20" max="44" step="2" x-model="fontSize" class="w-28 accent-emerald-600">
                <span class="text-xs font-mono text-slate-600" x-text="fontSize + 'px'"></span>
            </div>
        </div>

        @if($surah->id !== 1 && $surah->id !== 9)
            <div class="text-center py-6">
                <p class="font-arabic text-3xl text-slate-800" dir="rtl">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
            </div>
        @endif

        <div class="space-y-4">
            @foreach($surah->ayahs as $ayah)
                <div id="ayat-{{ $ayah->nomor_ayat }}"
                     class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm transition hover:border-emerald-300 space-y-4"
                     :class="{ 'ring-2 ring-emerald-500 bg-emerald-50/30': {{ $targetAyat == $ayah->nomor_ayat ? 'true' : 'false' }} }">

                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center">
                                {{ $ayah->nomor_ayat }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">Juz {{ $ayah->juz }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            @if($ayah->audio_url)
                                <button type="button"
                                        @click="$dispatch('play-audio', { url: '{{ $ayah->audio_url }}', title: 'QS. {{ $surah->nama_latin }}: {{ $ayah->nomor_ayat }}' })"
                                        title="Putar Audio Ayat"
                                        class="p-1.5 rounded-lg text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6V4z"/></svg>
                                </button>
                            @endif

                            <button type="button"
                                    @click="toggleAyahBookmark({{ $ayah->id }})"
                                    :title="bookmarkedAyahs.includes({{ $ayah->id }}) ? 'Hapus Simpanan' : 'Simpan Ayat'"
                                    class="p-1.5 rounded-lg transition"
                                    :class="bookmarkedAyahs.includes({{ $ayah->id }}) ? 'text-amber-500' : 'text-slate-400 hover:text-amber-500'">
                                <span x-text="bookmarkedAyahs.includes({{ $ayah->id }}) ? '★' : '☆'" class="text-base"></span>
                            </button>

                            <button type="button"
                                    @click="markLastRead({{ $ayah->id }})"
                                    title="Tandai Terakhir Dibaca"
                                    class="text-xs font-medium text-slate-500 hover:text-emerald-600 px-2 py-1 rounded hover:bg-emerald-50 transition">
                                📌 Tandai
                            </button>

                            <button type="button"
                                    @click="copyAyah('{{ addslashes($ayah->teks_arab) }}', '{{ addslashes($ayah->terjemahan) }}', {{ $ayah->nomor_ayat }})"
                                    title="Salin Ayat"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                                📋
                            </button>
                        </div>
                    </div>

                    <div class="text-right py-4" dir="rtl">
                        <p class="font-arabic leading-loose text-slate-900"
                           :style="'font-size: ' + fontSize + 'px; line-height: 2.2;'">
                            {{ $ayah->teks_arab }}
                        </p>
                    </div>

                    <div x-show="showLatin" class="pt-2">
                        <p class="text-sm font-medium text-emerald-800 italic leading-relaxed">
                            {{ $ayah->teks_latin }}
                        </p>
                    </div>

                    <div x-show="showTranslation" class="pt-2">
                        <p class="text-sm text-slate-600 leading-relaxed">
                            {{ $ayah->terjemahan }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-between pt-8 border-t border-slate-200">
            @if($prevSurah)
                <a href="{{ route('quran.show', $prevSurah->id) }}" wire:navigate
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:border-emerald-500 transition">
                    ← Surah {{ $prevSurah->nama_latin }}
                </a>
            @else
                <div></div>
            @endif

            @if($nextSurah)
                <a href="{{ route('quran.show', $nextSurah->id) }}" wire:navigate
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:border-emerald-500 transition">
                    Surah {{ $nextSurah->nama_latin }} →
                </a>
            @endif
        </div>
    </div>
</x-app-layout>
