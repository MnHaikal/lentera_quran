<x-app-layout>
    <x-slot name="title">Daftar Tersimpan - Lentera Quran</x-slot>

    <div class="max-w-5xl mx-auto px-4 py-8 space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">🔖 Daftar Tersimpan</h1>
            <p class="text-sm text-slate-500">Koleksi surah, ayat, dan doa yang Anda simpan untuk dibaca kembali.</p>
        </div>

        <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
            <a href="{{ route('tersimpan') }}" wire:navigate
               class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ empty($type) ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
                Semua
            </a>
            <a href="{{ route('tersimpan', ['tipe' => 'surah']) }}" wire:navigate
               class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ $type === 'surah' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
                Surah
            </a>
            <a href="{{ route('tersimpan', ['tipe' => 'ayah']) }}" wire:navigate
               class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ $type === 'ayah' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
                Ayat
            </a>
            <a href="{{ route('tersimpan', ['tipe' => 'doa']) }}" wire:navigate
               class="px-4 py-2 rounded-lg text-xs font-semibold transition {{ $type === 'doa' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
                Doa
            </a>
        </div>

        @if($bookmarks->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-200">
                <span class="text-4xl">🔖</span>
                <p class="mt-3 text-slate-600 font-semibold">Belum ada item yang disimpan.</p>
                <p class="text-xs text-slate-400 mt-1">Gunakan tombol bintang pada surah, ayat, atau doa untuk menyimpannya ke daftar ini.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($bookmarks as $bookmark)
                    <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <span class="text-xs font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-50 text-emerald-700">
                                {{ strtoupper($bookmark->bookmarkable_type) }}
                            </span>

                            @if($bookmark->bookmarkable_type === 'surah' && $bookmark->bookmarkable)
                                <h3 class="font-bold text-slate-900 text-base">
                                    Surah {{ $bookmark->bookmarkable->nama_latin }} ({{ $bookmark->bookmarkable->nama_arab }})
                                </h3>
                                <p class="text-xs text-slate-500">
                                    {{ $bookmark->bookmarkable->arti }} • {{ $bookmark->bookmarkable->jumlah_ayat }} Ayat
                                </p>
                            @elseif($bookmark->bookmarkable_type === 'ayah' && $bookmark->bookmarkable)
                                <h3 class="font-bold text-slate-900 text-base">
                                    QS. {{ $bookmark->bookmarkable->surah->nama_latin }}: {{ $bookmark->bookmarkable->nomor_ayat }}
                                </h3>
                                <p class="text-xs text-slate-600 line-clamp-2">
                                    {{ $bookmark->bookmarkable->terjemahan }}
                                </p>
                            @elseif($bookmark->bookmarkable_type === 'doa' && $bookmark->bookmarkable)
                                <h3 class="font-bold text-slate-900 text-base">
                                    {{ $bookmark->bookmarkable->judul }}
                                </h3>
                                <p class="text-xs text-slate-600 line-clamp-2">
                                    {{ $bookmark->bookmarkable->terjemahan }}
                                </p>
                            @endif

                            <p class="text-xs text-slate-400 pt-1">
                                Disimpan {{ $bookmark->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            @if($bookmark->bookmarkable_type === 'surah' && $bookmark->bookmarkable)
                                <a href="{{ route('quran.show', $bookmark->bookmarkable->id) }}" wire:navigate
                                   class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold transition">
                                    Buka Surah →
                                </a>
                            @elseif($bookmark->bookmarkable_type === 'ayah' && $bookmark->bookmarkable)
                                <a href="{{ route('quran.show', $bookmark->bookmarkable->surah_id) }}?ayat={{ $bookmark->bookmarkable->nomor_ayat }}" wire:navigate
                                   class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold transition">
                                    Buka Ayat →
                                </a>
                            @elseif($bookmark->bookmarkable_type === 'doa' && $bookmark->bookmarkable)
                                <a href="{{ route('doa.show', $bookmark->bookmarkable->slug) }}" wire:navigate
                                   class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold transition">
                                    Buka Doa →
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $bookmarks->links() }}
            </div>
        @endif
    </div>
</x-app-layout>

