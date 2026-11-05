<x-app-layout
    title="Pengaturan Profil"
    description="Kelola informasi akun, perbarui kata sandi, dan atur keamanan akun Lentera Quran Anda."
>
    @php
        $initials = collect(explode(' ', trim($user->name)))
            ->filter()
            ->take(2)
            ->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->join('');
        if ($initials === '') {
            $initials = 'LQ';
        }

        $roleLabel = match ($user->role) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            default => 'Jamaah / Pengguna',
        };
    @endphp

    <div class="max-w-4xl mx-auto px-gutter-mobile md:px-gutter py-8 md:py-12 space-y-8">
        {{-- Navigasi Balik / Breadcrumb --}}
        <div class="flex items-center justify-between gap-4">
            <nav class="flex items-center gap-2 text-label-md text-ink-muted" aria-label="Breadcrumb">
                <a href="{{ route('beranda') }}" wire:navigate class="hover:text-ink transition">Beranda</a>
                <span class="text-ink-muted/50">/</span>
                <span class="text-ink font-semibold">Pengaturan Profil</span>
            </nav>

            <a
                href="{{ route('beranda') }}"
                wire:navigate
                class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-surface-card border border-line text-body-sm font-semibold text-ink hover:border-brand-teal transition shadow-xs"
            >
                <svg class="w-4 h-4 text-ink-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        {{-- Kartu Ringkasan Akun / Header Profil --}}
        <section class="rounded-[24px] bg-gradient-to-br from-surface-card via-surface-card to-surface-low border border-line shadow-card p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="relative shrink-0">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-brand-navy text-white text-display-mobile sm:text-display-sm font-bold flex items-center justify-center shadow-card border-2 border-brand-gold/60 ring-4 ring-brand-navy/10 select-none">
                    {{ $initials }}
                </div>
                <div class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-white shadow-xs" title="Akun Aktif">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
            </div>

            <div class="flex-1 text-center sm:text-left space-y-2">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                    <h1 class="text-headline-sm sm:text-headline-md font-bold text-ink tracking-tight">
                        {{ $user->name }}
                    </h1>
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-label-sm font-bold uppercase tracking-wider {{ $user->role === 'super_admin' ? 'bg-brand-navy text-brand-gold' : ($user->role === 'admin' ? 'bg-brand-teal text-white' : 'bg-surface-low border border-line text-ink-muted') }}">
                        {{ $roleLabel }}
                    </span>
                </div>

                <p class="text-body-sm text-ink-muted flex items-center justify-center sm:justify-start gap-2">
                    <svg class="w-4 h-4 text-ink-muted shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <span>{{ $user->email }}</span>
                </p>

                <p class="text-label-sm text-ink-muted pt-1">
                    Bergabung sejak {{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}
                </p>
            </div>
        </section>

        {{-- Form Bagian 1: Informasi Profil --}}
        <div class="rounded-[24px] bg-surface-card border border-line shadow-card p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- Form Bagian 2: Perbarui Kata Sandi --}}
        <div class="rounded-[24px] bg-surface-card border border-line shadow-card p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        {{-- Form Bagian 3: Hapus Akun (Zona Bahaya) --}}
        <div class="rounded-[24px] bg-surface-card border border-red-200 dark:border-red-900/40 shadow-card p-6 sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
