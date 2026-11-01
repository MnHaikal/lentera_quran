<x-app-layout>
    <x-slot name="title">Bacaan Tahlil & Doa Arwah - Lentera Quran</x-slot>

    <div class="bg-white border-b border-slate-200 py-8 px-4">
        <div class="max-w-4xl mx-auto space-y-2 text-center md:text-left">
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                📿 Rangkaian Bacaan Tahlil Lengkap
            </h1>
            <p class="text-sm text-slate-500">
                Urutan bacaan tahlil, tasbih, tahmid, istighfar, dan doa arwah bersumber tradisi amaliah Ahlussunnah wal Jama'ah.
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-8 space-y-6">
        @foreach($tahlilItems as $item)
            <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center">
                            {{ $item->urutan }}
                        </span>
                        <h3 class="font-bold text-slate-800 text-base">{{ $item->judul }}</h3>
                    </div>

                    @if($item->jumlah_baca > 1)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                            Dibaca {{ $item->jumlah_baca }}x
                        </span>
                    @endif
                </div>

                <div class="text-right py-4" dir="rtl">
                    <p class="font-arabic text-2xl md:text-3xl text-slate-900 leading-loose" style="line-height: 2.3;">
                        {{ $item->teks_arab }}
                    </p>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-50">
                    <p class="text-sm font-medium text-emerald-800 italic leading-relaxed">
                        {{ $item->teks_latin }}
                    </p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $item->terjemahan }}
                    </p>

                    @if($item->keterangan)
                        <p class="text-xs text-slate-400 mt-2">
                            ℹ️ {{ $item->keterangan }}
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>

