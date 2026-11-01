<x-admin-layout>
    <x-slot name="title">Kelola Pengguna - Lentera Quran</x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">👥 Kelola Akun Pengguna</h1>
                <p class="text-sm text-slate-500">Kelola peran (Super Admin, Admin, User) dan kredensial pengguna.</p>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('admin.pengguna.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="q" value="{{ $q }}" placeholder="Nama / Email..."
                           class="px-3 py-1.5 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold transition">
                        Cari
                    </button>
                </form>

                <a href="{{ route('admin.pengguna.create') }}"
                   class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition shrink-0">
                    + Tambah Pengguna
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-slate-600 font-semibold text-xs uppercase">
                    <tr>
                        <th class="py-3 px-4 text-left">Nama</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-center">Peran (Role)</th>
                        <th class="py-3 px-4 text-left">Terdaftar</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $user->name }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->isSuperAdmin() ? 'bg-purple-100 text-purple-800' : ($user->isAdmin() ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-700') }}">
                                    {{ $user->role->label() }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.pengguna.edit', $user->id) }}" class="text-xs font-semibold text-emerald-600 hover:underline">
                                    Edit
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $users->links() }}
        </div>
    </div>
</x-admin-layout>

