<x-app-layout>
    <x-slot name="title">{{ $isJuzAmma ? 'Juz \'Amma' : 'Daftar 114 Surah' }} - Lentera Quran</x-slot>

    <div class="bg-white border-b border-slate-200 py-8 px-4">
        <div class="max-w-7xl mx-auto space-y-4">
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                {{ $isJuzAmma ? 'Pintasan Juz \'Amma (Surah 78 - 114)' : 'Daftar Surah Al-Qur\'an' }}
            </h1>
            <p class="text-sm text-slate-500">
                Pilih surah untuk mulai membaca teks Arab, latin, terjemahan, dan mendengarkan lantunan murotal.
            </p>

            <form action="{{ route('quran.index') }}" method="GET" class="flex flex-wrap gap-3 pt-2">
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama latin, arab, atau nomor..."
                       class="px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-64">

                <select name="juz" class="px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Semua Juz</option>
                    @for($i = 1; $i <= 30; $i++)
                        <option value="{{ $i }}" {{ (string)$selectedJuz === (string)$i ? 'selected' : '' }}>Juz {{ $i }}</option>
                    @endfor
                </select>

                <select name="tempat" class="px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Semua Tempat Turun</option>
                    <option value="mekah" {{ $selectedTempat === 'mekah' ? 'selected' : '' }}>Makkiyah (Mekah)</option>
                    <option value="madinah" {{ $selectedTempat === 'madinah' ? 'selected' : '' }}>Madaniyah (Madinah)</option>
                </select>

                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Terapkan
                </button>

                @if($q !== '' || $selectedJuz || $selectedTempat)
                    <a href="{{ route('quran.index') }}" wire:navigate class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-medium transition">
                        Reset Filter
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($surahs->isEmpty())
            <div class="text-center py-12 bg-white rounded-xl border border-slate-200">
                <p class="text-slate-500 text-base">Tidak ada surah yang cocok dengan pencarian Anda.</p>
                <a href="{{ route('quran.index') }}" wire:navigate class="mt-3 inline-block text-sm font-semibold text-emerald-600 hover:underline">
                    Reset Filter
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($surahs as $surah)
                    <a href="{{ route('quran.show', $surah->id) }}" wire:navigate
                       class="group p-5 bg-white rounded-xl border border-slate-200 hover:border-emerald-500 hover:shadow-md transition flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 font-bold text-sm flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition">
                                {{ $surah->id }}
                            </span>
                            <div>
                                <h3 class="font-bold text-slate-900 group-hover:text-emerald-700 text-base transition">
                                    {{ $surah->nama_latin }}
                                </h3>
                                <p class="text-xs text-slate-500">
                                    {{ $surah->arti }} • {{ $surah->jumlah_ayat }} Ayat • {{ $surah->tempat_turun->label() }}
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="font-arabic text-xl font-bold text-emerald-900" dir="rtl">
                                {{ $surah->nama_arab }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>

