<x-app-layout>
    <x-slot name="title">Kumpulan Doa Harian & Pilihan - Lentera Quran</x-slot>

    <div class="bg-white border-b border-slate-200 py-8 px-4">
        <div class="max-w-7xl mx-auto space-y-4">
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                🤲 Kumpulan Doa Sehari-Hari
            </h1>
            <p class="text-sm text-slate-500">
                Doa-doa shahih dari Al-Qur'an dan Sunnah Nabi Muhammad SAW untuk diamalkan dalam kehidupan sehari-hari.
            </p>

            <form action="{{ route('doa.index') }}" method="GET" class="flex flex-wrap items-center gap-3 pt-2">
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari doa (misal: tidur, makan, sapu jagat)..."
                       class="px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500 w-full sm:w-80">

                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                    Cari Doa
                </button>
            </form>

            <div class="flex flex-wrap items-center gap-2 pt-2">
                <a href="{{ route('doa.index') }}" wire:navigate
                   class="px-3 py-1.5 rounded-full text-xs font-semibold transition {{ empty($categorySlug) ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Kategori
                </a>

                @foreach($categories as $cat)
                    <a href="{{ route('doa.index', ['kategori' => $cat->slug]) }}" wire:navigate
                       class="px-3 py-1.5 rounded-full text-xs font-semibold transition {{ $categorySlug === $cat->slug ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $cat->nama }} ({{ $cat->doas_count }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($doas->isEmpty())
            <div class="text-center py-12 bg-white rounded-xl border border-slate-200">
                <p class="text-slate-500">Tidak ada doa yang ditemukan.</p>
                <a href="{{ route('doa.index') }}" wire:navigate class="mt-2 inline-block text-sm font-semibold text-emerald-600 hover:underline">
                    Reset Pencarian
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($doas as $doa)
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md">
                                    {{ $doa->category->nama }}
                                </span>
                                <a href="{{ route('doa.show', $doa->slug) }}" wire:navigate class="text-xs font-semibold text-emerald-600 hover:underline">
                                    Detail Doa →
                                </a>
                            </div>

                            <h3 class="font-bold text-slate-900 text-lg">
                                <a href="{{ route('doa.show', $doa->slug) }}" wire:navigate class="hover:text-emerald-600 transition">
                                    {{ $doa->judul }}
                                </a>
                            </h3>

                            <div class="text-right py-2" dir="rtl">
                                <p class="font-arabic text-xl md:text-2xl text-slate-900 leading-loose" style="line-height: 2.2;">
                                    {{ $doa->teks_arab }}
                                </p>
                            </div>

                            <p class="text-xs font-medium text-emerald-800 italic">
                                {{ $doa->teks_latin }}
                            </p>

                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ $doa->terjemahan }}
                            </p>
                        </div>

                        @if($doa->sumber)
                            <div class="pt-3 border-t border-slate-100 text-xs text-slate-400">
                                📖 Sumber: {{ $doa->sumber }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $doas->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
