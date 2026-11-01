<x-admin-layout>
    <x-slot name="title">Edit Kategori Doa - Lentera Quran</x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800">Edit Kategori: {{ $kategori->nama }}</h1>
            <a href="{{ route('admin.kategori-doa.index') }}" class="text-xs font-semibold text-slate-500 hover:underline">
                ← Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8">
            <form action="{{ route('admin.kategori-doa.update', $kategori->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nama Kategori</label>
                    <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <x-input-error class="mt-1" :messages="$errors->get('nama')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Slug URL</label>
                    <input type="text" name="slug" value="{{ old('slug', $kategori->slug) }}" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <x-input-error class="mt-1" :messages="$errors->get('slug')" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Nomor Urutan</label>
                    <input type="number" name="urutan" min="1" value="{{ old('urutan', $kategori->urutan) }}" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <x-input-error class="mt-1" :messages="$errors->get('urutan')" />
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('admin.kategori-doa.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">
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

