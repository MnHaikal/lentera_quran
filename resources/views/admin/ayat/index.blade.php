<x-admin-layout>
    <x-slot name="title">Kelola Ayat: Surah {{ $surah->nama_latin }} - Lentera Quran</x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.surah.index') }}" class="text-xs font-semibold text-emerald-600 hover:underline">
                    ← Kembali ke Daftar Surah
                </a>
                <h1 class="text-2xl font-bold text-slate-800 mt-1">
                    📖 Ayat-Ayat Surah {{ $surah->nama_latin }} (Total: {{ $surah->jumlah_ayat }} Ayat)
                </h1>
            </div>

            <form action="{{ route('admin.surah.ayat.index', $surah->id) }}" method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ $q }}" placeholder="Nomor / Terjemahan..."
                       class="px-3 py-1.5 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-1.5 rounded-lg text-sm font-semibold transition">
                    Cari
                </button>
            </form>
        </div>

        <div class="space-y-4">
            @forelse($ayahs as $ayah)
                <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center">
                                {{ $ayah->nomor_ayat }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">Juz {{ $ayah->juz }}</span>
                        </div>

                        <a href="{{ route('admin.ayat.edit', $ayah->id) }}"
                           class="text-xs font-semibold text-emerald-600 hover:text-emerald-800 bg-emerald-50 px-3 py-1.5 rounded-lg transition">
                            ✏️ Koreksi Ayat
                        </a>
                    </div>

                    <div class="text-right py-2" dir="rtl">
                        <p class="font-arabic text-2xl text-slate-900 leading-loose">
                            {{ $ayah->teks_arab }}
                        </p>
                    </div>

                    <p class="text-xs font-medium text-emerald-800 italic">
                        {{ $ayah->teks_latin }}
                    </p>

                    <p class="text-xs text-slate-600 leading-relaxed">
                        {{ $ayah->terjemahan }}
                    </p>
                </div>
            @empty
                <div class="p-8 text-center bg-white rounded-xl border border-slate-200 text-slate-400">
                    Tidak ada ayat yang cocok.
                </div>
            @endforelse
        </div>

        <div>
            {{ $ayahs->links() }}
        </div>
    </div>
</x-admin-layout>

