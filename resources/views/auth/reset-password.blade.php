<x-guest-layout title="Atur Ulang Kata Sandi" description="Buat kata sandi baru untuk akun Lentera Quran Anda.">
    <div class="mb-6">
        <h1 class="text-headline-md font-bold text-brand-navy dark:text-ink">
            Atur Ulang Kata Sandi
        </h1>
        <p class="mt-1.5 text-body-sm text-ink-muted leading-relaxed">
            Masukkan kata sandi baru minimal 8 karakter untuk mengamankan akun Lentera Quran Anda.
        </p>
    </div>

    <form
        method="POST"
        action="{{ route('password.store') }}"
        x-data="{ showPassword: false, showConfirmPassword: false, submitting: false }"
        @submit="submitting = true"
        class="space-y-4"
    >
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') ?? old('token', $request->token) }}">

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
                    value="{{ old('email', $request->email) }}"
                    placeholder="nama@email.com"
                    maxlength="150"
                    required
                    readonly
                    tabindex="-1"
                    autocomplete="username"
                    @if ($errors->has('email')) aria-invalid="true" aria-describedby="email-error" @endif
                    class="w-full min-h-[48px] rounded-xl bg-surface-low border border-line pl-11 pr-4 py-3 text-body-md text-ink-muted cursor-not-allowed select-none focus:outline-none"
                >
            </div>
            <x-input-error id="email-error" :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-label-md font-bold text-brand-navy dark:text-ink mb-2">
                Kata Sandi Baru
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
                    placeholder="Minimal 8 karakter"
                    minlength="8"
                    maxlength="64"
                    required
                    autofocus
                    autocomplete="new-password"
                    @if ($errors->has('password')) aria-invalid="true" aria-describedby="password-error" @endif
                    class="w-full min-h-[48px] rounded-xl bg-surface-card border border-line pl-11 pr-11 py-3 text-body-md text-ink placeholder-ink-muted/70 transition focus:border-brand-teal focus:ring-0 focus:shadow-teal-ring focus:outline-none"
                >
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                    :aria-pressed="showPassword.toString()"
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
            <x-input-error id="password-error" :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-label-md font-bold text-brand-navy dark:text-ink mb-2">
                Konfirmasi Kata Sandi Baru
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-ink-muted">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </span>
                <input
                    id="password_confirmation"
                    :type="showConfirmPassword ? 'text' : 'password'"
                    name="password_confirmation"
                    placeholder="Ulangi kata sandi baru"
                    minlength="8"
                    maxlength="64"
                    required
                    autocomplete="new-password"
                    @if ($errors->has('password_confirmation')) aria-invalid="true" aria-describedby="password-confirmation-error" @endif
                    class="w-full min-h-[48px] rounded-xl bg-surface-card border border-line pl-11 pr-11 py-3 text-body-md text-ink placeholder-ink-muted/70 transition focus:border-brand-teal focus:ring-0 focus:shadow-teal-ring focus:outline-none"
                >
                <button
                    type="button"
                    @click="showConfirmPassword = !showConfirmPassword"
                    :aria-label="showConfirmPassword ? 'Sembunyikan konfirmasi kata sandi' : 'Tampilkan konfirmasi kata sandi'"
                    :aria-pressed="showConfirmPassword.toString()"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-ink-muted hover:text-ink transition"
                >
                    <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="showConfirmPassword" style="display: none;" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error id="password-confirmation-error" :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button
                type="submit"
                :disabled="submitting"
                class="w-full min-h-[50px] rounded-full bg-brand-gold hover:bg-brand-gold-hover text-brand-navy text-body-md font-bold shadow-sm inline-flex items-center justify-center transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-navy focus-visible:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed"
            >
                <template x-if="submitting">
                    <svg class="animate-spin w-5 h-5 text-brand-navy" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <span x-show="!submitting">Simpan Kata Sandi Baru</span>
            </button>
        </div>
    </form>
</x-guest-layout>
