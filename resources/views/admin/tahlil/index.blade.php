<x-admin-layout>
    <x-slot name="title">Kelola Tahlil - Lentera Quran</x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">📿 Kelola Bacaan Tahlil</h1>
                <p class="text-sm text-slate-500">Daftar urutan bacaan tahlil dan doa arwah.</p>
            </div>

            <a href="{{ route('admin.tahlil.create') }}"
               class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition">
                + Tambah Butir Tahlil
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-slate-600 font-semibold text-xs uppercase">
                    <tr>
                        <th class="py-3 px-4 text-center">Urutan</th>
                        <th class="py-3 px-4 text-left">Judul</th>
                        <th class="py-3 px-4 text-center">Pengulangan</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4 text-center font-bold font-mono text-emerald-700">{{ $item->urutan }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $item->judul }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $item->jumlah_baca }}x
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $item->is_published ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                                    {{ $item->is_published ? 'Publik' : 'Draft' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.tahlil.edit', $item->id) }}" class="text-xs font-semibold text-emerald-600 hover:underline">
                                    Edit
                                </a>
                                <form action="{{ route('admin.tahlil.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus butir tahlil ini?');">
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
                            <td colspan="5" class="py-6 text-center text-slate-400">Belum ada butir tahlil.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $items->links() }}
        </div>
    </div>
</x-admin-layout>

