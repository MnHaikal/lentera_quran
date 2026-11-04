<x-guest-layout title="Verifikasi Kode OTP" description="Masukkan 6 digit kode OTP untuk mengaktifkan akun Lentera Quran Anda.">
    <div class="text-center mb-6">
        <h1 class="text-headline-md font-bold text-brand-navy dark:text-ink">
            Verifikasi Alamat Email
        </h1>
        <p class="mt-2 text-body-sm text-ink-muted leading-relaxed">
            Untuk memastikan alamat email Anda valid, kami telah mengirimkan 6 digit kode OTP ke:
        </p>
        <div class="mt-2.5 inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-low border border-line text-brand-navy dark:text-ink font-semibold text-body-sm">
            <svg class="w-4 h-4 text-brand-teal shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
            </svg>
            <span class="truncate max-w-[260px] sm:max-w-xs">{{ $email }}</span>
        </div>
    </div>

    {{-- Error Alert --}}
    @if ($errors->has('otp'))
        <div class="mb-5 p-3.5 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-body-sm flex items-start gap-2.5">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            <span class="leading-relaxed">{{ $errors->first('otp') }}</span>
        </div>
    @endif

    {{-- Form Verifikasi OTP yang Andal & Responsif --}}
    <div
        x-data="{
            otp: @js(old('otp', '')),
            remaining: {{ $remainingSeconds ?? 600 }},
            resendCooldown: 45,
            submitting: false,
            init() {
                this.$nextTick(() => {
                    this.$refs.otpInput?.focus();
                });

                // Countdown Timer untuk Masa Berlaku OTP
                setInterval(() => {
                    if (this.remaining > 0) this.remaining--;
                    if (this.resendCooldown > 0) this.resendCooldown--;
                }, 1000);
            },
            formatTime(seconds) {
                const m = Math.floor(seconds / 60);
                const s = seconds % 60;
                return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
            },
            handleInput(e) {
                // Hanya angka, maksimal 6 digit
                const val = (e.target.value || '').replace(/[^0-9]/g, '').slice(0, 6);
                this.otp = val;
                e.target.value = val;

                // Otomatis submit jika 6 digit sudah terisi lengkap
                if (val.length === 6 && !this.submitting) {
                    this.submitting = true;
                    this.$refs.verifyForm.submit();
                }
            }
        }"
        class="space-y-6"
    >
        <form
            x-ref="verifyForm"
            method="POST"
            action="{{ route('register.otp.verify') }}"
            class="space-y-6"
            @submit="submitting = true"
        >
            @csrf

            <div>
                <label for="otp-input" class="block text-center text-label-md font-bold text-brand-navy dark:text-ink mb-3">
                    Masukkan 6 Digit Kode
                </label>

                {{-- Container 6 Kotak Digit Terhubung Langsung ke Input Asli --}}
                <div class="relative max-w-sm mx-auto" @click="$refs.otpInput?.focus()">
                    {{-- Input Asli yang Menerima Ketikan & Paste (Berada tepat di atas kotak secara transparan) --}}
                    <input
                        x-ref="otpInput"
                        id="otp-input"
                        type="text"
                        name="otp"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        maxlength="6"
                        autocomplete="one-time-code"
                        autofocus
                        :value="otp"
                        @input="handleInput($event)"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-text z-20"
                    >

                    {{-- 6 Kotak Visual yang Menampilkan Setiap Angka --}}
                    <div class="flex items-center justify-center gap-2 sm:gap-3 pointer-events-none select-none">
                        <template x-for="i in [0, 1, 2, 3, 4, 5]" :key="i">
                            <div
                                class="w-11 h-14 sm:w-13 sm:h-16 flex items-center justify-center text-2xl font-bold font-mono rounded-xl bg-surface-card border-2 shadow-sm transition"
                                :class="{
                                    'border-brand-teal bg-brand-teal/5 text-brand-navy dark:text-white': otp.length > i,
                                    'border-brand-teal ring-2 ring-brand-teal/30 bg-white dark:bg-surface-card': otp.length === i,
                                    'border-line text-ink-muted': otp.length < i
                                }"
                            >
                                <span x-text="otp[i] || ''"></span>
                                {{-- Kursor berkedip pada digit yang sedang aktif --}}
                                <template x-if="otp.length === i">
                                    <span class="inline-block w-0.5 h-6 bg-brand-teal animate-pulse"></span>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Indikator Waktu Kedaluwarsa --}}
                <div class="mt-4 text-center text-label-sm text-ink-muted">
                    <template x-if="remaining > 0">
                        <span>Kode berlaku selama: <strong class="text-brand-gold font-mono font-bold" x-text="formatTime(remaining)">10:00</strong></span>
                    </template>
                    <template x-if="remaining <= 0">
                        <span class="text-red-500 font-semibold">Kode OTP telah kedaluwarsa. Silakan minta kode baru.</span>
                    </template>
                </div>
            </div>

            {{-- Tombol Verifikasi (Warna Emas sesuai Halaman Daftar) --}}
            <button
                type="submit"
                :disabled="otp.length !== 6 || submitting"
                class="w-full min-h-[50px] rounded-full bg-brand-gold hover:bg-brand-gold-hover text-brand-navy text-body-md font-bold shadow-sm inline-flex items-center justify-center gap-2 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-navy focus-visible:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <template x-if="submitting">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-brand-navy" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <span x-text="submitting ? 'Memverifikasi...' : 'Verifikasi Akun'">Verifikasi Akun</span>
            </button>
        </form>

        {{-- Kirim Ulang OTP & Navigasi Batal --}}
        <div class="pt-4 border-t border-line/70 flex flex-col items-center gap-3 text-center">
            <form method="POST" action="{{ route('register.otp.resend') }}" class="inline">
                @csrf
                <p class="text-body-sm text-ink-muted">
                    Tidak menerima kode di kotak masuk?
                    <button
                        type="submit"
                        :disabled="resendCooldown > 0"
                        class="text-brand-teal hover:underline font-bold ml-1 disabled:opacity-50 disabled:no-underline disabled:cursor-not-allowed"
                    >
                        <span>Kirim Ulang</span>
                        <span x-show="resendCooldown > 0">(<span x-text="resendCooldown"></span>s)</span>
                    </button>
                </p>
            </form>

            <p class="text-body-sm text-ink-muted">
                Salah alamat email?
                <a
                    href="{{ route('register') }}"
                    wire:navigate
                    class="font-bold text-brand-teal hover:underline ms-1"
                >
                    Kembali ke form pendaftaran
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
