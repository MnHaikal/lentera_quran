<x-admin-layout>
    <x-slot name="title">Edit Butir Tahlil - Lentera Quran</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800">Edit Butir Tahlil: {{ $tahlil->judul }}</h1>
            <a href="{{ route('admin.tahlil.index') }}" class="text-xs font-semibold text-slate-500 hover:underline">
                ← Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <form action="{{ route('admin.tahlil.update', $tahlil->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nomor Urutan</label>
                        <input type="number" name="urutan" min="1" value="{{ old('urutan', $tahlil->urutan) }}" required
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <x-input-error class="mt-1" :messages="$errors->get('urutan')" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Bacaan</label>
                        <input type="text" name="judul" value="{{ old('judul', $tahlil->judul) }}" required
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <x-input-error class="mt-1" :messages="$errors->get('judul')" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Teks Arab</label>
                    <textarea name="teks_arab" rows="4" required dir="rtl"
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xl font-arabic leading-loose focus:ring-emerald-500 focus:border-emerald-500">{{ old('teks_arab', $tahlil->teks_arab) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('teks_arab')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Teks Latin</label>
                    <textarea name="teks_latin" rows="3" required
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm italic focus:ring-emerald-500 focus:border-emerald-500">{{ old('teks_latin', $tahlil->teks_latin) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('teks_latin')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Terjemahan Indonesia</label>
                    <textarea name="terjemahan" rows="3" required
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">{{ old('terjemahan', $tahlil->terjemahan) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('terjemahan')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Jumlah Dibaca (Kali)</label>
                        <input type="number" name="jumlah_baca" min="1" max="1000" value="{{ old('jumlah_baca', $tahlil->jumlah_baca) }}" required
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <x-input-error class="mt-1" :messages="$errors->get('jumlah_baca')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Keterangan / Panduan</label>
                        <input type="text" name="keterangan" value="{{ old('keterangan', $tahlil->keterangan) }}"
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <x-input-error class="mt-1" :messages="$errors->get('keterangan')" />
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" id="is_published"
                           {{ old('is_published', $tahlil->is_published) ? 'checked' : '' }}
                           class="h-4 w-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                    <label for="is_published" class="text-sm font-semibold text-slate-700">Publikasikan ke pengguna</label>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('admin.tahlil.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">
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

