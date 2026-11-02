<x-guest-layout title="Lupa Kata Sandi" description="Atur ulang kata sandi akun Lentera Quran Anda.">
    <div class="mb-4">
        <h1 class="text-headline-md text-ink">Lupa Kata Sandi</h1>
        <p class="mt-1 text-body-sm text-ink-muted">
            {{ __('Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.') }}
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <a
                href="{{ route('login') }}"
                wire:navigate
                class="inline-flex items-center min-h-[44px] text-body-sm text-ink-muted hover:text-brand-teal rounded focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
            >
                &larr; Kembali ke halaman masuk
            </a>

            <x-primary-button class="w-full sm:w-auto">
                {{ __('Kirim Tautan Reset') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
