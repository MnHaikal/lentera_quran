<x-guest-layout title="Konfirmasi Kata Sandi" description="Konfirmasi kata sandi Anda untuk melanjutkan ke area aman.">
    <div class="mb-6">
        <h1 class="text-headline-md font-bold text-brand-navy dark:text-ink">
            Konfirmasi Kata Sandi
        </h1>
        <p class="mt-1.5 text-body-sm text-ink-muted leading-relaxed">
            Ini adalah area yang aman. Silakan masukkan kata sandi akun Lentera Quran Anda untuk melanjutkan.
        </p>
    </div>

    <form
        method="POST"
        action="{{ route('password.confirm') }}"
        x-data="{
            showPassword: false,
            submitting: false,
        }"
        @submit="submitting = true"
        class="space-y-5"
    >
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Kata Sandi" />

            <div class="relative mt-1.5 flex items-center rounded-2xl bg-surface-low border border-line focus-within:border-brand-teal focus-within:ring-2 focus-within:ring-brand-teal/20 transition">
                <span class="pl-4 text-ink-muted">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </span>

                <input
                    id="password"
                    name="password"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan kata sandi akun Anda"
                    class="w-full bg-transparent border-0 px-3.5 py-3 text-body-sm text-ink placeholder-ink-muted focus:ring-0 focus:outline-none"
                >

                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="pr-4 text-ink-muted hover:text-ink transition focus:outline-none"
                    aria-label="Tampilkan atau sembunyikan kata sandi"
                >
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button
            type="submit"
            :disabled="submitting"
            class="w-full inline-flex items-center justify-center min-h-[48px] px-6 py-3 rounded-full bg-brand-gold hover:bg-[#a67a28] text-white font-semibold text-body-sm shadow-sm transition disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer"
        >
            <template x-if="submitting">
                <svg class="animate-spin w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </template>
            <template x-if="!submitting">
                <span>Konfirmasi Kata Sandi</span>
            </template>
        </button>

        <div class="text-center pt-2">
            <a
                href="{{ route('beranda') }}"
                wire:navigate
                class="inline-flex items-center gap-1.5 text-body-sm text-ink-muted hover:text-ink transition font-medium"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </form>
</x-guest-layout>
