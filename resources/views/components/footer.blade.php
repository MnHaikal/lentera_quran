@php
    $sourceName = config('quran.source_name', 'EQuran.id');
    $translatorName = config('quran.translator_name', 'Kementerian Agama Republik Indonesia (Kemenag RI)');
    $qariName = config('quran.qari_name', 'Misyari Rasyid Al-Afasi');
@endphp

<footer class="bg-footer-bg text-footer-text border-t border-line mt-auto pb-20 md:pb-0">
    <div class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div class="space-y-4">
                <a href="{{ route('beranda') }}" wire:navigate class="inline-flex items-center gap-3 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold rounded-lg">
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-brand-gold text-brand-navy shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </span>
                    <span class="text-headline-sm font-bold text-footer-text">Lentera Quran</span>
                </a>

                <p class="text-body-sm text-footer-muted leading-relaxed">
                    Platform Al-Qur'an digital berbahasa Indonesia. Mushaf Standar Indonesia ({{ $translatorName }}) melalui {{ $sourceName }} dengan terjemahan resmi, tafsir, serta audio murottal ({{ $qariName }}) untuk menemani ibadah harian umat Islam.
                </p>

                <div class="flex items-center gap-2.5 pt-1">
                    <a href="{{ route('quran.index') }}" wire:navigate aria-label="Mushaf Al-Qur'an" class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-white/15 bg-white/5 text-footer-muted hover:text-brand-gold hover:border-brand-gold transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </a>
                    <a href="{{ route('tahlil.index') }}" wire:navigate aria-label="Bacaan Tahlil" class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-white/15 bg-white/5 text-footer-muted hover:text-brand-gold hover:border-brand-gold transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </a>
                    <a href="{{ route('doa.index') }}" wire:navigate aria-label="Kumpulan Doa" class="inline-flex items-center justify-center w-9 h-9 rounded-full border border-white/15 bg-white/5 text-footer-muted hover:text-brand-gold hover:border-brand-gold transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div>
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

            <div>
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

            <div class="space-y-4">
                <div>
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

                <div class="rounded-xl bg-white/5 border border-white/10 p-3.5 text-label-sm text-footer-muted leading-relaxed">
                    Lentera Quran adalah proyek wakaf digital. Bebas iklan dan gratis untuk seluruh umat.
                </div>
            </div>
        </div>

        <div class="mt-12 pt-6 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-label-sm text-footer-muted">
            <p>
                &copy; {{ date('Y') }} Lentera Quran. Hak Cipta Dilindungi Undang-Undang. Mengacu pada Mushaf Standar Indonesia {{ $translatorName }} ({{ $sourceName }}).
            </p>
            <div class="flex items-center gap-6">
                <span>Syarat Penggunaan</span>
                <span>Peta Situs</span>
                <span>Atribusi Data</span>
            </div>
        </div>
    </div>
</footer>
