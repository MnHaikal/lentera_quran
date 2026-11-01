<x-app-layout>
    <x-slot name="title">Pengaturan Tampilan - Lentera Quran</x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8 space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">⚙️ Pengaturan Tampilan</h1>
            <p class="text-sm text-slate-500">Sesuaikan ukuran font, teks latin, terjemahan, dan tema tampilan Al-Qur'an.</p>
        </div>

        @if(session('status'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold">
                ✓ {{ session('status') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
            <form action="{{ route('pengaturan.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-800">
                        Ukuran Font Teks Arab (px):
                    </label>
                    <div class="flex items-center gap-4">
                        <input type="range" name="ukuran_font_arab" min="20" max="44" step="2"
                               value="{{ old('ukuran_font_arab', $setting->ukuran_font_arab) }}"
                               oninput="document.getElementById('fontPreviewVal').innerText = this.value + 'px'; document.getElementById('arabicPreview').style.fontSize = this.value + 'px';"
                               class="w-full accent-emerald-600">
                        <span id="fontPreviewVal" class="text-sm font-mono font-bold text-emerald-700 w-16 text-right">
                            {{ old('ukuran_font_arab', $setting->ukuran_font_arab) }}px
                        </span>
                    </div>

                    <div class="mt-4 p-4 rounded-xl bg-slate-50 border border-slate-200 text-right" dir="rtl">
                        <p id="arabicPreview" class="font-arabic leading-loose text-slate-800"
                           style="font-size: {{ old('ukuran_font_arab', $setting->ukuran_font_arab) }}px; line-height: 2.2;">
                            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                        </p>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('ukuran_font_arab')" />
                </div>

                <div class="border-t border-slate-100 pt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="block text-sm font-semibold text-slate-800">Tampilkan Teks Latin</span>
                            <span class="text-xs text-slate-500">Menampilkan transliterasi latin di bawah ayat Al-Qur'an</span>
                        </div>
                        <input type="hidden" name="tampilkan_latin" value="0">
                        <input type="checkbox" name="tampilkan_latin" value="1"
                               {{ old('tampilkan_latin', $setting->tampilkan_latin) ? 'checked' : '' }}
                               class="h-5 w-5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <span class="block text-sm font-semibold text-slate-800">Tampilkan Terjemahan Indonesia</span>
                            <span class="text-xs text-slate-500">Menampilkan arti terjemahan standar Kemenag RI</span>
                        </div>
                        <input type="hidden" name="tampilkan_terjemahan" value="0">
                        <input type="checkbox" name="tampilkan_terjemahan" value="1"
                               {{ old('tampilkan_terjemahan', $setting->tampilkan_terjemahan) ? 'checked' : '' }}
                               class="h-5 w-5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6 space-y-2">
                    <label class="block text-sm font-semibold text-slate-800">Tema Warna Tampilan:</label>
                    <select name="tema" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="sistem" {{ old('tema', $setting->tema->value ?? 'sistem') === 'sistem' ? 'selected' : '' }}>Mengikuti Tema Sistem</option>
                        <option value="terang" {{ old('tema', $setting->tema->value ?? 'sistem') === 'terang' ? 'selected' : '' }}>Mode Terang (Light)</option>
                        <option value="gelap" {{ old('tema', $setting->tema->value ?? 'sistem') === 'gelap' ? 'selected' : '' }}>Mode Gelap (Dark)</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('tema')" />
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition shadow">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
