@extends('admin.layouts.app')

@section('title', 'Kelola Pengguna & Peran — Super Admin Lentera Quran')

@section('topbar_title')
    <div class="flex items-center gap-2.5 flex-wrap">
        <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
            Kelola Pengguna &amp; Peran
        </h1>
        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#0D253F] dark:bg-[#071526] text-[#D9A94A] border border-[#27486E] dark:border-white/10 shrink-0">
            <svg class="w-3.5 h-3.5 text-[#D9A94A]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944z" clip-rule="evenodd" />
            </svg>
            <span>Khusus Super Admin</span>
        </span>
    </div>
@endsection

@section('content')
<div
    x-data="{
        createModalOpen: false,
        editModalOpen: false,
        filterAdvancedOpen: false,
        editingUser: {
            id: '',
            name: '',
            email: '',
            role: 'user',
            is_verified: true,
            password: ''
        },
        openCreate() {
            this.createModalOpen = true;
        },
        openEdit(user) {
            this.editingUser = {
                id: user.id,
                name: user.name,
                email: user.email,
                role: typeof user.role === 'object' && user.role !== null ? user.role.value : user.role,
                is_verified: Boolean(user.email_verified_at),
                password: ''
            };
            this.editModalOpen = true;
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

    {{-- Filter & Search Card --}}
    <div
        class="rounded-2xl bg-white border border-[#EAE3D2] p-3.5 shadow-xs"
    >
        <form
            method="GET"
            action="{{ route('admin.users.index') }}"
            class="flex flex-col md:flex-row md:items-center justify-between gap-3"
        >
            <div class="flex flex-wrap items-center gap-2.5 flex-1">
                {{-- Search Box --}}
                <div class="relative w-full sm:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#8C98A4]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari nama atau email..."
                        class="w-full pl-9 pr-3.5 py-2 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] text-[#0F1E36] placeholder-[#8C98A4] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:bg-white transition"
                    >
                </div>

                {{-- Dropdown Peran --}}
                <select
                    name="peran"
                    onchange="this.form.submit()"
                    class="py-2 pl-3 pr-8 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] text-[#0F1E36] font-semibold focus:outline-none focus:ring-1 focus:ring-[#0E7B87] transition cursor-pointer hover:bg-[#F2ECE0]"
                >
                    <option value="">Semua Peran</option>
                    <option value="super_admin" {{ request('peran') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ request('peran') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('peran') === 'user' ? 'selected' : '' }}>User</option>
                </select>

                {{-- Dropdown Status Email --}}
                <select
                    name="status_email"
                    onchange="this.form.submit()"
                    class="py-2 pl-3 pr-8 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] text-[#0F1E36] font-semibold focus:outline-none focus:ring-1 focus:ring-[#0E7B87] transition cursor-pointer hover:bg-[#F2ECE0]"
                >
                    <option value="">Status Email</option>
                    <option value="terverifikasi" {{ request('status_email') === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="belum" {{ request('status_email') === 'belum' ? 'selected' : '' }}>Belum Verifikasi</option>
                </select>

                {{-- Reset Filter Button --}}
                @if(request()->filled('q') || request()->filled('peran') || request()->filled('status_email'))
                    <a
                        href="{{ route('admin.users.index') }}"
                        wire:navigate
                        wire:navigate.hover
                        title="Reset Filter"
                        class="p-2 rounded-xl text-xs font-semibold text-[#8C98A4] hover:text-[#D9383A] hover:bg-red-50 transition"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>

            {{-- Right Buttons: Filter Lanjutan & Tambah Pengguna --}}
            <div class="flex items-center gap-2 self-start md:self-center shrink-0 flex-wrap">
                <button
                    type="button"
                    @click="filterAdvancedOpen = !filterAdvancedOpen"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-[#EAE3D2] text-[#4A5B6C] bg-[#FAF7F0] hover:bg-[#F2ECE0] text-xs font-semibold transition shrink-0 cursor-pointer"
                >
                    <svg class="w-4 h-4 text-[#4A5B6C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    <span>Filter Lanjutan</span>
                </button>

                <button
                    type="button"
                    @click="openCreate()"
                    class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#E2B14C] hover:bg-[#D4A13D] text-[#0F1E36] font-bold text-xs shadow-xs transition shrink-0 cursor-pointer"
                >
                    <svg class="w-3.5 h-3.5 text-[#0F1E36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span>Tambah Pengguna</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Main Data Table Card --}}
    <div class="rounded-2xl bg-white border border-[#EAE3D2] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[850px]">
                <thead>
                    <tr class="border-b border-[#EAE3D2] bg-[#FFFDF7] text-[11px] font-bold text-[#4A5B6C] uppercase tracking-wider">
                        <th scope="col" class="px-5 py-4 text-left">
                            Pengguna
                        </th>
                        <th scope="col" class="px-4 py-4 text-left w-40">
                            Peran
                        </th>
                        <th scope="col" class="px-4 py-4 text-left w-44">
                            Email Terverifikasi
                        </th>
                        <th scope="col" class="px-4 py-4 text-left w-40">
                            Tanggal Daftar
                        </th>
                        <th scope="col" class="px-4 py-4 text-center w-36">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAE3D2] text-xs">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#FAF7F0]/60 transition group">
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
                                            <p class="font-bold text-xs sm:text-sm text-[#0F1E36] leading-snug">
                                                {{ $user->name }}
                                            </p>
                                            @if($isMe)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#FAF4E6] text-[#A66C0C] border border-[#F0E4CA]">
                                                    (Anda)
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-[11px] text-[#708090] mt-0.5 truncate max-w-[240px]">
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
                                        <span>User</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Email Terverifikasi --}}
                            <td class="px-4 py-4 text-left whitespace-nowrap">
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#E5F7F0] text-[#0D8A58] border border-[#BCE8D5]">
                                        <svg class="w-3.5 h-3.5 text-[#0D8A58]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Terverifikasi</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#FFF6E5] text-[#D97706] border border-[#FDE1AC]">
                                        <svg class="w-3.5 h-3.5 text-[#D97706]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                        <span>Belum</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Tanggal Daftar --}}
                            <td class="px-4 py-4 text-left text-xs text-[#526374] whitespace-nowrap">
                                {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Ubah Peran Button --}}
                                    <button
                                        type="button"
                                        @click="openEdit({{ json_encode($user) }})"
                                        class="px-3.5 py-1 rounded-full border border-[#0E7B87] text-[#0E7B87] hover:bg-[#E5F7F8] text-xs font-semibold transition cursor-pointer"
                                    >
                                        Ubah Peran
                                    </button>

                                    {{-- Delete Button --}}
                                    @if($isMe || $user->role->isSuperAdmin())
                                        <span
                                            class="w-7 h-7 rounded-lg flex items-center justify-center text-[#C0CAD5] cursor-not-allowed select-none"
                                            title="Akun Super Admin atau akun sendiri tidak dapat dihapus"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </span>
                                    @else
                                        <form
                                            action="{{ route('admin.users.destroy', $user->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?');"
                                            class="inline"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                title="Hapus Pengguna"
                                                class="w-7 h-7 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 hover:text-red-700 transition cursor-pointer"
                                            >
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="max-w-md mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-[#FAF7F0] border border-[#EAE3D2] flex items-center justify-center mx-auto text-[#7A6E57]">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-[#0F1E36]">Tidak ada pengguna ditemukan</h3>
                                    <p class="text-xs text-[#6B7C8E]">
                                        Tidak ada akun pengguna yang cocok dengan kriteria pencarian atau filter saat ini.
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

        {{-- Custom Pagination Footer (Matching Mockup with 5 items per page) --}}
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
                    {{-- Previous Link --}}
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
                        >
                            Sebelumnya
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach(range(1, $users->lastPage()) as $page)
                        @if($page == $users->currentPage())
                            <span class="w-7 h-7 rounded-lg flex items-center justify-center bg-[#0B1D33] text-white text-xs font-bold shadow-xs">
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $users->url($page) }}"
                                wire:navigate
                                wire:navigate.hover
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-[#4A5B6C] hover:bg-black/5 text-xs font-medium transition"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Link --}}
                    @if($users->hasMorePages())
                        <a
                            href="{{ $users->nextPageUrl() }}"
                            wire:navigate
                            wire:navigate.hover
                            class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#4A5B6C] hover:text-[#0B1D33] hover:bg-black/5 transition"
                        >
                            Berikutnya
                        </a>
                    @else
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#C0CAD5] pointer-events-none select-none">
                            Berikutnya
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Tambah Pengguna --}}
    <div
        x-show="createModalOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4"
        style="display: none;"
    >
        <div
            @click.away="createModalOpen = false"
            x-show="createModalOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="bg-white rounded-2xl max-w-lg w-full border border-[#EAE3D2] shadow-xl overflow-hidden my-6"
        >
            <div class="px-6 py-4 bg-[#FAF7F0] border-b border-[#EAE3D2] flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-[#0F1E36]">Tambah Pengguna Baru</h3>
                    <p class="text-xs text-[#6B7C8E]">Buat akun jamaah, kurator admin, atau Super Admin</p>
                </div>
                <button
                    type="button"
                    @click="createModalOpen = false"
                    class="text-[#8C98A4] hover:text-[#0F1E36] transition p-1"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form
                action="{{ route('admin.users.store') }}"
                method="POST"
                class="p-6 space-y-4"
            >
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        required
                        maxlength="100"
                        placeholder="Contoh: Ustadz Fauzi Ahmad"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                </div>

                {{-- Alamat Email --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        required
                        maxlength="150"
                        placeholder="nama@email.com"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                </div>

                {{-- Peran Pengguna --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Peran Akun <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="role"
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] bg-white focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                        <option value="user">User (Jamaah Pengguna)</option>
                        <option value="admin">Admin (Kurator Konten)</option>
                        <option value="super_admin">Super Admin (Administrator Penuh)</option>
                    </select>
                </div>

                {{-- Kata Sandi & Konfirmasi --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                            Kata Sandi <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            required
                            minlength="8"
                            placeholder="Minimal 8 karakter"
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                            Konfirmasi Sandi <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            minlength="8"
                            placeholder="Ulangi kata sandi"
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                        >
                    </div>
                </div>

                {{-- Email Langsung Terverifikasi --}}
                <div class="flex items-center gap-2 pt-1">
                    <input
                        type="checkbox"
                        name="is_verified"
                        value="1"
                        id="create_is_verified"
                        checked
                        class="w-4 h-4 rounded text-[#0E7B87] border-[#E5DEC9] focus:ring-[#0E7B87]"
                    >
                    <label for="create_is_verified" class="text-xs font-semibold text-[#1E2B3A] cursor-pointer">
                        Tandai alamat email langsung terverifikasi
                    </label>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-3 border-t border-[#EAE3D2] flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        @click="createModalOpen = false"
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-[#4A5B6C] hover:bg-black/5 transition"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 rounded-xl text-xs font-bold bg-[#F3C465] hover:bg-[#E8B854] text-[#4A3205] transition shadow-xs"
                    >
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Ubah Peran Pengguna --}}
    <div
        x-show="editModalOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/50 backdrop-blur-xs flex items-center justify-center p-4"
        style="display: none;"
    >
        <div
            @click.away="editModalOpen = false"
            x-show="editModalOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="bg-white rounded-2xl max-w-lg w-full border border-[#EAE3D2] shadow-xl overflow-hidden my-6"
        >
            <div class="px-6 py-4 bg-[#FAF7F0] border-b border-[#EAE3D2] flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-[#0F1E36]">Ubah Peran &amp; Hak Akses</h3>
                    <p class="text-xs text-[#6B7C8E]">Sesuaikan wewenang kurator atau administrator</p>
                </div>
                <button
                    type="button"
                    @click="editModalOpen = false"
                    class="text-[#8C98A4] hover:text-[#0F1E36] transition p-1"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form
                :action="'{{ url('admin/pengguna') }}/' + editingUser.id"
                method="POST"
                class="p-6 space-y-4"
            >
                @csrf
                @method('PUT')

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        x-model="editingUser.name"
                        required
                        maxlength="100"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                </div>

                {{-- Alamat Email --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        x-model="editingUser.email"
                        required
                        maxlength="150"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                </div>

                {{-- Pilihan Peran --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Pilih Peran Akun <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="role"
                        x-model="editingUser.role"
                        required
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] bg-white focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                        <option value="user">User (Jamaah Pengguna)</option>
                        <option value="admin">Admin (Kurator Konten)</option>
                        <option value="super_admin">Super Admin (Administrator Penuh)</option>
                    </select>
                </div>

                {{-- Status Verifikasi Email --}}
                <div class="flex items-center gap-2 pt-1">
                    <input
                        type="checkbox"
                        name="is_verified"
                        value="1"
                        id="edit_is_verified"
                        x-model="editingUser.is_verified"
                        class="w-4 h-4 rounded text-[#0E7B87] border-[#E5DEC9] focus:ring-[#0E7B87]"
                    >
                    <label for="edit_is_verified" class="text-xs font-semibold text-[#1E2B3A] cursor-pointer">
                        Email akun telah terverifikasi
                    </label>
                </div>

                {{-- Ubah Kata Sandi (Opsional) --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Ganti Kata Sandi (Opsional)
                    </label>
                    <input
                        type="password"
                        name="password"
                        x-model="editingUser.password"
                        minlength="8"
                        placeholder="Kosongkan jika tidak ingin mengubah sandi"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                </div>

                {{-- Action Buttons --}}
                <div class="pt-3 border-t border-[#EAE3D2] flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        @click="editModalOpen = false"
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-[#4A5B6C] hover:bg-black/5 transition"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 rounded-xl text-xs font-bold bg-[#0F2D4F] hover:bg-[#153B66] text-white transition shadow-sm"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

