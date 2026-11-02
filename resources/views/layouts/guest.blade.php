@php
    $isLogin = request()->routeIs('login');
    $isRegister = request()->routeIs('register');
    $showAuthTabs = $isLogin || $isRegister;
@endphp

<x-app-layout :title="$title ?? 'Autentikasi'" :description="$description">
    <section class="max-w-browse mx-auto px-gutter-mobile md:px-gutter py-10 md:py-16 flex flex-col items-center justify-center min-h-[76vh]">
        <div class="w-full max-w-[490px] rounded-[24px] bg-surface-card border border-line shadow-card p-7 sm:p-10">
            @if ($showAuthTabs)
                <div class="rounded-full bg-surface-low border border-line/60 p-1.5 grid grid-cols-2 gap-1.5 mb-8" role="tablist" aria-label="Pilih mode autentikasi">
                    <a
                        href="{{ route('login') }}"
                        wire:navigate
                        role="tab"
                        aria-selected="{{ $isLogin ? 'true' : 'false' }}"
                        class="inline-flex items-center justify-center gap-2 min-h-[42px] px-4 py-2 rounded-full text-body-sm transition {{ $isLogin ? 'bg-brand-navy text-white font-semibold shadow-sm' : 'text-ink-muted hover:text-ink font-medium' }}"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        <span>Masuk</span>
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            wire:navigate
                            role="tab"
                            aria-selected="{{ $isRegister ? 'true' : 'false' }}"
                            class="inline-flex items-center justify-center gap-2 min-h-[42px] px-4 py-2 rounded-full text-body-sm transition {{ $isRegister ? 'bg-brand-navy text-white font-semibold shadow-sm' : 'text-ink-muted hover:text-ink font-medium' }}"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                            </svg>
                            <span>Daftar Akun Baru</span>
                        </a>
                    @endif
                </div>
            @endif

            {{ $slot }}
        </div>
    </section>
</x-app-layout>
