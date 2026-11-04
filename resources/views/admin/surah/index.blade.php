@extends('admin.layouts.app')

@section('title', 'Surah & Ayat — Super Admin Lentera Quran')

@section('topbar_title')
    <div class="flex items-center gap-2.5 flex-wrap">
        <h1 class="text-base sm:text-lg font-extrabold text-[#0F2D4F] dark:text-white tracking-tight">
            Surah &amp; Ayat
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

    {{-- Main Data Table Card with Integrated Search & Filter Toolbar --}}
    <div
        class="rounded-2xl bg-white dark:bg-[#0D213A] border border-[#EAE3D2] dark:border-white/10 overflow-hidden shadow-xs"
    >
        {{-- Toolbar: Search & Filter Controls (Integrated into Table Card) --}}
        <div class="p-3.5 sm:p-4 border-b border-[#EAE3D2] dark:border-white/10 bg-white dark:bg-[#0D213A]">
            <form
                method="GET"
                action="{{ route('admin.surah.index') }}"
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
                        placeholder="Cari nama atau nomor surah..."
                        class="w-full pl-9 pr-3.5 py-2 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] dark:bg-[#132C4B] text-[#0F1E36] dark:text-white placeholder-[#8C98A4] focus:outline-none focus:ring-1 focus:ring-[#0E7B87] focus:bg-white transition"
                    >
                </div>

                {{-- Filter Fields Group --}}
                <div class="flex flex-wrap items-center gap-2.5">
                    {{-- Dropdown Tempat Turun --}}
                    <select
                        name="tempat_turun"
                        onchange="this.form.submit()"
                        class="py-2 pl-3 pr-8 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] dark:bg-[#132C4B] text-[#0F1E36] dark:text-white font-medium focus:outline-none focus:ring-1 focus:ring-[#0E7B87] cursor-pointer hover:bg-[#F2ECE0] transition"
                    >
                        <option value="">Semua Tempat Turun</option>
                        <option value="mekah" {{ request('tempat_turun') === 'mekah' ? 'selected' : '' }}>Mekah</option>
                        <option value="madinah" {{ request('tempat_turun') === 'madinah' ? 'selected' : '' }}>Madinah</option>
                    </select>

                    {{-- Dropdown Juz --}}
                    <select
                        name="juz"
                        onchange="this.form.submit()"
                        class="py-2 pl-3 pr-8 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] dark:bg-[#132C4B] text-[#0F1E36] dark:text-white font-medium focus:outline-none focus:ring-1 focus:ring-[#0E7B87] cursor-pointer hover:bg-[#F2ECE0] transition"
                    >
                        <option value="">Semua Juz</option>
                        @for($j = 1; $j <= 30; $j++)
                            <option value="{{ $j }}" {{ (int) request('juz') === $j ? 'selected' : '' }}>
                                Juz {{ $j }}
                            </option>
                        @endfor
                    </select>

                    {{-- Dropdown Audio --}}
                    <select
                        name="audio"
                        onchange="this.form.submit()"
                        class="py-2 pl-3 pr-8 rounded-xl text-xs border border-[#EAE3D2] bg-[#FAF7F0] dark:bg-[#132C4B] text-[#0F1E36] dark:text-white font-medium focus:outline-none focus:ring-1 focus:ring-[#0E7B87] cursor-pointer hover:bg-[#F2ECE0] transition"
                    >
                        <option value="">Semua Audio</option>
                        <option value="tersedia" {{ request('audio') === 'tersedia' ? 'selected' : '' }}>Audio Tersedia</option>
                        <option value="belum_ada" {{ request('audio') === 'belum_ada' ? 'selected' : '' }}>Belum Ada Audio</option>
                    </select>

                    {{-- Clear Filters if active --}}
                    @if(request()->filled('q') || request()->filled('tempat_turun') || request()->filled('juz') || request()->filled('audio'))
                        <a
                            href="{{ route('admin.surah.index') }}"
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
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="border-b border-[#EAE3D2] dark:border-white/10 bg-[#FFFDF7] dark:bg-[#102744] text-[11px] font-bold text-[#4A5B6C] dark:text-[#9AB1C9] uppercase tracking-wider">
                        <th scope="col" class="px-4 py-3.5 text-center w-12">
                            No
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-center w-36">
                            Nama Arab
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-left">
                            Nama Latin
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-left">
                            Arti Terjemahan
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-center">
                            Jumlah Ayat
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-center">
                            Tempat Turun
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-center">
                            Audio Surah
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-center">
                            Terakhir Diperbarui
                        </th>
                        <th scope="col" class="px-4 py-3.5 text-center w-24">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EAE3D2] dark:divide-white/10 text-xs">
                    @forelse($surahs as $surah)
                        <tr class="hover:bg-[#FAF7F0]/60 dark:hover:bg-white/5 transition group">
                            {{-- No --}}
                            <td class="px-4 py-4 text-center text-xs font-semibold text-[#475569]">
                                {{ $surah->id }}
                            </td>

                            {{-- Nama Arab --}}
                            <td class="px-4 py-4 text-center">
                                <span class="font-arabic text-2xl font-bold text-[#0F1E36] leading-none block">
                                    {{ $surah->nama_arab }}
                                </span>
                            </td>

                            {{-- Nama Latin --}}
                            <td class="px-4 py-4 text-left">
                                <span class="font-bold text-xs text-[#0F1E36] block">
                                    {{ $surah->nama_latin }}
                                </span>
                            </td>

                            {{-- Arti Terjemahan --}}
                            <td class="px-4 py-4 text-left text-xs text-[#526374]">
                                {{ $surah->arti }}
                            </td>

                            {{-- Jumlah Ayat --}}
                            <td class="px-4 py-4 text-center text-xs font-semibold text-[#1E2B3A]">
                                {{ $surah->jumlah_ayat }} Ayat
                            </td>

                            {{-- Tempat Turun --}}
                            <td class="px-4 py-4 text-center">
                                @if(strtolower($surah->tempat_turun) === 'mekah')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#FFF6E5] text-[#A66C0C] border border-[#FDE1AC]">
                                        Mekah
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#E5F7F8] text-[#0E7B87] border border-[#BDE7EB]">
                                        Madinah
                                    </span>
                                @endif
                            </td>

                            {{-- Audio Surah --}}
                            <td class="px-4 py-4 text-center">
                                @if($surah->audio_url)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#E5F7F8] text-[#0E7B87] border border-[#BDE7EB]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>
                                        <span>Tersedia</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>Belum Ada</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Terakhir Diperbarui --}}
                            <td class="px-4 py-4 text-center text-xs text-[#708090] whitespace-nowrap">
                                {{ $surah->updated_at ? $surah->updated_at->translatedFormat('d M Y') : '14 Mei 2025' }}
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center">
                                    {{-- Lihat Detail Surah (Eye / View icon) --}}
                                    <a
                                        href="{{ route('quran.show', $surah->id) }}"
                                        target="_blank"
                                        title="Lihat Detail Surah"
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
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="max-w-md mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-[#FAF7F0] border border-[#EAE3D2] flex items-center justify-center mx-auto text-[#7A6E57]">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-[#0F1E36]">Tidak ada surah ditemukan</h3>
                                    <p class="text-xs text-[#6B7C8E]">
                                        Tidak ada surah yang cocok dengan filter pencarian saat ini. Silakan ubah filter atau kata kunci.
                                    </p>
                                    <a
                                        href="{{ route('admin.surah.index') }}"
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

        {{-- Custom Pagination Footer (Identical to Mockup) --}}
        <div class="px-5 py-4 border-t border-[#EAE3D2] flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
            <div class="text-xs text-[#6B7C8E] font-medium">
                @if($surahs->total() > 0)
                    Menampilkan {{ $surahs->firstItem() }}-{{ $surahs->lastItem() }} dari {{ $surahs->total() }} surah
                @else
                    Menampilkan 0 surah
                @endif
            </div>

            @if($surahs->hasPages())
                <div class="flex items-center gap-1.5 flex-wrap">
                    {{-- Previous Page Link --}}
                    @if($surahs->onFirstPage())
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold text-[#C0CAD5] pointer-events-none select-none">
                            Sebelumnya
                        </span>
                    @else
                        <a
                            href="{{ $surahs->previousPageUrl() }}"
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
                        $currentPage = $surahs->currentPage();
                        $lastPage = $surahs->lastPage();
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
                                href="{{ $surahs->url($elem) }}"
                                wire:navigate
                                wire:navigate.hover
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-[#4A5B6C] hover:bg-black/5 text-xs font-medium transition"
                            >
                                {{ $elem }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if($surahs->hasMorePages())
                        <a
                            href="{{ $surahs->nextPageUrl() }}"
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
