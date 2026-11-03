@extends('admin.layouts.app')

@section('title', 'Bacaan Tahlil — Super Admin Lentera Quran')

@section('topbar_title')
    <div class="flex items-center gap-2.5 flex-wrap">
        <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
            Bacaan Tahlil
        </h1>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#E1F1F1] dark:bg-[#16363B] text-[#1B6B73] dark:text-[#7CE3B3] text-[11px] font-bold shrink-0">
            {{ $totalTahlil }} Bacaan
        </span>
    </div>
@endsection

@section('content')
<div
    x-data="{
        createModalOpen: false,
        editModalOpen: false,
        deleteModalOpen: false,
        itemToDelete: { id: null, judul: '' },
        editingItem: {
            id: '',
            urutan: 1,
            judul: '',
            keterangan: '',
            teks_arab: '',
            teks_latin: '',
            terjemahan: '',
            jumlah_baca: 1,
            is_published: true
        },
        openCreate() {
            this.createModalOpen = true;
        },
        openEdit(item) {
            this.editingItem = {
                id: item.id,
                urutan: item.urutan,
                judul: item.judul,
                keterangan: item.keterangan ?? '',
                teks_arab: item.teks_arab,
                teks_latin: item.teks_latin ?? '',
                terjemahan: item.terjemahan ?? '',
                jumlah_baca: item.jumlah_baca,
                is_published: !!item.is_published
            };
            this.editModalOpen = true;
        },
        confirmDelete(id, judul) {
            this.itemToDelete = { id: id, judul: judul };
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

    {{-- Search & Controls Toolbar (Matching Mockup) --}}
    <div class="rounded-2xl bg-white dark:bg-[#0D213A] border border-[#EAE3D2] dark:border-white/10 p-3.5 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-3">
        {{-- Search Input Form --}}
        <form method="GET" action="{{ route('admin.tahlil.index') }}" class="flex-1 max-w-md relative">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex items-center">
                <svg class="w-4 h-4 text-[#8C98A4] absolute left-3.5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari judul bacaan..."
                    class="w-full pl-10 pr-4 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] placeholder-[#8C98A4] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:bg-white transition"
                >
            </div>
        </form>

        {{-- Right Controls: Filter Status, Refresh, Export --}}
        <div class="flex items-center gap-2.5 flex-wrap">
            {{-- Status Filter Dropdown --}}
            <form method="GET" action="{{ route('admin.tahlil.index') }}" id="statusFilterForm">
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                <div class="relative inline-flex items-center">
                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="pl-8 pr-8 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs font-semibold text-[#0F1E36] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] appearance-none cursor-pointer hover:bg-[#F2ECE0] transition"
                    >
                        <option value="">Semua Status</option>
                        <option value="terbit" {{ request('status') === 'terbit' ? 'selected' : '' }}>Terbit</option>
                        <option value="draf" {{ request('status') === 'draf' ? 'selected' : '' }}>Draf</option>
                    </select>
                    <svg class="w-3.5 h-3.5 text-[#8C98A4] absolute left-2.5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.41A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                    </svg>
                    <svg class="w-3 h-3 text-[#8C98A4] absolute right-2.5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </form>

            {{-- Reset / Refresh Button --}}
            <a
                href="{{ route('admin.tahlil.index') }}"
                wire:navigate
                wire:navigate.hover
                title="Muat Ulang / Bersihkan Filter"
                class="w-8 h-8 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] flex items-center justify-center text-[#4A5B6C] hover:text-[#0B1D33] hover:bg-[#F2ECE0] transition"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </a>

            {{-- Export CSV Button --}}
            <a
                href="{{ route('admin.tahlil.export') }}"
                title="Ekspor Data Tahlil (.csv / Excel)"
                class="w-8 h-8 rounded-xl bg-[#FAF7F0] dark:bg-[#1C2C3E] border border-[#EAE3D2] dark:border-white/10 flex items-center justify-center text-[#4A5B6C] dark:text-[#9AB1C9] hover:text-[#0E7B87] hover:bg-[#F2ECE0] transition"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </a>

            {{-- Tambah Bacaan Button --}}
            <button
                type="button"
                @click="openCreate()"
                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#E2B14C] hover:bg-[#D4A13D] text-[#0F1E36] font-bold text-xs shadow-xs transition shrink-0 cursor-pointer"
            >
                <span class="text-sm leading-none font-extrabold">+</span>
                <span>Tambah Bacaan</span>
            </button>
        </div>
    </div>

    {{-- Drag Handle Info Hint (Matching Mockup: :: Seret baris untuk mengubah urutan bacaan.) --}}
    <div class="flex items-center gap-2 px-1 text-xs text-[#788797]">
        <svg class="w-3.5 h-3.5 text-[#8C98A4]" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="8" cy="6" r="2" />
            <circle cx="16" cy="6" r="2" />
            <circle cx="8" cy="12" r="2" />
            <circle cx="16" cy="12" r="2" />
            <circle cx="8" cy="18" r="2" />
            <circle cx="16" cy="18" r="2" />
        </svg>
        <span>Seret baris untuk mengubah urutan bacaan.</span>
    </div>

    {{-- Main Table Card --}}
    <div class="rounded-2xl bg-white border border-[#EAE3D2] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#EAE3D2] bg-[#FFFDF7] text-[11px] font-bold text-[#4A5B6C] uppercase tracking-wider">
                        <th class="w-20 px-4 py-4 text-center">Urutan</th>
                        <th class="w-48 px-4 py-4">Judul Bacaan</th>
                        <th class="px-4 py-4 text-center">Cuplikan Arab</th>
                        <th class="w-24 px-4 py-4 text-center">Jumlah Baca</th>
                        <th class="w-24 px-4 py-4 text-center">Status</th>
                        <th class="w-36 px-4 py-4 text-left">Terakhir Diperbarui</th>
                        <th class="w-28 px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAE3D2] text-xs">
                    @forelse($tahlilItems as $item)
                        <tr class="hover:bg-[#FAF7F0]/60 transition group">
                            {{-- Urutan with Drag Handle --}}
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-2.5">
                                    <span class="text-[#A5B2C0] group-hover:text-[#0F1E36] cursor-grab select-none">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                            <circle cx="8" cy="6" r="2" />
                                            <circle cx="16" cy="6" r="2" />
                                            <circle cx="8" cy="12" r="2" />
                                            <circle cx="16" cy="12" r="2" />
                                            <circle cx="8" cy="18" r="2" />
                                            <circle cx="16" cy="18" r="2" />
                                        </svg>
                                    </span>
                                    <span class="font-bold text-xs text-[#0F1E36] min-w-[16px]">{{ $item->urutan }}</span>
                                </div>
                            </td>

                            {{-- Judul Bacaan & Subtitle / Keterangan --}}
                            <td class="px-4 py-4">
                                <div>
                                    <p class="font-bold text-xs text-[#0F1E36] leading-snug">
                                        {{ $item->judul }}
                                    </p>
                                    @if($item->keterangan)
                                        <p class="text-[11px] text-[#788797] mt-0.5 leading-snug">
                                            {{ $item->keterangan }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            {{-- Cuplikan Arab (Amiri Font, Center / Right aligned) --}}
                            <td class="px-4 py-4 text-center">
                                <div class="max-w-[280px] lg:max-w-[340px] mx-auto text-center">
                                    <p class="font-arabic text-[18px] text-[#0F1E36] leading-relaxed line-clamp-2" dir="rtl">
                                        {{ Str::limit($item->teks_arab, 95) }}
                                    </p>
                                </div>
                            </td>

                            {{-- Jumlah Baca --}}
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#FFF6E5] border border-[#F3DFC1] text-[#D99B26] text-xs font-bold shadow-2xs">
                                    {{ $item->jumlah_baca }}x
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4 text-center">
                                @if($item->is_published)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#E5F7F8] text-[#0E7B87] text-[11px] font-semibold">
                                        Terbit
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-[#FFF5E6] text-[#C27D00] text-[11px] font-semibold">
                                        Draf
                                    </span>
                                @endif
                            </td>

                            {{-- Terakhir Diperbarui --}}
                            <td class="px-4 py-4 text-left">
                                <div class="leading-tight">
                                    <p class="text-xs font-medium text-[#0F1E36]">
                                        {{ $item->updated_at?->format('d M Y') ?? '24 Okt 2026' }}
                                    </p>
                                    <p class="text-[11px] text-[#788797] mt-0.5">
                                        Ustadz Fauzi
                                    </p>
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    {{-- Edit Button --}}
                                    <button
                                        type="button"
                                        @click="openEdit({{ json_encode($item) }})"
                                        title="Edit Bacaan Tahlil"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center text-[#788797] hover:bg-[#FAF7F0] hover:text-[#0E7B87] transition cursor-pointer"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>

                                    {{-- Pratinjau Publik --}}
                                    <a
                                        href="{{ route('tahlil.show', $item->urutan) }}"
                                        target="_blank"
                                        title="Pratinjau di Halaman Publik"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center text-[#788797] hover:bg-[#FAF7F0] hover:text-[#187581] transition"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>

                                    {{-- Hapus Button --}}
                                    <button
                                        type="button"
                                        @click="confirmDelete({{ $item->id }}, '{{ addslashes($item->judul) }}')"
                                        title="Hapus Bacaan Tahlil"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center text-[#788797] hover:bg-red-50 hover:text-red-600 transition cursor-pointer"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-[#FAF7F0] border border-[#EAE3D2] flex items-center justify-center mx-auto text-[#7A6E57]">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-[#0F1E36]">Tidak ada bacaan tahlil ditemukan</h3>
                                    <p class="text-xs text-[#6B7C8E]">
                                        Tidak ada bacaan yang cocok dengan kriteria pencarian atau filter status saat ini.
                                    </p>
                                    <a
                                        href="{{ route('admin.tahlil.index') }}"
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

        {{-- Custom Pagination Footer (Matching Mockup: Menampilkan 1-6 dari 24 bacaan) --}}
        <div class="px-5 py-4 border-t border-[#EAE3D2] flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
            <div class="text-xs text-[#6B7C8E] font-medium">
                @if($tahlilItems->total() > 0)
                    Menampilkan {{ $tahlilItems->firstItem() }}-{{ $tahlilItems->lastItem() }} dari {{ $tahlilItems->total() }} bacaan
                @else
                    Menampilkan 0 bacaan
                @endif
            </div>

            @if($tahlilItems->hasPages())
                <div class="flex items-center gap-1.5 flex-wrap">
                    {{-- Previous Link --}}
                    @if($tahlilItems->onFirstPage())
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#C0CAD5] pointer-events-none select-none">
                            Sebelumnya
                        </span>
                    @else
                        <a
                            href="{{ $tahlilItems->previousPageUrl() }}"
                            wire:navigate
                            wire:navigate.hover
                            class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#4A5B6C] hover:text-[#0B1D33] hover:bg-black/5 transition"
                        >
                            Sebelumnya
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach(range(1, $tahlilItems->lastPage()) as $page)
                        @if($page == $tahlilItems->currentPage())
                            <span class="w-7 h-7 rounded-lg flex items-center justify-center bg-[#0B1D33] text-white text-xs font-bold shadow-xs">
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $tahlilItems->url($page) }}"
                                wire:navigate
                                wire:navigate.hover
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-[#4A5B6C] hover:bg-black/5 text-xs font-medium transition"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Link --}}
                    @if($tahlilItems->hasMorePages())
                        <a
                            href="{{ $tahlilItems->nextPageUrl() }}"
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

    {{-- Modal Tambah Bacaan Tahlil --}}
    <div
        x-show="createModalOpen"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs"
        @keydown.escape.window="createModalOpen = false"
    >
        <div
            @click.away="createModalOpen = false"
            x-transition
            class="bg-white rounded-2xl border border-[#EAE3D2] shadow-xl w-full max-w-2xl overflow-hidden max-h-[90vh] flex flex-col"
        >
            <div class="px-6 py-4 border-b border-[#EAE3D2] flex items-center justify-between bg-[#FFFDF7]">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#E1F1F1] text-[#1B6B73] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-[#0F1E36]">Tambah Bacaan Tahlil</h2>
                        <p class="text-[11px] text-[#788797]">Lengkapi rincian bacaan dan teks Arab berharakat.</p>
                    </div>
                </div>
                <button @click="createModalOpen = false" class="text-[#8C98A4] hover:text-[#0F1E36] transition p-1">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.tahlil.store') }}" class="p-6 space-y-4 overflow-y-auto flex-1">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2 space-y-1">
                        <label class="block text-xs font-bold text-[#0F1E36]">Judul Bacaan <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="judul"
                            required
                            placeholder="Contoh: Surah Al-Ikhlas"
                            class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                        >
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-[#0F1E36]">Urutan Ke-</label>
                        <input
                            type="number"
                            name="urutan"
                            min="1"
                            placeholder="Otomatis"
                            class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-[#0F1E36]">Keterangan / Sub-judul</label>
                        <input
                            type="text"
                            name="keterangan"
                            placeholder="Contoh: Pemurnian tauhid / QS. Al-Ikhlas: 1-4"
                            class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                        >
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-[#0F1E36]">Jumlah Bacaan <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2">
                            <input
                                type="number"
                                name="jumlah_baca"
                                min="1"
                                max="1000"
                                value="1"
                                required
                                class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                            >
                            <span class="text-xs font-bold text-[#788797]">Kali</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-[#0F1E36]">Teks Arab Berharakat <span class="text-red-500">*</span></label>
                    <textarea
                        name="teks_arab"
                        rows="3"
                        required
                        dir="rtl"
                        placeholder="قُلْ هُوَ اللَّهُ أَحَدٌ ۝"
                        class="font-arabic w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-base text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none leading-relaxed"
                    ></textarea>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-[#0F1E36]">Teks Latin / Transliterasi</label>
                    <textarea
                        name="teks_latin"
                        rows="2"
                        placeholder="Qul huwallāhu aḥad..."
                        class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                    ></textarea>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-[#0F1E36]">Arti / Terjemahan Bahasa Indonesia</label>
                    <textarea
                        name="terjemahan"
                        rows="2"
                        placeholder="Katakanlah (Muhammad), 'Dialah Allah, Yang Maha Esa...'"
                        class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                    ></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input
                        type="checkbox"
                        id="create_is_published"
                        name="is_published"
                        value="1"
                        checked
                        class="w-4 h-4 rounded text-[#0E7B87] border-[#EAE3D2] focus:ring-[#0E7B87]"
                    >
                    <label for="create_is_published" class="text-xs font-semibold text-[#0F1E36] cursor-pointer">
                        Terbitkan langsung ke halaman publik (Status Terbit)
                    </label>
                </div>

                <div class="pt-4 border-t border-[#EAE3D2] flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        @click="createModalOpen = false"
                        class="px-4 py-2 rounded-xl border border-[#EAE3D2] bg-white text-xs font-semibold text-[#4A5B6C] hover:bg-[#FAF7F0] transition"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 rounded-xl bg-[#E2B14C] hover:bg-[#D4A13D] text-[#0F1E36] text-xs font-bold shadow-xs transition"
                    >
                        Simpan Bacaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Bacaan Tahlil --}}
    <div
        x-show="editModalOpen"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs"
        @keydown.escape.window="editModalOpen = false"
    >
        <div
            @click.away="editModalOpen = false"
            x-transition
            class="bg-white rounded-2xl border border-[#EAE3D2] shadow-xl w-full max-w-2xl overflow-hidden max-h-[90vh] flex flex-col"
        >
            <div class="px-6 py-4 border-b border-[#EAE3D2] flex items-center justify-between bg-[#FFFDF7]">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#FAF0D7] text-[#A67715] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-[#0F1E36]">Koreksi / Edit Bacaan Tahlil</h2>
                        <p class="text-[11px] text-[#788797]">Sesuaikan redaksi teks Arab, terjemahan, atau status tayang.</p>
                    </div>
                </div>
                <button @click="editModalOpen = false" class="text-[#8C98A4] hover:text-[#0F1E36] transition p-1">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form
                method="POST"
                :action="'{{ url('admin/tahlil') }}/' + editingItem.id"
                class="p-6 space-y-4 overflow-y-auto flex-1"
            >
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2 space-y-1">
                        <label class="block text-xs font-bold text-[#0F1E36]">Judul Bacaan <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="judul"
                            x-model="editingItem.judul"
                            required
                            class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                        >
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-[#0F1E36]">Urutan Ke- <span class="text-red-500">*</span></label>
                        <input
                            type="number"
                            name="urutan"
                            x-model="editingItem.urutan"
                            min="1"
                            required
                            class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-[#0F1E36]">Keterangan / Sub-judul</label>
                        <input
                            type="text"
                            name="keterangan"
                            x-model="editingItem.keterangan"
                            placeholder="Contoh: Pemurnian tauhid"
                            class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                        >
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-[#0F1E36]">Jumlah Bacaan <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2">
                            <input
                                type="number"
                                name="jumlah_baca"
                                x-model="editingItem.jumlah_baca"
                                min="1"
                                max="1000"
                                required
                                class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                            >
                            <span class="text-xs font-bold text-[#788797]">Kali</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-[#0F1E36]">Teks Arab Berharakat <span class="text-red-500">*</span></label>
                    <textarea
                        name="teks_arab"
                        x-model="editingItem.teks_arab"
                        rows="3"
                        required
                        dir="rtl"
                        class="font-arabic w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-base text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none leading-relaxed"
                    ></textarea>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-[#0F1E36]">Teks Latin / Transliterasi</label>
                    <textarea
                        name="teks_latin"
                        x-model="editingItem.teks_latin"
                        rows="2"
                        class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                    ></textarea>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-[#0F1E36]">Arti / Terjemahan Bahasa Indonesia</label>
                    <textarea
                        name="terjemahan"
                        x-model="editingItem.terjemahan"
                        rows="2"
                        class="w-full px-3.5 py-2 rounded-xl bg-[#FAF7F0] border border-[#EAE3D2] text-xs text-[#0F1E36] focus:ring-1 focus:ring-[#0E7B87] focus:bg-white focus:outline-none"
                    ></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input
                        type="checkbox"
                        id="edit_is_published"
                        name="is_published"
                        value="1"
                        :checked="editingItem.is_published"
                        class="w-4 h-4 rounded text-[#0E7B87] border-[#EAE3D2] focus:ring-[#0E7B87]"
                    >
                    <label for="edit_is_published" class="text-xs font-semibold text-[#0F1E36] cursor-pointer">
                        Terbitkan ke halaman publik (Status Terbit)
                    </label>
                </div>

                <div class="pt-4 border-t border-[#EAE3D2] flex items-center justify-end gap-2.5">
                    <button
                        type="button"
                        @click="editModalOpen = false"
                        class="px-4 py-2 rounded-xl border border-[#EAE3D2] bg-white text-xs font-semibold text-[#4A5B6C] hover:bg-[#FAF7F0] transition"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-5 py-2 rounded-xl bg-[#E2B14C] hover:bg-[#D4A13D] text-[#0F1E36] text-xs font-bold shadow-xs transition"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div
        x-show="deleteModalOpen"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs"
        @keydown.escape.window="deleteModalOpen = false"
    >
        <div
            @click.away="deleteModalOpen = false"
            x-transition
            class="bg-white rounded-2xl border border-[#EAE3D2] shadow-xl w-full max-w-md overflow-hidden p-6 space-y-4"
        >
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-[#0F1E36]">Konfirmasi Hapus Bacaan</h3>
                    <p class="text-xs text-[#788797]">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>

            <p class="text-xs text-[#4A5B6C] leading-relaxed">
                Apakah Anda yakin ingin menghapus bacaan tahlil <strong class="text-[#0F1E36]" x-text="'&ldquo;' + itemToDelete.judul + '&rdquo;'"></strong> dari database?
            </p>

            <form
                method="POST"
                :action="'{{ url('admin/tahlil') }}/' + itemToDelete.id"
                class="flex items-center justify-end gap-2.5 pt-2 border-t border-[#EAE3D2]"
            >
                @csrf
                @method('DELETE')
                <button
                    type="button"
                    @click="deleteModalOpen = false"
                    class="px-4 py-2 rounded-xl border border-[#EAE3D2] bg-white text-xs font-semibold text-[#4A5B6C] hover:bg-[#FAF7F0] transition"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-xs transition"
                >
                    Hapus Bacaan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

