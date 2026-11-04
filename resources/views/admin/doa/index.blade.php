@extends('admin.layouts.app')

@section('title', 'Kumpulan Doa — Super Admin Lentera Quran')

@section('topbar_title')
    <div class="flex items-center gap-2.5 flex-wrap">
        <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
            Kumpulan Doa
        </h1>
    </div>
@endsection

@section('content')
<div
    x-data="{
        createModalOpen: false,
        editModalOpen: false,
        editingDoa: {
            id: '',
            doa_category_id: '',
            judul: '',
            teks_arab: '',
            teks_latin: '',
            terjemahan: '',
            sumber: '',
            is_published: true
        },
        openCreate() {
            this.createModalOpen = true;
        },
        openEdit(doa) {
            this.editingDoa = {
                id: doa.id,
                doa_category_id: doa.doa_category_id,
                judul: doa.judul,
                teks_arab: doa.teks_arab,
                teks_latin: doa.teks_latin,
                terjemahan: doa.terjemahan,
                sumber: doa.sumber ?? '',
                is_published: Boolean(doa.is_published)
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
        class="rounded-2xl bg-white dark:bg-[#0D213A] border border-[#EAE3D2] dark:border-white/10 p-3.5 shadow-xs"
    >
        <form
            method="GET"
            action="{{ route('admin.doa.index') }}"
            class="flex flex-col lg:flex-row lg:items-center justify-between gap-3"
        >
            {{-- Filter Fields Group --}}
            <div class="flex flex-wrap items-center gap-2.5 flex-1">
                {{-- Search Box --}}
                <div class="relative w-full sm:w-64 lg:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#8C98A4]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari judul doa..."
                        class="w-full pl-9 pr-3.5 py-2 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] dark:bg-[#132C4B] text-[#0F1E36] dark:text-white placeholder-[#8C98A4] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:bg-white transition"
                    >
                </div>

                {{-- Dropdown Kategori --}}
                <select
                    name="kategori"
                    onchange="this.form.submit()"
                    class="py-2 pl-3 pr-8 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] dark:bg-[#132C4B] text-[#0F1E36] dark:text-white font-semibold focus:outline-none focus:ring-1 focus:ring-[#0E7B87] cursor-pointer hover:bg-[#F2ECE0] transition"
                >
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ (string) request('kategori') === (string) $category->id || request('kategori') === $category->slug ? 'selected' : '' }}
                        >
                            {{ $category->nama }}
                        </option>
                    @endforeach
                </select>

                {{-- Dropdown Status --}}
                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="py-2 pl-3 pr-8 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] dark:bg-[#132C4B] text-[#0F1E36] dark:text-white font-semibold focus:outline-none focus:ring-1 focus:ring-[#0E7B87] cursor-pointer hover:bg-[#F2ECE0] transition"
                >
                    <option value="">Semua Status</option>
                    <option value="terbit" {{ request('status') === 'terbit' ? 'selected' : '' }}>Terbit</option>
                    <option value="draf" {{ request('status') === 'draf' ? 'selected' : '' }}>Draf</option>
                </select>

                {{-- Clear Filters if active --}}
                @if(request()->filled('q') || request()->filled('kategori') || request()->filled('status'))
                    <a
                        href="{{ route('admin.doa.index') }}"
                        wire:navigate
                        wire:navigate.hover
                        title="Reset Filter"
                        class="w-8 h-8 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] flex items-center justify-center text-[#4A5B6C] hover:text-[#D9383A] hover:bg-red-50 transition"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                @endif
            </div>

            {{-- Right Buttons: Total Badge, Ekspor Data & Tambah Doa --}}
            <div class="flex items-center gap-2 self-start lg:self-center shrink-0 flex-wrap">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#F5EFE6] dark:bg-[#1C2C3E] text-[#78664D] dark:text-[#E2B14C] text-xs font-semibold border border-[#E8DFC8] dark:border-white/10">
                    <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                    <span>Total {{ $totalDoa ?? ($doas->total() ?? 0) }} Doa</span>
                </span>

                <a
                    href="{{ route('admin.doa.export') }}"
                    title="Unduh data doa format CSV/Excel"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-[#EAE3D2] dark:border-white/10 bg-[#FAF7F0] dark:bg-[#1C2C3E] hover:bg-[#F2ECE0] text-[#4A5B6C] dark:text-[#9AB1C9] text-xs font-semibold transition shadow-2xs"
                >
                    <svg class="w-3.5 h-3.5 text-[#788797]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M7.5 12L12 16.5m0 0L16.5 12M12 16.5V3" />
                    </svg>
                    <span>Ekspor Data</span>
                </a>

                <button
                    type="button"
                    @click="openCreate()"
                    class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#E2B14C] hover:bg-[#D4A13D] text-[#0F1E36] font-bold text-xs shadow-xs transition shrink-0 cursor-pointer"
                >
                    <svg class="w-3.5 h-3.5 text-[#0F1E36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Tambah Doa</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Main Data Table Card --}}
    <div class="rounded-2xl bg-white border border-[#EAE3D2] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[950px]">
                <thead>
                    <tr class="border-b border-[#EAE3D2] bg-[#FFFDF7] text-[11px] font-bold text-[#4A5B6C] uppercase tracking-wider">
                        <th scope="col" class="px-5 py-4 text-left">
                            Judul Doa
                        </th>
                        <th scope="col" class="px-4 py-4 text-left w-36">
                            Kategori
                        </th>
                        <th scope="col" class="px-4 py-4 text-center">
                            Cuplikan Arab
                        </th>
                        <th scope="col" class="px-4 py-4 text-left w-44">
                            Sumber / Dalil
                        </th>
                        <th scope="col" class="px-4 py-4 text-center w-24">
                            Status
                        </th>
                        <th scope="col" class="px-4 py-4 text-center w-36">
                            Terakhir Diperbarui
                        </th>
                        <th scope="col" class="px-4 py-4 text-center w-24">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAE3D2] text-xs">
                    @forelse($doas as $doa)
                        <tr class="hover:bg-[#FAF7F0]/60 transition group">
                            {{-- Judul Doa with Code Tag --}}
                            <td class="px-5 py-4">
                                <div class="flex items-start gap-2.5">
                                    <span class="px-2 py-1 rounded-md bg-[#FAF4E6] border border-[#F0E4CA] text-[#78664D] text-[10px] font-bold shrink-0 tracking-wide mt-0.5">
                                        #DOA-{{ str_pad((string) $doa->id, 3, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="font-bold text-xs text-[#0F1E36] leading-snug">
                                            {{ $doa->judul }}
                                        </p>
                                        <p class="text-[11px] text-[#708090] mt-0.5 line-clamp-2">
                                            {{ Str::limit($doa->terjemahan, 65) }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="px-4 py-4 text-left">
                                @php
                                    $catName = $doa->doaCategory?->nama ?? 'Umum';
                                    $badgeStyle = match(true) {
                                        str_contains($catName, 'Shalat') || str_contains($catName, 'Ibadah') => 'bg-[#EEF2FF] text-[#4F46E5] border-[#E0E7FF]',
                                        str_contains($catName, 'Harian') => 'bg-[#E5F7F8] text-[#0E7B87] border-[#BDE7EB]',
                                        str_contains($catName, 'Perlindungan') || str_contains($catName, 'Iman') => 'bg-[#FFF6E5] text-[#A66C0C] border-[#FDE1AC]',
                                        str_contains($catName, 'Keluarga') || str_contains($catName, 'Orang Tua') => 'bg-[#F3E8FF] text-[#7E22CE] border-[#E9D5FF]',
                                        str_contains($catName, 'Kesehatan') => 'bg-[#ECFDF5] text-[#059669] border-[#A7F3D0]',
                                        str_contains($catName, 'Pagi') || str_contains($catName, 'Dzikir') => 'bg-[#E5F7F0] text-[#0D8A58] border-[#BCE8D5]',
                                        str_contains($catName, 'Ilmu') => 'bg-[#EFF6FF] text-[#2563EB] border-[#BFDBFE]',
                                        default => 'bg-[#F5EFE6] text-[#78664D] border-[#E8DFC8]',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $badgeStyle }}">
                                    {{ $catName }}
                                </span>
                            </td>

                            {{-- Cuplikan Arab --}}
                            <td class="px-4 py-4 text-center">
                                <span class="font-arabic text-base sm:text-lg font-bold text-[#0F1E36] leading-relaxed block dir-rtl mx-auto max-w-[280px]">
                                    {{ Str::limit($doa->teks_arab, 70) }}
                                </span>
                            </td>

                            {{-- Sumber / Dalil --}}
                            <td class="px-4 py-4 text-left text-xs text-[#526374]">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#8C98A4] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    <span class="truncate max-w-[150px]" title="{{ $doa->sumber ?? 'Al-Qur\'an / Hadits' }}">
                                        {{ $doa->sumber ?? 'Al-Qur\'an / Hadits' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4 text-center whitespace-nowrap">
                                @if($doa->is_published)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#E5F7F8] text-[#0E7B87] border border-[#BDE7EB]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>
                                        <span>Terbit</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#FFF6E5] text-[#D97706] border border-[#FDE1AC]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#F59E0B]"></span>
                                        <span>Draf</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Terakhir Diperbarui --}}
                            <td class="px-4 py-4 text-center text-xs text-[#708090] whitespace-nowrap">
                                {{ $doa->updated_at ? $doa->updated_at->translatedFormat('d M Y') : '18 Mei 2025' }}
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    {{-- Pratinjau Publik --}}
                                    <a
                                        href="{{ route('doa.show', $doa->slug) }}"
                                        target="_blank"
                                        title="Pratinjau Doa di Web Publik"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center text-[#187581] hover:bg-[#EAF6F7] transition"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>

                                    {{-- Edit Button --}}
                                    <button
                                        type="button"
                                        @click="openEdit({{ json_encode($doa) }})"
                                        title="Edit &amp; Kurasi Doa"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center text-[#A66C0C] hover:bg-[#FFF6E5] transition cursor-pointer"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>

                                    {{-- Hapus Button --}}
                                    <form
                                        action="{{ route('admin.doa.destroy', $doa->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus doa ini?');"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            title="Hapus Doa"
                                            class="w-7 h-7 rounded-lg flex items-center justify-center text-red-500 hover:bg-red-50 hover:text-red-700 transition cursor-pointer"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="max-w-md mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-[#FAF7F0] border border-[#EAE3D2] flex items-center justify-center mx-auto text-[#7A6E57]">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-[#0F1E36]">Tidak ada doa ditemukan</h3>
                                    <p class="text-xs text-[#6B7C8E]">
                                        Tidak ada doa yang cocok dengan filter pencarian saat ini. Silakan ubah filter atau kata kunci.
                                    </p>
                                    <a
                                        href="{{ route('admin.doa.index') }}"
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

        {{-- Custom Pagination Footer (Matching Mockup with 7 items per page) --}}
        <div class="px-5 py-4 border-t border-[#EAE3D2] flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
            <div class="text-xs text-[#6B7C8E] font-medium">
                @if($doas->total() > 0)
                    Menampilkan {{ $doas->firstItem() }}-{{ $doas->lastItem() }} dari {{ $doas->total() }} doa
                @else
                    Menampilkan 0 doa
                @endif
            </div>

            @if($doas->hasPages())
                <div class="flex items-center gap-1.5 flex-wrap">
                    {{-- Previous Link --}}
                    @if($doas->onFirstPage())
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#C0CAD5] pointer-events-none select-none inline-flex items-center gap-1">
                            <span>&lt; Sebelumnya</span>
                        </span>
                    @else
                        <a
                            href="{{ $doas->previousPageUrl() }}"
                            wire:navigate
                            wire:navigate.hover
                            class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#4A5B6C] hover:text-[#0B1D33] hover:bg-black/5 transition inline-flex items-center gap-1"
                            title="Halaman Sebelumnya"
                        >
                            <span>&lt; Sebelumnya</span>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @php
                        $currentPage = $doas->currentPage();
                        $lastPage = $doas->lastPage();
                        $pageElements = [];
                        if ($lastPage <= 7) {
                            $pageElements = range(1, $lastPage);
                        } else {
                            if ($currentPage <= 3) {
                                $pageElements = [1, 2, 3, 4, '...', $lastPage];
                            } elseif ($currentPage >= $lastPage - 2) {
                                $pageElements = [1, '...', $lastPage - 3, $lastPage - 2, $lastPage - 1, $lastPage];
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
                                href="{{ $doas->url($elem) }}"
                                wire:navigate
                                wire:navigate.hover
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-[#4A5B6C] hover:bg-black/5 text-xs font-medium transition"
                            >
                                {{ $elem }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Link --}}
                    @if($doas->hasMorePages())
                        <a
                            href="{{ $doas->nextPageUrl() }}"
                            wire:navigate
                            wire:navigate.hover
                            class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#4A5B6C] hover:text-[#0B1D33] hover:bg-black/5 transition inline-flex items-center gap-1"
                        >
                            <span>Berikutnya &gt;</span>
                        </a>
                    @else
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#C0CAD5] pointer-events-none select-none inline-flex items-center gap-1">
                            <span>Berikutnya &gt;</span>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Tambah Doa --}}
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
            class="bg-white rounded-2xl max-w-xl w-full border border-[#EAE3D2] shadow-xl overflow-hidden my-6"
        >
            <div class="px-6 py-4 bg-[#FAF7F0] border-b border-[#EAE3D2] flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-[#0F1E36]">Tambah Doa Baru</h3>
                    <p class="text-xs text-[#6B7C8E]">Lengkapi rincian doa sesuai sumber shahih dan standar Kemenag RI</p>
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
                action="{{ route('admin.doa.store') }}"
                method="POST"
                class="p-6 space-y-4 max-h-[80vh] overflow-y-auto"
            >
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Kategori --}}
                    <div>
                        <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                            Kategori Doa <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="doa_category_id"
                            required
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] bg-white focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                        >
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sumber / Dalil --}}
                    <div>
                        <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                            Sumber / Dalil
                        </label>
                        <input
                            type="text"
                            name="sumber"
                            placeholder="Contoh: HR. Bukhari no. 6306"
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                        >
                    </div>
                </div>

                {{-- Judul Doa --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Judul Doa <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="judul"
                        required
                        maxlength="150"
                        placeholder="Contoh: Sayyidul Istighfar"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                </div>

                {{-- Teks Arab --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Teks Arab <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="teks_arab"
                        required
                        rows="3"
                        dir="rtl"
                        placeholder="اَللّٰهُمَّ..."
                        class="w-full px-3.5 py-2 text-sm font-arabic font-bold rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    ></textarea>
                </div>

                {{-- Teks Latin --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Teks Transliterasi Latin <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="teks_latin"
                        required
                        rows="2"
                        placeholder="Allāhumma anta rabbī..."
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    ></textarea>
                </div>

                {{-- Terjemahan --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Arti / Terjemahan Bahasa Indonesia <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="terjemahan"
                        required
                        rows="3"
                        placeholder="Ya Allah, Engkaulah Tuhanku..."
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    ></textarea>
                </div>

                {{-- Status Publikasi --}}
                <div class="flex items-center gap-2 pt-1">
                    <input
                        type="checkbox"
                        name="is_published"
                        value="1"
                        id="create_is_published"
                        checked
                        class="w-4 h-4 rounded text-[#0E7B87] border-[#E5DEC9] focus:ring-[#0E7B87]"
                    >
                    <label for="create_is_published" class="text-xs font-semibold text-[#1E2B3A] cursor-pointer">
                        Terbitkan langsung doa ini agar dapat diakses oleh publik
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
                        Simpan Doa
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Doa --}}
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
            class="bg-white rounded-2xl max-w-xl w-full border border-[#EAE3D2] shadow-xl overflow-hidden my-6"
        >
            <div class="px-6 py-4 bg-[#FAF7F0] border-b border-[#EAE3D2] flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-[#0F1E36] flex items-center gap-2">
                        <span>Edit &amp; Kurasi Doa</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#FAF4E6] text-[#78664D] border border-[#F0E4CA]" x-text="'#DOA-' + String(editingDoa.id).padStart(3, '0')"></span>
                    </h3>
                    <p class="text-xs text-[#6B7C8E]">Perbarui redaksi, sumber dalil, atau status terbit</p>
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
                :action="'{{ url('admin/doa') }}/' + editingDoa.id"
                method="POST"
                class="p-6 space-y-4 max-h-[80vh] overflow-y-auto"
            >
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Kategori --}}
                    <div>
                        <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                            Kategori Doa <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="doa_category_id"
                            x-model="editingDoa.doa_category_id"
                            required
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] bg-white focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                        >
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sumber / Dalil --}}
                    <div>
                        <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                            Sumber / Dalil
                        </label>
                        <input
                            type="text"
                            name="sumber"
                            x-model="editingDoa.sumber"
                            class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                        >
                    </div>
                </div>

                {{-- Judul Doa --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Judul Doa <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="judul"
                        x-model="editingDoa.judul"
                        required
                        maxlength="150"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    >
                </div>

                {{-- Teks Arab --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Teks Arab <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="teks_arab"
                        x-model="editingDoa.teks_arab"
                        required
                        rows="3"
                        dir="rtl"
                        class="w-full px-3.5 py-2 text-sm font-arabic font-bold rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    ></textarea>
                </div>

                {{-- Teks Latin --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Teks Transliterasi Latin <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="teks_latin"
                        x-model="editingDoa.teks_latin"
                        required
                        rows="2"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    ></textarea>
                </div>

                {{-- Terjemahan --}}
                <div>
                    <label class="block text-xs font-bold text-[#4A5B6C] mb-1">
                        Arti / Terjemahan Bahasa Indonesia <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="terjemahan"
                        x-model="editingDoa.terjemahan"
                        required
                        rows="3"
                        class="w-full px-3.5 py-2 text-xs rounded-xl border border-[#E5DEC9] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:border-[#0E7B87]"
                    ></textarea>
                </div>

                {{-- Status Publikasi --}}
                <div class="flex items-center gap-2 pt-1">
                    <input
                        type="checkbox"
                        name="is_published"
                        value="1"
                        id="edit_is_published"
                        x-model="editingDoa.is_published"
                        class="w-4 h-4 rounded text-[#0E7B87] border-[#E5DEC9] focus:ring-[#0E7B87]"
                    >
                    <label for="edit_is_published" class="text-xs font-semibold text-[#1E2B3A] cursor-pointer">
                        Terbitkan doa ini (tampil di aplikasi publik)
                    </label>
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
