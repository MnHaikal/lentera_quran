<x-admin-layout>
    <x-slot name="title">Kelola Doa - Lentera Quran</x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">🤲 Kelola Doa</h1>
                <p class="text-sm text-slate-500">Daftar koleksi doa harian, para nabi, dan doa sesudah sholat.</p>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('admin.doa.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul / arti..."
                           class="px-3 py-1.5 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold transition">
                        Cari
                    </button>
                </form>

                <a href="{{ route('admin.doa.create') }}"
                   class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition shrink-0">
                    + Tambah Doa
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-slate-600 font-semibold text-xs uppercase">
                    <tr>
                        <th class="py-3 px-4 text-left">Judul Doa</th>
                        <th class="py-3 px-4 text-left">Kategori</th>
                        <th class="py-3 px-4 text-left">Sumber / Riwayat</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($doas as $doa)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $doa->judul }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                    {{ $doa->category->nama ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-xs text-slate-500">{{ $doa->sumber ?? '-' }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $doa->is_published ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-400' }}">
                                    {{ $doa->is_published ? 'Publik' : 'Draft' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.doa.edit', $doa->id) }}" class="text-xs font-semibold text-emerald-600 hover:underline">
                                    Edit
                                </a>
                                <form action="{{ route('admin.doa.destroy', $doa->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus doa ini?');">
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
                            <td colspan="5" class="py-6 text-center text-slate-400">Belum ada doa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $doas->links() }}
        </div>
    </div>
</x-admin-layout>

