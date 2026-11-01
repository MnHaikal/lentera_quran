<x-admin-layout>
    <x-slot name="title">Koreksi Ayat {{ $ayah->nomor_ayat }} - Lentera Quran</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800">
                Koreksi Surah {{ $ayah->surah->nama_latin }} : Ayat {{ $ayah->nomor_ayat }}
            </h1>
            <a href="{{ route('admin.surah.ayat.index', $ayah->surah_id) }}" class="text-xs font-semibold text-slate-500 hover:underline">
                ← Kembali ke Ayat
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <form action="{{ route('admin.ayat.update', $ayah->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Teks Arab (Berharakat)</label>
                    <textarea name="teks_arab" rows="4" required dir="rtl"
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-lg font-arabic leading-loose focus:ring-emerald-500 focus:border-emerald-500">{{ old('teks_arab', $ayah->teks_arab) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('teks_arab')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Teks Latin (Transliterasi)</label>
                    <textarea name="teks_latin" rows="3" required
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm italic focus:ring-emerald-500 focus:border-emerald-500">{{ old('teks_latin', $ayah->teks_latin) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('teks_latin')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Terjemahan Bahasa Indonesia</label>
                    <textarea name="terjemahan" rows="4" required
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">{{ old('terjemahan', $ayah->terjemahan) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('terjemahan')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Juz (1 - 30)</label>
                        <input type="number" name="juz" min="1" max="30" value="{{ old('juz', $ayah->juz) }}" required
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <x-input-error class="mt-1" :messages="$errors->get('juz')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">URL Audio Ayat</label>
                        <input type="url" name="audio_url" value="{{ old('audio_url', $ayah->audio_url) }}"
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <x-input-error class="mt-1" :messages="$errors->get('audio_url')" />
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('admin.surah.ayat.index', $ayah->surah_id) }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition">
                        Simpan Koreksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

