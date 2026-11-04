@php
    $sourceName = config('quran.source_name', 'EQuran.id');
    $translatorName = config('quran.translator_name', 'Kementerian Agama Republik Indonesia (Kemenag RI)');
    $qariName = config('quran.qari_name', 'Misyari Rasyid Al-Afasi');
@endphp

<footer class="bg-footer-bg text-footer-text border-t border-line mt-auto pb-20 md:pb-0">
    <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10">
            <div class="sm:col-span-2 lg:col-span-5 space-y-4">
                <div class="flex items-start gap-4 sm:gap-5">
                    <a href="{{ route('beranda') }}" wire:navigate aria-label="Beranda Lentera Quran" class="shrink-0 group focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold rounded-full">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-white p-2.5 shadow-md flex items-center justify-center overflow-hidden border border-white/20 group-hover:scale-105 transition duration-200">
                            <img
                                src="{{ asset('images/logo-footer.png') }}"
                                alt="Logo Lentera Qur'an"
                                class="w-full h-full object-contain"
                            >
                        </div>
                    </a>

                    <div class="space-y-3 flex-1 min-w-0">
                        <p class="text-body-sm text-footer-muted leading-relaxed">
                            Platform Al-Qur'an digital berbahasa Indonesia. Mushaf Standar Indonesia ({{ $translatorName }}) melalui {{ $sourceName }} dengan terjemahan resmi, tafsir, serta audio murottal ({{ $qariName }}) untuk menemani ibadah harian umat Islam.
                        </p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <h2 class="text-body-sm font-semibold text-footer-text mb-4">Navigasi</h2>
                <ul class="space-y-2.5 text-body-sm">
                    <li>
                        <a href="{{ route('beranda') }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold rounded">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('quran.index') }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold rounded">
                            Al-Qur'an Digital
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tahlil.index') }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold rounded">
                            Bacaan Tahlil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doa.index') }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold rounded">
                            Doa &amp; Dzikir
                        </a>
                    </li>
                </ul>
            </div>

            <div class="lg:col-span-3">
                <h2 class="text-body-sm font-semibold text-footer-text mb-4">Pintasan Populer</h2>
                <ul class="space-y-2.5 text-body-sm">
                    <li>
                        <a href="{{ route('quran.show', ['surah' => 2, 'ayat' => 255]) }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition">
                            Ayat Kursi (QS. 2:255)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('quran.show', 36) }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition">
                            Surah Yasin (QS. 36)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('quran.show', 55) }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition">
                            Surah Ar-Rahman (QS. 55)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('quran.show', 67) }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition">
                            Surah Al-Mulk (QS. 67)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('quran.show', 56) }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition">
                            Surah Al-Waqiah (QS. 56)
                        </a>
                    </li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h2 class="text-body-sm font-semibold text-footer-text mb-4">Akun &amp; Layanan</h2>
                <ul class="space-y-2.5 text-body-sm">
                    @guest
                        <li>
                            <a href="{{ route('login') }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition">
                                Masuk Akun
                            </a>
                        </li>
                        @if (Route::has('register'))
                            <li>
                                <a href="{{ route('register') }}" wire:navigate class="text-footer-muted hover:text-brand-gold transition">
                                    Daftar Gratis
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="text-footer-muted">
                            Masuk sebagai <span class="text-footer-text font-semibold">{{ Auth::user()->name }}</span>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-6 border-t border-white/10 text-center text-label-sm text-footer-muted">
            <p>
                &copy; {{ date('Y') }} Lentera Quran. Hak Cipta Dilindungi Undang-Undang. Mengacu pada Mushaf Standar Indonesia {{ $translatorName }} ({{ $sourceName }}).
            </p>
        </div>
    </div>
</footer>
