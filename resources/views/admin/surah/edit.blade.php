<x-admin-layout>
    <x-slot name="title">Edit Surah {{ $surah->nama_latin }} - Lentera Quran</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800">Edit Surah: {{ $surah->nama_latin }} (#{{ $surah->id }})</h1>
            <a href="{{ route('admin.surah.index') }}" class="text-xs font-semibold text-slate-500 hover:underline">
                ← Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <form action="{{ route('admin.surah.update', $surah->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Latin</label>
                        <input type="text" name="nama_latin" value="{{ old('nama_latin', $surah->nama_latin) }}" required
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <x-input-error class="mt-1" :messages="$errors->get('nama_latin')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Arab</label>
                        <input type="text" name="nama_arab" value="{{ old('nama_arab', $surah->nama_arab) }}" required dir="rtl"
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm font-arabic focus:ring-emerald-500 focus:border-emerald-500">
                        <x-input-error class="mt-1" :messages="$errors->get('nama_arab')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Arti Nama</label>
                        <input type="text" name="arti" value="{{ old('arti', $surah->arti) }}" required
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <x-input-error class="mt-1" :messages="$errors->get('arti')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Tempat Turun</label>
                        <select name="tempat_turun" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="mekah" {{ old('tempat_turun', $surah->tempat_turun->value) === 'mekah' ? 'selected' : '' }}>Makkiyah (Mekah)</option>
                            <option value="madinah" {{ old('tempat_turun', $surah->tempat_turun->value) === 'madinah' ? 'selected' : '' }}>Madaniyah (Madinah)</option>
                        </select>
                        <x-input-error class="mt-1" :messages="$errors->get('tempat_turun')" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">URL Audio Murotal Penuh</label>
                    <input type="url" name="audio_url" value="{{ old('audio_url', $surah->audio_url) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <x-input-error class="mt-1" :messages="$errors->get('audio_url')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Deskripsi / Asbabun Nuzul Singkat</label>
                    <textarea name="deskripsi" rows="4"
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">{{ old('deskripsi', $surah->deskripsi) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('deskripsi')" />
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('admin.surah.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>

