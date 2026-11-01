<x-app-layout>
    <x-slot name="title">{{ $doa->judul }} - Lentera Quran</x-slot>

    <div x-data="{
        isBookmarked: {{ $isBookmarked ? 'true' : 'false' }},

        toggleBookmark() {
            @guest
                window.location.href = '{{ route('login') }}';
                return;
            @endguest

            fetch('{{ route('bookmark.doa', $doa->slug) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.isBookmarked = data.bookmarked;
            });
        },

        copyDoa() {
            const text = `${'{{ addslashes($doa->teks_arab) }}'}\n\n${'{{ addslashes($doa->teks_latin) }}'}\n\nArtinya:\n${'{{ addslashes($doa->terjemahan) }}'}\n\n(Sumber: ${'{{ addslashes($doa->sumber ?? 'Al-Qur\'an & Sunnah') }}'})`;
            navigator.clipboard.writeText(text).then(() => {
                alert('Teks doa berhasil disalin!');
            });
        }
    }"
    class="max-w-4xl mx-auto px-4 py-8 space-y-6">

        <div class="mb-4">
            <a href="{{ route('doa.index') }}" wire:navigate class="text-sm font-semibold text-emerald-600 hover:underline">
                ← Kembali ke Daftar Doa
            </a>
        </div>

        <div class="p-8 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-md">
                    {{ $doa->category->nama }}
                </span>

                <div class="flex items-center gap-2">
                    <button type="button" @click="toggleBookmark"
                            :class="isBookmarked ? 'bg-amber-100 text-amber-800 border-amber-300' : 'bg-slate-50 text-slate-700 border-slate-200'"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition">
                        <span x-text="isBookmarked ? '★ Tersimpan' : '☆ Simpan Doa'"></span>
                    </button>

                    <button type="button" @click="copyDoa"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-50 text-slate-700 text-xs font-semibold hover:bg-slate-100 transition">
                        📋 Salin
                    </button>
                </div>
            </div>

            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">{{ $doa->judul }}</h1>

            <div class="text-right py-6" dir="rtl">
                <p class="font-arabic text-3xl md:text-4xl text-slate-900 leading-loose" style="line-height: 2.3;">
                    {{ $doa->teks_arab }}
                </p>
            </div>

            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Pelafalan Latin:</h4>
                    <p class="text-base text-emerald-800 font-medium italic leading-relaxed">
                        {{ $doa->teks_latin }}
                    </p>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Artinya:</h4>
                    <p class="text-base text-slate-700 leading-relaxed">
                        {{ $doa->terjemahan }}
                    </p>
                </div>

                @if($doa->sumber)
                    <div class="pt-2 text-xs text-slate-500">
                        📖 <span class="font-semibold">Dalil / Sumber Riwayat:</span> {{ $doa->sumber }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

