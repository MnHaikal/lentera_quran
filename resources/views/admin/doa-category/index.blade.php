@extends('admin.layouts.app')

@section('title', 'Kategori Doa — Super Admin Lentera Quran')

@section('topbar_title')
    <div class="flex items-center gap-2.5 flex-wrap">
        <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
            Kategori Doa
        </h1>
    </div>
@endsection

@section('content')
<div class="space-y-4">
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
        {{-- Toolbar: Search Controls (Integrated into Table Card) --}}
        <div class="p-3.5 sm:p-4 border-b border-[#EAE3D2] dark:border-white/10 bg-white dark:bg-[#0D213A]">
            <form
                method="GET"
                action="{{ route('admin.doa-category.index') }}"
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
                        placeholder="Cari kategori doa..."
                        class="w-full pl-9 pr-3.5 py-2 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] dark:bg-[#132C4B] text-[#0F1E36] dark:text-white placeholder-[#8C98A4] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:bg-white transition"
                    >
                </div>

                {{-- Clear Filter if active --}}
                @if(request()->filled('q'))
                    <a
                        href="{{ route('admin.doa-category.index') }}"
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
            </form>
        </div>

        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[760px]">
                <thead>
                    <tr class="border-b border-[#EAE3D2] dark:border-white/10 bg-[#FFFDF7] dark:bg-[#102744] text-[11px] font-bold text-[#4A5B6C] dark:text-[#9AB1C9] uppercase tracking-wider">
                        <th scope="col" class="w-16 px-4 py-3.5 text-center">
                            Urutan
                        </th>
                        <th scope="col" class="px-5 py-3.5 text-left">
                            Nama Kategori
                        </th>
                        <th scope="col" class="w-64 px-4 py-3.5 text-left">
                            Slug URL
                        </th>
                        <th scope="col" class="w-36 px-4 py-3.5 text-center">
                            Jumlah Doa
                        </th>
                        <th scope="col" class="w-20 px-4 py-3.5 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAE3D2] dark:divide-white/10 text-xs">
                    @forelse($categories as $category)
                        <tr class="hover:bg-[#FAF7F0]/60 dark:hover:bg-white/5 transition group">
                            {{-- Urutan (Same clean styling as Tahlil) --}}
                            <td class="px-4 py-4 text-center text-xs font-semibold text-[#475569]">
                                {{ $category->urutan }}
                            </td>

                            {{-- Nama Kategori (No Icon, Clean Title & Description) --}}
                            <td class="px-5 py-4">
                                <div class="min-w-0">
                                    <p class="font-bold text-xs sm:text-sm text-[#0F1E36] dark:text-white leading-snug">
                                        {{ $category->nama }}
                                    </p>
                                    <p class="text-[11px] text-[#708090] dark:text-[#9AB1C9] mt-0.5 line-clamp-1">
                                        {{ $category->deskripsi ?? 'Pengelompokan doa sesuai konteks dan tema' }}
                                    </p>
                                </div>
                            </td>

                            {{-- Slug URL --}}
                            <td class="px-4 py-4 text-left">
                                <span class="text-xs text-[#708090] dark:text-[#9AB1C9] font-mono block truncate max-w-[200px]" title="/doa/{{ $category->slug }}">
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

                            {{-- Aksi (Eye icon only) --}}
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center">
                                    <a
                                        href="{{ route('doa.index', ['kategori' => $category->slug]) }}"
                                        target="_blank"
                                        title="Lihat Doa Kategori Ini di Web Publik"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-[#788797] hover:bg-[#FAF7F0] hover:text-[#0E7B87] transition"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
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

        {{-- Custom Pagination Footer (Identical to Surah & Ayat) --}}
        <div class="px-5 py-4 border-t border-[#EAE3D2] flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
            <div class="text-xs text-[#6B7C8E] font-medium">
                @if($categories->total() > 0)
                    Menampilkan {{ $categories->firstItem() }}-{{ $categories->lastItem() }} dari {{ $categories->total() }} kategori
                @else
                    Menampilkan 0 kategori
                @endif
            </div>

            @if($categories->hasPages())
                <div class="flex items-center gap-1.5 flex-wrap">
                    {{-- Previous Page Link --}}
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
                            title="Halaman Sebelumnya"
                        >
                            Sebelumnya
                        </a>
                    @endif

                    {{-- Numerical Page Elements --}}
                    @php
                        $currentPage = $categories->currentPage();
                        $lastPage = $categories->lastPage();
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
                                href="{{ $categories->url($elem) }}"
                                wire:navigate
                                wire:navigate.hover
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-[#4A5B6C] hover:bg-black/5 text-xs font-medium transition"
                            >
                                {{ $elem }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if($categories->hasMorePages())
                        <a
                            href="{{ $categories->nextPageUrl() }}"
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
</div>
@endsection
