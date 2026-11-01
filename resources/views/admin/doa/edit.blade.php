<x-admin-layout>
    <x-slot name="title">Edit Doa - Lentera Quran</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800">Edit Doa: {{ $doa->judul }}</h1>
            <a href="{{ route('admin.doa.index') }}" class="text-xs font-semibold text-slate-500 hover:underline">
                ← Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <form action="{{ route('admin.doa.update', $doa->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategori Doa</label>
                        <select name="doa_category_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('doa_category_id', $doa->doa_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-1" :messages="$errors->get('doa_category_id')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Judul Doa</label>
                        <input type="text" name="judul" value="{{ old('judul', $doa->judul) }}" required
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <x-input-error class="mt-1" :messages="$errors->get('judul')" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Slug URL</label>
                    <input type="text" name="slug" value="{{ old('slug', $doa->slug) }}" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <x-input-error class="mt-1" :messages="$errors->get('slug')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Teks Arab (Berharakat)</label>
                    <textarea name="teks_arab" rows="4" required dir="rtl"
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xl font-arabic leading-loose focus:ring-emerald-500 focus:border-emerald-500">{{ old('teks_arab', $doa->teks_arab) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('teks_arab')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Teks Latin (Transliterasi)</label>
                    <textarea name="teks_latin" rows="3" required
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm italic focus:ring-emerald-500 focus:border-emerald-500">{{ old('teks_latin', $doa->teks_latin) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('teks_latin')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Terjemahan Indonesia</label>
                    <textarea name="terjemahan" rows="3" required
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">{{ old('terjemahan', $doa->terjemahan) }}</textarea>
                    <x-input-error class="mt-1" :messages="$errors->get('terjemahan')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Sumber Dalil / Riwayat</label>
                    <input type="text" name="sumber" value="{{ old('sumber', $doa->sumber) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <x-input-error class="mt-1" :messages="$errors->get('sumber')" />
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" id="is_published"
                           {{ old('is_published', $doa->is_published) ? 'checked' : '' }}
                           class="h-4 w-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                    <label for="is_published" class="text-sm font-semibold text-slate-700">Publikasikan ke pengguna</label>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('admin.doa.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">
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

