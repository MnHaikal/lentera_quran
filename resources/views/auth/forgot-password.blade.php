<x-guest-layout title="Lupa Kata Sandi" description="Atur ulang kata sandi akun Lentera Quran Anda.">
    <div class="mb-6">
        <h1 class="text-headline-md font-bold text-brand-navy dark:text-ink">
            Lupa Kata Sandi
        </h1>
        <p class="mt-1.5 text-body-sm text-ink-muted leading-relaxed">
            Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form
        method="POST"
        action="{{ route('password.email') }}"
        novalidate
        x-data="{
            submitting: false,
            email: @js(old('email', '')),
            emailError: @js($errors->first('email') ?: ''),
            emailTouched: false,
            validateEmail() {
                const val = (this.email || '').trim();
                if (!val) {
                    this.emailError = 'Alamat email wajib diisi.';
                    return false;
                }
                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9]+([.-][a-zA-Z0-9]+)*\.[a-zA-Z]{2,}$/;
                if (!emailRegex.test(val)) {
                    this.emailError = 'Format alamat email tidak valid (contoh: nama@email.com).';
                    return false;
                }
                this.emailError = '';
                return true;
            },
            handleSubmit(e) {
                this.emailTouched = true;
                const emailOk = this.validateEmail();
                if (!emailOk) {
                    e.preventDefault();
                    this.submitting = false;
                    this.$refs.emailInput?.focus();
                    return false;
                }
                this.submitting = true;
            }
        }"
        @submit="handleSubmit($event)"
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
                    x-ref="emailInput"
                    id="email"
                    type="email"
                    name="email"
                    x-model="email"
                    @blur="emailTouched = true; validateEmail()"
                    @input="if (emailTouched || emailError) validateEmail()"
                    placeholder="nama@email.com"
                    maxlength="150"
                    required
                    autofocus
                    autocomplete="email"
                    :aria-invalid="emailError ? 'true' : 'false'"
                    aria-describedby="email-error"
                    :class="emailError ? 'border-red-500 focus:border-red-500 focus:shadow-[0_0_0_3px_rgba(239,68,68,0.2)]' : 'border-line focus:border-brand-teal focus:shadow-teal-ring'"
                    class="w-full min-h-[48px] rounded-xl bg-surface-card border pl-11 pr-4 py-3 text-body-md text-ink placeholder-ink-muted/70 transition focus:ring-0 focus:outline-none"
                >
            </div>
            
            {{-- Peringatan Kesalahan Format Email --}}
            <div id="email-error" class="mt-2 min-h-[20px]">
                <template x-if="emailError">
                    <p class="text-xs text-red-600 dark:text-red-400 font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span x-text="emailError"></span>
                    </p>
                </template>
                @if ($errors->has('email'))
                    <noscript>
                        <p class="text-xs text-red-600 dark:text-red-400 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span>{{ $errors->first('email') }}</span>
                        </p>
                    </noscript>
                @endif
            </div>
        </div>

        <div class="pt-1">
            <button
                type="submit"
                :disabled="submitting"
                class="w-full min-h-[50px] rounded-full bg-brand-gold hover:bg-brand-gold-hover text-brand-navy text-body-md font-bold shadow-sm inline-flex items-center justify-center gap-2 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-navy focus-visible:ring-offset-2 disabled:opacity-70 disabled:cursor-not-allowed"
            >
                <span x-text="submitting ? 'Mengirim...' : 'Kirim Tautan Reset'">Kirim Tautan Reset</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>

        <div class="pt-2 text-center">
            <a
                href="{{ route('login') }}"
                wire:navigate
                class="inline-flex items-center justify-center min-h-[44px] text-body-sm font-semibold text-brand-teal hover:underline rounded focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-gold"
            >
                &larr; Kembali ke halaman masuk
            </a>
        </div>
    </form>
</x-guest-layout>
