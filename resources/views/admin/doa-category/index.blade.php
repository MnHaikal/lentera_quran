@extends('admin.layouts.app')

@section('title', 'Kategori Doa — Super Admin Lentera Quran')

@section('topbar_title')
    <div class="flex items-center gap-2.5 flex-wrap">
        <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
            Kategori Doa
        </h1>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#FDF8EB] dark:bg-[#2B261D] text-[#A66C0C] dark:text-[#E2B14C] border border-[#F3DFC1] dark:border-white/10 shrink-0">
            Total {{ $totalCategories }} Kategori
        </span>
    </div>
@endsection

@section('content')
<div
    x-data="{
        createModalOpen: false,
        editModalOpen: false,
        editingCategory: {
            id: '',
            nama: '',
            slug: '',
            deskripsi: '',
            urutan: 1
        },
        openCreate() {
            this.createModalOpen = true;
        },
        openEdit(cat) {
            this.editingCategory = {
                id: cat.id,
                nama: cat.nama,
                slug: cat.slug,
                deskripsi: cat.deskripsi ?? '',
                urutan: cat.urutan
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

    {{-- Filter & Notice Bar Card --}}
    <div
        class="rounded-2xl bg-white border border-[#EAE3D2] p-3.5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3"
    >
        {{-- Search Input --}}
        <form
            method="GET"
            action="{{ route('admin.doa-category.index') }}"
            class="w-full sm:w-72"
        >
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#8C98A4]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari kategori doa..."
                    class="w-full pl-9 pr-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] placeholder-[#8C98A4] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:bg-white transition"
                >
            </div>
        </form>

        {{-- Notice / Drag Hint & Tambah Kategori Button --}}
        <div class="flex items-center gap-3 flex-wrap">
            <div class="flex items-center gap-1.5 text-xs text-[#6B7C8E]">
                <svg class="w-4 h-4 text-[#8C98A4] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                <span>Seret ikon handle untuk mengatur urutan susunan kategori di aplikasi publik.</span>
            </div>

            <button
                type="button"
                @click="openCreate()"
                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#E2B14C] hover:bg-[#D4A13D] text-[#0F1E36] font-bold text-xs shadow-xs transition shrink-0 cursor-pointer"
            >
                <svg class="w-3.5 h-3.5 text-[#0F1E36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Tambah Kategori</span>
            </button>
        </div>
    </div>

    {{-- Main Data Table Card --}}
    <div class="rounded-2xl bg-white border border-[#EAE3D2] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[760px]">
                <thead>
                    <tr class="border-b border-[#EAE3D2] bg-[#FFFDF7] text-[11px] font-bold text-[#4A5B6C] uppercase tracking-wider">
                        <th scope="col" class="px-4 py-4 text-center w-24">
                            Urutan
                        </th>
                        <th scope="col" class="px-5 py-4 text-left">
                            Nama Kategori
                        </th>
                        <th scope="col" class="px-4 py-4 text-left w-56">
                            Slug URL
                        </th>
                        <th scope="col" class="px-4 py-4 text-center w-36">
                            Jumlah Doa
                        </th>
                        <th scope="col" class="px-4 py-4 text-center w-24">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAE3D2] text-xs">
                    @forelse($categories as $category)
                        <tr class="hover:bg-[#FAF7F0]/60 transition group">
                            {{-- Urutan with Drag Handle --}}
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- 6-dots Drag Handle Icon --}}
                                    <span class="text-[#8C98A4] hover:text-[#0F1E36] cursor-grab select-none p-1" title="Urutan">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M7 2a2 2 0 100 4 2 2 0 000-4zm0 6a2 2 0 100 4 2 2 0 000-4zm0 6a2 2 0 100 4 2 2 0 000-4zm6-12a2 2 0 100 4 2 2 0 000-4zm0 6a2 2 0 100 4 2 2 0 000-4zm0 6a2 2 0 100 4 2 2 0 000-4z" />
                                        </svg>
                                    </span>
                                    <span class="w-7 h-7 rounded-lg bg-[#FAF4E6] border border-[#F0E4CA] text-[#78664D] text-xs font-bold flex items-center justify-center shrink-0">
                                        {{ $category->urutan }}
                                    </span>
                                </div>
                            </td>

                            {{-- Nama Kategori with Icon & Subtitle --}}
                            <td class="px-5 py-4">
                                @php
                                    $nama = $category->nama;
                                    $iconBg = match(true) {
                                        str_contains($nama, 'Harian') => 'bg-[#E5F7F8] border-[#BDE7EB] text-[#0E7B87]',
                                        str_contains($nama, 'Pagi') || str_contains($nama, 'Dzikir') => 'bg-[#FFF6E5] border-[#FDE1AC] text-[#A66C0C]',
                                        str_contains($nama, 'Perlindungan') => 'bg-[#EFF6FF] border-[#BFDBFE] text-[#2563EB]',
                                        str_contains($nama, 'Keluarga') || str_contains($nama, 'Orang Tua') => 'bg-[#FDF8EB] border-[#F3DFC1] text-[#A66C0C]',
                                        str_contains($nama, 'Kesehatan') || str_contains($nama, 'Kesembuhan') => 'bg-[#ECFDF5] border-[#A7F3D0] text-[#059669]',
                                        str_contains($nama, 'Shalat') || str_contains($nama, 'Wudhu') => 'bg-[#FAF4E6] border-[#F0E4CA] text-[#78664D]',
                                        str_contains($nama, 'Rezeki') || str_contains($nama, 'Hutang') => 'bg-[#F1F5F9] border-[#CBD5E1] text-[#475569]',
                                        default => 'bg-[#FAF4E6] border-[#F0E4CA] text-[#78664D]',
                                    };
                                @endphp
                                <div class="flex items-center gap-3">
                                    {{-- Themed Icon Box --}}
                                    <div class="w-9 h-9 rounded-xl border flex items-center justify-center shrink-0 {{ $iconBg }}">
                                        @if(str_contains($nama, 'Harian'))
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                            </svg>
                                        @elseif(str_contains($nama, 'Pagi') || str_contains($nama, 'Dzikir'))
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        @elseif(str_contains($nama, 'Perlindungan'))
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                            </svg>
                                        @elseif(str_contains($nama, 'Keluarga') || str_contains($nama, 'Orang Tua'))
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                        @elseif(str_contains($nama, 'Kesehatan') || str_contains($nama, 'Kesembuhan'))
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                        @elseif(str_contains($nama, 'Shalat') || str_contains($nama, 'Wudhu'))
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.333A48.667 48.667 0 0012 9.75c-2.551 0-5.056.2-7.5.583V21" />
                                            </svg>
                                        @elseif(str_contains($nama, 'Rezeki') || str_contains($nama, 'Hutang'))
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-bold text-xs sm:text-sm text-[#0F1E36] leading-snug">
                                            {{ $category->nama }}
                                        </p>
                                        <p class="text-[11px] text-[#708090] mt-0.5 line-clamp-1">
                                            {{ $category->deskripsi ?? 'Pengelompokan doa sesuai konteks dan tema' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Slug URL --}}
                            <td class="px-4 py-4 text-left">
                                <span class="text-xs text-[#708090] font-mono block truncate max-w-[200px]" title="/doa/{{ $category->slug }}">
                                    /doa/{{ $category->slug }}
                                </span>
                            </td>

                            {{-- Jumlah Doa --}}
                            <td class="px-4 py-4 text-center">
                                @if($category->doas_count > 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-[#E5F7F8] text-[#0E7B87] border border-[#BDE7EB]">
                                        {{ $category->doas_count }} Doa
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-[#FAF4E6] text-[#78664D] border border-[#F0E4CA]">
                                        0 Doa
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Edit Button --}}
                                    <button
                                        type="button"
                                        @click="openEdit({{ json_encode($category) }})"
                                        title="Edit Kategori"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center text-[#187581] hover:bg-[#EAF6F7] transition cursor-pointer"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>

                                    {{-- Delete Button --}}
                                    @if($category->doas_count > 0)
                                        <span
                                            class="w-7 h-7 rounded-lg flex items-center justify-center text-[#C0CAD5] cursor-not-allowed select-none"
                                            title="Kategori yang memuat doa tidak dapat dihapus"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </span>
                                    @else
                                        <form
                                            action="{{ route('admin.doa-category.destroy', $category->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori kosong ini?');"
                                            class="inline"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                title="Hapus Kategori Kosong"
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
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-[#0F1E36]">Tidak ada kategori ditemukan</h3>
                                    <p class="text-xs text-[#6B7C8E]">
                                        Tidak ada kategori doa yang cocok dengan filter pencarian saat ini.
                                    </p>
                                    <a
                                        href="{{ route('admin.doa-category.index') }}"
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

        {{-- Custom Pagination Footer (Matching Mockup: Menampilkan 7 dari 12 kategori terdaftar) --}}
        <div class="px-5 py-4 border-t border-[#EAE3D2] flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
            <div class="text-xs text-[#6B7C8E] font-medium">
                @if($categories->total() > 0)
                    Menampilkan {{ $categories->count() }} dari {{ $categories->total() }} kategori terdaftar
                @else
                    Menampilkan 0 kategori
                @endif
            </div>

            @if($categories->hasPages())
                <div class="flex items-center gap-1.5 flex-wrap">
                    {{-- Previous Link --}}
                    @if($categories->onFirstPage())
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#C0CAD5] pointer-events-none select-none">
                            Sebelumnya
                        </span>
                    @else
                        <a
                            href="{{ $categories->previousPageUrl() }}"
                            wire:navigate
                            wire:navigate.hover
                            class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#4A5B6C] hover:text-[#0B1D33] hover:bg-black/5 transition"
                        >
                            Sebelumnya
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach(range(1, $categories->lastPage()) as $page)
                        @if($page == $categories->currentPage())
                            <span class="w-7 h-7 rounded-lg flex items-center justify-center bg-[#0B1D33] text-white text-xs font-bold shadow-xs">
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $categories->url($page) }}"
                                wire:navigate
                                wire:navigate.hover
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-[#4A5B6C] hover:bg-black/5 text-xs font-medium transition"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Link --}}
                    @if($categories->hasMorePages())
                        <a
                            href="{{ $categories->nextPageUrl() }}"
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

    {{-- Modal Tambah Kategori --}}
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
                    <h3 class="text-base font-bold text-[#0F1E36]">Tambah Kategori Doa</h3>
                    <p class="text-xs text-[#6B7C8E]">Kelompokkan kumpulan doa baru untuk jamaah</p>
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
                action="{{ route('admin.doa-category.store') }}"
                method="POST"
                class="p-6 space-y-4"
            >
                @csrf

                {{-- Nama Kategori --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama"
                        required
                        maxlength="100"
                        placeholder="Contoh: Doa Rezeki & Pelunas Hutang"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                </div>

                {{-- Deskripsi / Subtitle --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Deskripsi / Subtitle
                    </label>
                    <textarea
                        name="deskripsi"
                        rows="2"
                        maxlength="255"
                        placeholder="Contoh: Doa kemudahan urusan, rezeki berkah, dan kelapangan rezeki"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    ></textarea>
                </div>

                {{-- Urutan --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Nomor Urutan Tampilan
                    </label>
                    <input
                        type="number"
                        name="urutan"
                        min="1"
                        value="{{ $totalCategories + 1 }}"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                    <p class="text-[11px] text-[#8C98A4] mt-1">
                        Menentukan posisi urutan kategori saat ditampilkan di aplikasi jamaah.
                    </p>
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
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Kategori --}}
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
                    <h3 class="text-base font-bold text-[#0F1E36] flex items-center gap-2">
                        <span>Edit Kategori Doa</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#FAF4E6] text-[#78664D] border border-[#F0E4CA]" x-text="'Urutan ' + editingCategory.urutan"></span>
                    </h3>
                    <p class="text-xs text-[#6B7C8E]">Perbarui nama, deskripsi, atau urutan susunan kategori</p>
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
                :action="'{{ url('admin/kategori-doa') }}/' + editingCategory.id"
                method="POST"
                class="p-6 space-y-4"
            >
                @csrf
                @method('PUT')

                {{-- Nama Kategori --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama"
                        x-model="editingCategory.nama"
                        required
                        maxlength="100"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                </div>

                {{-- Deskripsi / Subtitle --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Deskripsi / Subtitle
                    </label>
                    <textarea
                        name="deskripsi"
                        x-model="editingCategory.deskripsi"
                        rows="2"
                        maxlength="255"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    ></textarea>
                </div>

                {{-- Urutan & Slug URL Preview --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                            Nomor Urutan <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="urutan"
                            x-model="editingCategory.urutan"
                            required
                            min="1"
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                            Slug URL Publik
                        </label>
                        <input
                            type="text"
                            :value="'/doa/' + editingCategory.slug"
                            disabled
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] bg-slate-100 text-slate-500 font-mono"
                        >
                    </div>
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

