@extends('admin.layouts.app')

@section('title', 'Kelola Pengguna & Peran — Super Admin Lentera Quran')

@section('topbar_title')
    <div class="flex items-center gap-2.5 flex-wrap">
        <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
            Kelola Pengguna &amp; Peran
        </h1>
    </div>
@endsection

@section('content')
<div
    x-data="{
        deleteModalOpen: false,
        userToDelete: { id: null, name: '', email: '' },
        confirmDelete(id, name, email) {
            this.userToDelete = { id: id, name: name, email: email };
            this.deleteModalOpen = true;
        }
    }"
    class="space-y-4"
>
    {{-- Flash Success Message --}}
    @if(session('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="flex items-center justify-between p-4 rounded-xl bg-[#E6F7F8] border border-[#BCE8ED] text-[#0E7B87] shadow-xs"
        >
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-[#0E7B87] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs font-semibold">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-[#0E7B87] hover:text-[#084A52] transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- Flash Error Message --}}
    @if(session('error'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="flex items-center justify-between p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 shadow-xs"
        >
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <p class="text-xs font-semibold">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-red-500 hover:text-red-700 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- Flash Validation Error Message --}}
    @if(isset($errors) && $errors->any())
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 shadow-xs space-y-1"
        >
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold">Terjadi kesalahan pada data formulir:</p>
                <button @click="show = false" class="text-red-500 hover:text-red-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Main Data Table Card with Integrated Search & Filter Toolbar --}}
    <div
        class="rounded-2xl bg-white dark:bg-[#0D213A] border border-[#EAE3D2] dark:border-white/10 overflow-hidden shadow-xs"
    >
        {{-- Toolbar: Search & Role Filter (Integrated into Table Card) --}}
        <div class="p-3.5 sm:p-4 border-b border-[#EAE3D2] dark:border-white/10 bg-white dark:bg-[#0D213A]">
            <form
                method="GET"
                action="{{ route('admin.users.index') }}"
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 flex-wrap"
            >
                {{-- Search Box --}}
                <div class="relative w-full sm:w-72 md:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#8C98A4]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari nama atau email pengguna..."
                        class="w-full pl-9 pr-3.5 py-2 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] dark:bg-[#132C4B] text-[#0F1E36] dark:text-white placeholder-[#8C98A4] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:bg-white transition"
                    >
                </div>

                {{-- Filter Group --}}
                <div class="flex flex-wrap items-center gap-2.5">
                    {{-- Dropdown Peran (Sesuaikan opsi peran: Semua Peran, Super Admin, Jamaah) --}}
                    <select
                        name="peran"
                        onchange="this.form.submit()"
                        class="py-2 pl-3 pr-8 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] dark:bg-[#132C4B] text-[#0F1E36] dark:text-white font-medium focus:outline-none focus:ring-1 focus:ring-[#0E7B87] cursor-pointer hover:bg-[#F2ECE0] transition"
                    >
                        <option value="">Semua Peran</option>
                        <option value="super_admin" {{ request('peran') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin" {{ request('peran') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('peran') === 'user' ? 'selected' : '' }}>Jamaah (Pengguna)</option>
                    </select>

                    {{-- Reset Filter Button --}}
                    @if(request()->filled('q') || request()->filled('peran'))
                        <a
                            href="{{ route('admin.users.index') }}"
                            wire:navigate
                            wire:navigate.hover
                            title="Reset Filter"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-[#8C98A4] hover:text-[#D9383A] hover:bg-red-50 dark:hover:bg-red-950/30 transition border border-transparent hover:border-red-200"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[760px]">
                <thead>
                    <tr class="border-b border-[#EAE3D2] dark:border-white/10 bg-[#FFFDF7] dark:bg-[#102744] text-[11px] font-bold text-[#4A5B6C] dark:text-[#9AB1C9] uppercase tracking-wider">
                        <th scope="col" class="px-5 py-3.5 text-left">
                            Pengguna
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-left w-44">
                            Peran
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-left w-40">
                            Tanggal Daftar
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-center w-24">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAE3D2] dark:divide-white/10 text-xs">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#FAF7F0]/60 dark:hover:bg-white/5 transition group">
                            {{-- Pengguna Info --}}
                            <td class="px-5 py-4">
                                @php
                                    $isMe = Auth::id() === $user->id;
                                    $initials = collect(explode(' ', $user->name))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                        ->join('');
                                    if (empty($initials)) {
                                        $initials = strtoupper(substr($user->name, 0, 2));
                                    }

                                    $avatarBg = match($user->role->value ?? '') {
                                        'super_admin' => 'bg-[#0F2D4F] text-white border-[#27486E]',
                                        'admin' => 'bg-[#134E4A] text-white border-[#0F766E]',
                                        default => 'bg-[#FAF4E6] text-[#78664D] border-[#F0E4CA]',
                                    };
                                @endphp
                                <div class="flex items-center gap-3">
                                    {{-- Avatar Circle --}}
                                    <div class="w-9 h-9 rounded-full border flex items-center justify-center text-xs font-bold shrink-0 {{ $avatarBg }}">
                                        {{ $initials }}
                                    </div>

                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <p class="font-bold text-xs sm:text-sm text-[#0F1E36] dark:text-white leading-snug">
                                                {{ $user->name }}
                                            </p>
                                            @if($isMe)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#FAF4E6] text-[#A66C0C] border border-[#F0E4CA]">
                                                    (Anda)
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[11px] text-[#708090] dark:text-[#9AB1C9] mt-0.5 truncate max-w-[240px]">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Peran Badge --}}
                            <td class="px-4 py-4 text-left whitespace-nowrap">
                                @if($user->role->isSuperAdmin())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#0D253F] text-white border border-[#27486E]">
                                        <svg class="w-3.5 h-3.5 text-[#E2B14C]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Super Admin</span>
                                    </span>
                                @elseif($user->role->isAdmin())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#0E7B87] text-white border border-[#0B6770]">
                                        <svg class="w-3.5 h-3.5 text-[#7CE3B3]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 100 2h.01a1 1 0 100-2H11z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Admin</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#FAF4E6] text-[#A66C0C] border border-[#F0E4CA]">
                                        <svg class="w-3.5 h-3.5 text-[#A66C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Jamaah</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Tanggal Daftar --}}
                            <td class="px-4 py-4 text-left text-xs text-[#526374] dark:text-[#9AB1C9] whitespace-nowrap">
                                {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    {{-- Delete Button with Custom Modal --}}
                                    @if($isMe || $user->role->isSuperAdmin())
                                        <span
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-[#C0CAD5] cursor-not-allowed select-none"
                                            title="Akun Super Admin atau akun sendiri tidak dapat dihapus"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </span>
                                    @else
                                        <button
                                            type="button"
                                            @click="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')"
                                            title="Hapus Pengguna"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 hover:text-red-700 transition cursor-pointer"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="max-w-md mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-[#FAF7F0] border border-[#EAE3D2] flex items-center justify-center mx-auto text-[#7A6E57]">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-[#0F1E36]">Tidak ada pengguna ditemukan</h3>
                                    <p class="text-xs text-[#6B7C8E]">
                                        Tidak ada akun pengguna yang cocok dengan kriteria pencarian atau filter peran saat ini.
                                    </p>
                                    <a
                                        href="{{ route('admin.users.index') }}"
                                        wire:navigate
                                        wire:navigate.hover
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-[#0F1E36] text-xs font-semibold hover:bg-[#F2ECE0] transition"
                                    >
                                        Bersihkan Filter
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Custom Pagination Footer (Identical to Surah & Ayat) --}}
        <div class="px-5 py-4 border-t border-[#EAE3D2] flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
            <div class="text-xs text-[#6B7C8E] font-medium">
                @if($users->total() > 0)
                    Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }} pengguna terdaftar
                @else
                    Menampilkan 0 pengguna
                @endif
            </div>

            @if($users->hasPages())
                <div class="flex items-center gap-1.5 flex-wrap">
                    {{-- Previous Page Link --}}
                    @if($users->onFirstPage())
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#C0CAD5] pointer-events-none select-none">
                            Sebelumnya
                        </span>
                    @else
                        <a
                            href="{{ $users->previousPageUrl() }}"
                            wire:navigate
                            wire:navigate.hover
                            class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#4A5B6C] hover:text-[#0B1D33] hover:bg-black/5 transition"
                            title="Halaman Sebelumnya"
                        >
                            Sebelumnya
                        </a>
                    @endif

                    {{-- Numerical Page Elements --}}
                    @php
                        $currentPage = $users->currentPage();
                        $lastPage = $users->lastPage();
                        $pageElements = [];
                        if ($lastPage <= 7) {
                            $pageElements = range(1, $lastPage);
                        } else {
                            if ($currentPage <= 2) {
                                $pageElements = [1, 2, 3, '...', $lastPage];
                            } elseif ($currentPage >= $lastPage - 1) {
                                $pageElements = [1, '...', $lastPage - 2, $lastPage - 1, $lastPage];
                            } else {
                                $pageElements = [1, '...', $currentPage - 1, $currentPage, $currentPage + 1, '...', $lastPage];
                            }
                        }
                    @endphp

                    @foreach($pageElements as $elem)
                        @if($elem === '...')
                            <span class="px-1 text-[#8C98A4] text-xs select-none">...</span>
                        @elseif($elem == $currentPage)
                            <span class="w-7 h-7 rounded-lg flex items-center justify-center bg-[#0B1D33] text-white text-xs font-bold shadow-xs">
                                {{ $elem }}
                            </span>
                        @else
                            <a
                                href="{{ $users->url($elem) }}"
                                wire:navigate
                                wire:navigate.hover
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-[#4A5B6C] hover:bg-black/5 text-xs font-medium transition"
                            >
                                {{ $elem }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if($users->hasMorePages())
                        <a
                            href="{{ $users->nextPageUrl() }}"
                            wire:navigate
                            wire:navigate.hover
                            class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#4A5B6C] hover:text-[#0B1D33] hover:bg-black/5 transition"
                        >
                            Selanjutnya
                        </a>
                    @else
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#C0CAD5] pointer-events-none select-none">
                            Selanjutnya
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus Pengguna (Custom Elegant Tailwind Modal teleported to body) --}}
    <template x-teleport="body">
        <div
            x-show="deleteModalOpen"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
            style="z-index: 9999; display: none;"
            @keydown.escape.window="deleteModalOpen = false"
        >
            <div
                @click.away="deleteModalOpen = false"
                x-show="deleteModalOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white dark:bg-[#0D213A] rounded-2xl border border-[#EAE3D2] dark:border-white/10 shadow-2xl w-full max-w-md overflow-hidden p-6 space-y-4"
            >
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#0F1E36] dark:text-white">Hapus Akun Pengguna</h3>
                        <p class="text-xs text-[#788797] dark:text-[#9AB1C9]">Tindakan ini permanen dan tidak dapat dibatalkan</p>
                    </div>
                </div>

                <p class="text-xs text-[#4A5B6C] dark:text-[#9AB1C9] leading-relaxed">
                    Apakah Anda yakin ingin menghapus akun <strong class="text-[#0F1E36] dark:text-white" x-text="userToDelete.name"></strong> (<span class="text-[#788797]" x-text="userToDelete.email"></span>) dari database Lentera Quran?
                </p>

                <form
                    method="POST"
                    :action="'{{ url('admin/pengguna') }}/' + userToDelete.id"
                    class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#EAE3D2] dark:border-white/10"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="button"
                        @click="deleteModalOpen = false"
                        class="px-4 py-2 rounded-xl border border-[#EAE3D2] dark:border-white/10 bg-white dark:bg-[#132C4B] text-xs font-semibold text-[#4A5B6C] dark:text-[#9AB1C9] hover:bg-[#FAF7F0] transition cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-xs transition cursor-pointer"
                    >
                        Ya, Hapus Akun
                    </button>
                </form>
            </div>
        </div>
    </template>
</div>
@endsection
