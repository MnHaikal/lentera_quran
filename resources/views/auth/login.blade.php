<x-guest-layout title="Masuk" description="Masuk ke akun Lentera Quran Anda untuk melanjutkan tilawah.">
    <div class="mb-6">
        <span class="sr-only">Masuk Akun</span>
        <h1 class="text-headline-md font-bold text-brand-navy dark:text-ink">
            Selamat Datang Kembali
        </h1>
        <p class="mt-1.5 text-body-sm text-ink-muted leading-relaxed">
            Masuk ke akun Lentera Quran Anda untuk melanjutkan tilawah.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form
        method="POST"
        action="{{ route('login') }}"
        x-data="{ showPassword: false }"
        class="space-y-5"
    >
        @csrf

        <div>
            <label for="email" class="block text-label-md font-bold text-brand-navy dark:text-ink mb-2">
                Alamat Email
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-ink-muted">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </span>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@email.com"
                    required
                    autofocus
                    autocomplete="username"
                    class="w-full min-h-[48px] rounded-xl bg-surface-card border border-line pl-11 pr-4 py-3 text-body-md text-ink placeholder-ink-muted/70 transition focus:border-brand-teal focus:ring-0 focus:shadow-teal-ring focus:outline-none"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-label-md font-bold text-brand-navy dark:text-ink mb-2">
                Kata Sandi
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-ink-muted">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </span>
                <input
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                    class="w-full min-h-[48px] rounded-xl bg-surface-card border border-line pl-11 pr-11 py-3 text-body-md text-ink placeholder-ink-muted/70 transition focus:border-brand-teal focus:ring-0 focus:shadow-teal-ring focus:outline-none"
                >
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-ink-muted hover:text-ink transition"
                >
                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="showPassword" style="display: none;" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-0.5">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="w-4 h-4 rounded border-line text-brand-teal focus:ring-brand-teal"
                >
                <span class="ms-2.5 text-body-sm text-ink-muted">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    wire:navigate
                    class="text-body-sm font-semibold text-brand-teal hover:underline rounded focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
                >
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <div class="pt-1">
            <button
                type="submit"
                class="w-full min-h-[50px] rounded-full bg-brand-gold hover:bg-brand-gold-hover text-brand-navy text-body-md font-bold shadow-sm inline-flex items-center justify-center gap-2 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-navy focus-visible:ring-offset-2"
            >
                <span>Masuk ke Akun</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>

        @if (Route::has('register'))
            <p class="pt-3 text-center text-body-sm text-ink-muted">
                Belum punya akun?
                <a
                    href="{{ route('register') }}"
                    wire:navigate
                    class="font-semibold text-brand-teal hover:underline ms-1"
                >
                    Daftar Sekarang (Gratis)
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>
