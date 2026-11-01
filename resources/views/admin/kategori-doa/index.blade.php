<x-admin-layout>
    <x-slot name="title">Kelola Kategori Doa - Lentera Quran</x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">📁 Kategori Doa</h1>
                <p class="text-sm text-slate-500">Kategori untuk mengelompokkan koleksi doa.</p>
            </div>

            <a href="{{ route('admin.kategori-doa.create') }}"
               class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition">
                + Tambah Kategori
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-slate-600 font-semibold text-xs uppercase">
                    <tr>
                        <th class="py-3 px-4 text-center">Urutan</th>
                        <th class="py-3 px-4 text-left">Nama Kategori</th>
                        <th class="py-3 px-4 text-left">Slug URL</th>
                        <th class="py-3 px-4 text-center">Jumlah Doa</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4 text-center font-bold font-mono text-emerald-700">{{ $category->urutan }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $category->nama }}</td>
                            <td class="py-3 px-4 font-mono text-xs text-slate-500">{{ $category->slug }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                    {{ $category->doas_count }} Doa
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.kategori-doa.edit', $category->id) }}" class="text-xs font-semibold text-emerald-600 hover:underline">
                                    Edit
                                </a>
                                <form action="{{ route('admin.kategori-doa.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400">Belum ada kategori doa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $categories->links() }}
        </div>
    </div>
</x-admin-layout>

