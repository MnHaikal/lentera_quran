<x-admin-layout>
    <x-slot name="title">Dashboard Admin - Lentera Quran</x-slot>

    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">📊 Ringkasan Statistik Sistem</h1>
            <p class="text-sm text-slate-500">Statistik data Al-Qur'an, Tahlil, Doa, dan Pengguna aktif.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase">Total Surah</span>
                <p class="text-2xl font-extrabold text-emerald-700">{{ $stats['total_surahs'] }}</p>
                <span class="text-xs text-slate-500">114 Surah Lengkap</span>
            </div>

            <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase">Total Ayat</span>
                <p class="text-2xl font-extrabold text-emerald-700">{{ number_format($stats['total_ayahs']) }}</p>
                <span class="text-xs text-slate-500">Riwayat Hafs</span>
            </div>

            <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase">Butir Tahlil</span>
                <p class="text-2xl font-extrabold text-teal-700">{{ $stats['total_tahlil'] }}</p>
                <span class="text-xs text-slate-500">Bacaan Terurut</span>
            </div>

            <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase">Total Doa</span>
                <p class="text-2xl font-extrabold text-teal-700">{{ $stats['total_doas'] }}</p>
                <span class="text-xs text-slate-500">{{ $stats['total_doa_categories'] }} Kategori</span>
            </div>

            <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase">Pengguna Terdaftar</span>
                <p class="text-2xl font-extrabold text-indigo-700">{{ $stats['total_users'] }}</p>
                <span class="text-xs text-slate-500">Akun Pengguna</span>
            </div>

            <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase">Bookmark Dibuat</span>
                <p class="text-2xl font-extrabold text-amber-600">{{ $stats['total_bookmarks'] }}</p>
                <span class="text-xs text-slate-500">Surah, Ayat & Doa</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="font-bold text-slate-800 text-base">👥 Pengguna Terbaru</h3>
                <div class="divide-y divide-slate-100">
                    @forelse($recentUsers as $user)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                                <p class="text-xs text-slate-400">{{ $user->email }}</p>
                            </div>
                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $user->isSuperAdmin() ? 'bg-purple-100 text-purple-800' : ($user->isAdmin() ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-700') }}">
                                {{ $user->role->label() }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3">Belum ada data pengguna.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="font-bold text-slate-800 text-base">🔖 Bookmark Terakhir</h3>
                <div class="divide-y divide-slate-100">
                    @forelse($recentBookmarks as $bm)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-800">
                                    {{ $bm->user->name ?? 'Pengguna' }} menyimpan <span class="capitalize">{{ $bm->bookmarkable_type }}</span>
                                </p>
                                <p class="text-xs text-slate-400">{{ $bm->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="text-xs font-mono text-emerald-700 bg-emerald-50 px-2 py-1 rounded">
                                #{{ $bm->bookmarkable_id }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-3">Belum ada bookmark.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
