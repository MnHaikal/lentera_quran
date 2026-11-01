<x-app-layout>
    <x-slot name="title">Beranda - Lentera Quran</x-slot>

    <div class="bg-gradient-to-br from-emerald-600 via-teal-700 to-emerald-900 text-white py-16 px-4">
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight">
                Lentera Al-Qur'an Digital
            </h1>
            <p class="text-emerald-100 text-base md:text-lg max-w-2xl mx-auto">
                Membaca, mendengarkan lantunan murotal, dan menyelami hikmah 114 surah dengan terjemahan standar Kemenag RI.
            </p>

            <form action="{{ route('quran.index') }}" method="GET" class="max-w-xl mx-auto flex items-center bg-white rounded-full p-1.5 shadow-lg">
                <input type="text" name="q" placeholder="Cari surah (misal: Al-Fatihah, Yasin, 36)..."
                       class="w-full px-5 py-3 text-slate-800 placeholder-slate-400 bg-transparent rounded-full focus:outline-none border-none">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-full font-semibold transition">
                    Cari
                </button>
            </form>

            @auth
                @if($lastRead)
                    <div class="pt-2">
                        <a href="{{ route('quran.show', $lastRead->surah_id) }}{{ $lastRead->ayah_id ? '?ayat=' . $lastRead->ayah->nomor_ayat : '' }}" wire:navigate
                           class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur border border-white/30 text-white px-5 py-2.5 rounded-full text-sm font-semibold transition">
                            <span>📖 Lanjutkan Baca:</span>
                            <span class="underline">Surah {{ $lastRead->surah->nama_latin }} {{ $lastRead->ayah ? 'Ayat ' . $lastRead->ayah->nomor_ayat : '' }}</span>
                            <span class="text-xs text-emerald-200">({{ $lastRead->updated_at->diffForHumans() }})</span>
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
        @if($ayatHarian)
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 p-6 md:p-8 relative overflow-hidden">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                        ✨ Ayat Hari Ini
                    </span>
                    <a href="{{ route('quran.show', $ayatHarian->surah_id) }}?ayat={{ $ayatHarian->nomor_ayat }}" wire:navigate
                       class="text-sm font-semibold text-emerald-600 hover:underline">
                        QS. {{ $ayatHarian->surah->nama_latin }}: {{ $ayatHarian->nomor_ayat }} →
                    </a>
                </div>

                <div class="py-6 text-right" dir="rtl">
                    <p class="font-arabic text-2xl md:text-3xl text-slate-900 leading-loose">
                        {{ $ayatHarian->teks_arab }}
                    </p>
                </div>

                <div class="space-y-2">
                    <p class="text-sm text-emerald-700 italic">
                        "{{ $ayatHarian->teks_latin }}"
                    </p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $ayatHarian->terjemahan }}
                    </p>
                </div>

                @if($ayatHarian->audio_url)
                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-3">
                        <button type="button"
                                @click="$dispatch('play-audio', { url: '{{ $ayatHarian->audio_url }}', title: 'QS. {{ $ayatHarian->surah->nama_latin }}: {{ $ayatHarian->nomor_ayat }}' })"
                                class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3.5 py-2 rounded-lg transition">
                            <span>▶ Dengarkan Murotal</span>
                        </button>
                    </div>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('tahlil.index') }}" wire:navigate
               class="group p-6 rounded-2xl bg-white border border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow transition flex items-center justify-between">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800 group-hover:text-emerald-600 transition">
                        📿 Bacaan Tahlil & Doa Arwah
                    </h3>
                    <p class="text-sm text-slate-500">
                        Rangkaian {{ $tahlilCount }} bacaan tahlil berurutan dengan teks Arab, latin, dan terjemahan.
                    </p>
                </div>
                <span class="text-2xl text-slate-300 group-hover:text-emerald-600 transition">→</span>
            </a>

            <a href="{{ route('doa.index') }}" wire:navigate
               class="group p-6 rounded-2xl bg-white border border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow transition flex items-center justify-between">
                <div class="space-y-1">
                    <h3 class="text-lg font-bold text-slate-800 group-hover:text-emerald-600 transition">
                        🤲 Kumpulan Doa Sehari-hari
                    </h3>
                    <p class="text-sm text-slate-500">
                        {{ $doaCount }} doa bersumber Al-Qur'an dan Hadits shahih per kategori.
                    </p>
                </div>
                <span class="text-2xl text-slate-300 group-hover:text-emerald-600 transition">→</span>
            </a>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Pintasan Juz 'Amma (Juz 30)</h2>
                    <p class="text-sm text-slate-500">Kumpulan surah pendek dari An-Naba' hingga An-Nas</p>
                </div>
                <a href="{{ route('quran.juz-amma') }}" wire:navigate class="text-sm font-semibold text-emerald-600 hover:underline">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($juzAmmaSurahs->take(9) as $surah)
                    <a href="{{ route('quran.show', $surah->id) }}" wire:navigate
                       class="p-4 bg-white rounded-xl border border-slate-200 hover:border-emerald-400 hover:shadow-sm transition flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-xs flex items-center justify-center">
                                {{ $surah->id }}
                            </span>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">{{ $surah->nama_latin }}</h4>
                                <p class="text-xs text-slate-400">{{ $surah->arti }} • {{ $surah->jumlah_ayat }} ayat</p>
                            </div>
                        </div>
                        <span class="font-arabic text-lg text-emerald-800" dir="rtl">{{ $surah->nama_arab }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
