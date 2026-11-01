<x-admin-layout>
    <x-slot name="title">Kelola Surah - Lentera Quran</x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">📖 Kelola Data Surah</h1>
                <p class="text-sm text-slate-500">Periksa dan koreksi data 114 surah serta tautan murotal.</p>
            </div>

            <form action="{{ route('admin.surah.index') }}" method="GET" class="flex gap-2">
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama / nomor..."
                       class="px-3 py-1.5 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-1.5 rounded-lg text-sm font-semibold transition">
                    Cari
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-slate-600 font-semibold text-xs uppercase">
                    <tr>
                        <th class="py-3 px-4 text-left">No</th>
                        <th class="py-3 px-4 text-left">Nama Latin</th>
                        <th class="py-3 px-4 text-right">Nama Arab</th>
                        <th class="py-3 px-4 text-left">Arti</th>
                        <th class="py-3 px-4 text-center">Ayat</th>
                        <th class="py-3 px-4 text-center">Tempat</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($surahs as $surah)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4 font-mono font-bold text-emerald-700">{{ $surah->id }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $surah->nama_latin }}</td>
                            <td class="py-3 px-4 font-arabic text-lg text-right" dir="rtl">{{ $surah->nama_arab }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $surah->arti }}</td>
                            <td class="py-3 px-4 text-center font-mono">{{ $surah->ayahs_count }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $surah->tempat_turun->value === 'mekah' ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }}">
                                    {{ $surah->tempat_turun->label() }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.surah.ayat.index', $surah->id) }}" class="text-xs font-semibold text-teal-600 hover:underline">
                                    Kelola Ayat
                                </a>
                                <a href="{{ route('admin.surah.edit', $surah->id) }}" class="text-xs font-semibold text-emerald-600 hover:underline">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-400">Tidak ada data surah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $surahs->links() }}
        </div>
    </div>
</x-admin-layout>

