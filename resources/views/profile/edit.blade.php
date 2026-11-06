<x-app-layout
    title="Pengaturan Profil"
    description="Informasi akun pengguna, kelola kontak, dan keamanan akun Lentera Quran Anda."
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
            default => 'Pengguna',
        };
    @endphp

    <div class="max-w-4xl mx-auto px-gutter-mobile md:px-gutter py-8 md:py-12 space-y-8">
        {{-- Tombol Kembali --}}
        <div class="flex items-center justify-end">
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

        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                class="rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/60 p-4 text-red-800 dark:text-red-200 text-body-sm flex items-start justify-between gap-3 shadow-xs"
            >
                <div class="flex items-start gap-3">
                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-red-100 dark:bg-red-900/60 text-red-600 shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </span>
                    <div class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="leading-relaxed font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                <button @click="show = false" type="button" aria-label="Tutup notifikasi" class="text-red-600 hover:text-red-800 transition p-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        {{-- Kartu Ringkasan Akun / Header Profil --}}
        <section class="rounded-[24px] bg-gradient-to-br from-surface-card via-surface-card to-surface-low border border-line shadow-card p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="relative shrink-0">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-brand-navy text-white text-display-mobile sm:text-display-sm font-bold flex items-center justify-center shadow-card border-2 border-brand-gold/60 ring-4 ring-brand-navy/10 select-none">
                    {{ $initials }}
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

        {{-- Kartu Bagian 1: Informasi Pengguna --}}
        <section class="rounded-[24px] bg-surface-card border border-line shadow-card p-6 sm:p-8 space-y-6">
            <header class="border-b border-line/70 pb-4">
                <h2 class="text-headline-sm font-bold text-ink">
                    Informasi Pengguna
                </h2>
                <p class="mt-1 text-body-sm text-ink-muted">
                    Data identitas dan alamat kontak yang terdaftar pada akun Anda.
                </p>
            </header>

            <div class="space-y-4">
                {{-- Baris Nama Lengkap --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 sm:p-5 rounded-2xl bg-surface-low border border-line">
                    <div class="space-y-1">
                        <span class="text-label-sm font-semibold text-ink-muted uppercase tracking-wider">Nama Lengkap</span>
                        <p class="text-headline-xs sm:text-headline-sm font-bold text-ink">
                            {{ $user->name }}
                        </p>
                        <p class="text-body-xs text-ink-muted">
                            Nama yang ditampilkan pada salam pembuka dan profil pengguna.
                        </p>
                    </div>

                    <button
                        type="button"
                        x-data=""
                        x-on:click="$dispatch('open-modal', 'modal-change-name')"
                        class="inline-flex items-center justify-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card hover:bg-surface-container border border-line text-body-sm font-semibold text-ink hover:text-brand-navy hover:border-brand-teal transition shadow-xs shrink-0 self-start sm:self-auto cursor-pointer"
                    >
                        <svg class="w-4 h-4 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        <span>Ubah Nama</span>
                    </button>
                </div>

                {{-- Baris Alamat Email --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 sm:p-5 rounded-2xl bg-surface-low border border-line">
                    <div class="space-y-1">
                        <span class="text-label-sm font-semibold text-ink-muted uppercase tracking-wider">Alamat Email</span>
                        <p class="text-headline-xs sm:text-headline-sm font-bold text-ink">
                            {{ $user->email }}
                        </p>
                        <p class="text-body-xs text-ink-muted">
                            Email digunakan untuk autentikasi masuk, menerima notifikasi, dan verifikasi keamanan.
                        </p>
                    </div>

                    <button
                        type="button"
                        x-data=""
                        x-on:click="$dispatch('open-modal', 'modal-change-email')"
                        class="inline-flex items-center justify-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card hover:bg-surface-container border border-line text-body-sm font-semibold text-ink hover:text-brand-navy hover:border-brand-teal transition shadow-xs shrink-0 self-start sm:self-auto cursor-pointer"
                    >
                        <svg class="w-4 h-4 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        <span>Ubah Email</span>
                    </button>
                </div>
            </div>
        </section>

        {{-- Kartu Bagian 2: Keamanan & Kata Sandi --}}
        <section class="rounded-[24px] bg-surface-card border border-line shadow-card p-6 sm:p-8 space-y-6">
            <header class="border-b border-line/70 pb-4">
                <h2 class="text-headline-sm font-bold text-ink">
                    Keamanan & Kata Sandi
                </h2>
                <p class="mt-1 text-body-sm text-ink-muted">
                    Pengaturan proteksi sandi akun untuk menjaga keamanan tilawah Anda.
                </p>
            </header>

            {{-- Baris Kata Sandi --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 sm:p-5 rounded-2xl bg-surface-low border border-line">
                <div class="space-y-1">
                    <span class="text-label-sm font-semibold text-ink-muted uppercase tracking-wider">Kata Sandi</span>
                    <p class="text-body-md font-bold text-ink tracking-widest">
                        ••••••••••••
                    </p>
                    <p class="text-body-xs text-ink-muted">
                        Demi perlindungan keamanan, perubahan kata sandi dilakukan melalui tautan konfirmasi yang dikirimkan ke email terdaftar Anda.
                    </p>
                </div>

                <button
                    type="button"
                    x-data=""
                    x-on:click="$dispatch('open-modal', 'modal-change-password')"
                    class="inline-flex items-center justify-center gap-2 min-h-[42px] px-5 py-2 rounded-full bg-surface-card hover:bg-surface-container border border-line text-body-sm font-semibold text-ink hover:text-brand-navy hover:border-brand-teal transition shadow-xs shrink-0 self-start sm:self-auto cursor-pointer"
                >
                    <svg class="w-4 h-4 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                    <span>Ubah Kata Sandi</span>
                </button>
            </div>
        </section>

        {{-- Kartu Bagian 3: Hapus Akun (Zona Bahaya) --}}
        <section class="rounded-[24px] bg-surface-card border border-red-200 dark:border-red-900/40 shadow-card p-6 sm:p-8 space-y-5">
            <header>
                <h2 class="text-headline-sm font-bold text-red-600 dark:text-red-400">
                    Hapus Akun
                </h2>
                <p class="mt-1 text-body-sm text-ink-muted">
                    Setelah akun Anda dihapus, seluruh data pengguna, riwayat tilawah, dan penanda bacaan akan dihapus secara permanen. Pastikan Anda telah mempertimbangkan sebelum melanjutkan.
                </p>
            </header>

            <div>
                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    <span>Hapus Akun Saya</span>
                </x-danger-button>
            </div>
        </section>

        {{-- MODAL 1: UBAH NAMA LENGKAP --}}
        <x-modal name="modal-change-name" focusable>
            <form method="POST" action="{{ route('profile.update-name') }}" class="p-6 sm:p-8 space-y-6">
                @csrf
                @method('put')

                <div class="space-y-1">
                    <h3 class="text-headline-sm font-bold text-ink">
                        Ubah Nama Lengkap
                    </h3>
                    <p class="text-body-sm text-ink-muted leading-relaxed">
                        Perbarui nama tampilan yang digunakan pada akun Lentera Quran Anda.
                    </p>
                </div>

                <div>
                    <x-input-label for="edit_name" value="Nama Lengkap Baru" />
                    <div class="relative mt-1.5 rounded-2xl bg-surface-low border border-line focus-within:border-brand-teal focus-within:ring-2 focus-within:ring-brand-teal/20 transition">
                        <input
                            id="edit_name"
                            name="name"
                            type="text"
                            value="{{ old('name', $user->name) }}"
                            required
                            maxlength="100"
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full bg-transparent border-0 px-4 py-3 text-body-sm text-ink placeholder-ink-muted focus:ring-0 focus:outline-none"
                        >
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Batal
                    </x-secondary-button>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 rounded-full bg-brand-gold hover:bg-[#a67a28] text-white font-semibold text-body-sm shadow-sm transition cursor-pointer"
                    >
                        Simpan Nama
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- MODAL 2: UBAH KATA SANDI (LEWAT TAUTAN EMAIL) --}}
        <x-modal name="modal-change-password" focusable>
            <form method="POST" action="{{ route('profile.send-password-reset-link') }}" x-data="{ sending: false }" @submit="sending = true" class="p-6 sm:p-8 space-y-6">
                @csrf

                <div class="space-y-1">
                    <h3 class="text-headline-sm font-bold text-ink">
                        Ubah Kata Sandi Akun
                    </h3>
                    <p class="text-body-sm text-ink-muted leading-relaxed">
                        Demi perlindungan keamanan akun Anda, pengubahan kata sandi memerlukan konfirmasi melalui email.
                    </p>
                </div>

                <div class="rounded-2xl bg-amber-50/70 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 p-4 text-body-sm text-ink space-y-2">
                    <div class="flex items-center gap-2 font-semibold text-amber-900 dark:text-amber-200">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        <span>Tautan Konfirmasi Email</span>
                    </div>
                    <p class="text-ink-muted leading-relaxed">
                        Kami akan mengirimkan tautan aman ke email Anda: <strong class="text-ink">{{ $user->email }}</strong>. Setelah mengeklik tautan tersebut, Anda dapat memasukkan kata sandi baru.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Batal
                    </x-secondary-button>

                    <button
                        type="submit"
                        :disabled="sending"
                        class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 rounded-full bg-brand-gold hover:bg-[#a67a28] text-white font-semibold text-body-sm shadow-sm transition disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer"
                    >
                        <template x-if="sending">
                            <span class="inline-flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Mengirim...</span>
                            </span>
                        </template>
                        <template x-if="!sending">
                            <span>Kirim Tautan ke Email</span>
                        </template>
                    </button>
                </div>
            </form>
        </x-modal>

        {{-- MODAL 3: UBAH EMAIL DENGAN VALIDASI KODE OTP --}}
        <x-modal name="modal-change-email" focusable>
            <div
                class="p-6 sm:p-8 space-y-6"
                x-data="{
                    step: 1,
                    newEmail: '',
                    otp: '',
                    loading: false,
                    errorMessage: '',
                    countdown: 0,
                    timer: null,
                    startTimer(seconds = 60) {
                        this.countdown = seconds;
                        if (this.timer) clearInterval(this.timer);
                        this.timer = setInterval(() => {
                            if (this.countdown > 0) {
                                this.countdown--;
                            } else {
                                clearInterval(this.timer);
                            }
                        }, 1000);
                    },
                    async submitSendOtp() {
                        this.errorMessage = '';
                        const val = (this.newEmail || '').trim().toLowerCase();
                        if (!val) {
                            this.errorMessage = 'Alamat email baru wajib diisi.';
                            return;
                        }
                        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9]+([.-][a-zA-Z0-9]+)*\.[a-zA-Z]{2,}$/;
                        if (!emailRegex.test(val)) {
                            this.errorMessage = 'Format alamat email tidak valid (contoh: nama@email.com).';
                            return;
                        }
                        if (val === '{{ strtolower($user->email) }}') {
                            this.errorMessage = 'Alamat email baru harus berbeda dari email Anda saat ini.';
                            return;
                        }

                        this.loading = true;
                        try {
                            const res = await fetch('{{ route('profile.email.send-otp') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ new_email: val })
                            });

                            const data = await res.json();
                            if (res.ok && data.success) {
                                this.step = 2;
                                this.startTimer(60);
                            } else {
                                this.errorMessage = data.message || 'Gagal mengirim kode OTP. Periksa alamat email Anda.';
                            }
                        } catch (e) {
                            this.errorMessage = 'Terjadi kesalahan jaringan. Silakan periksa koneksi Anda.';
                        } finally {
                            this.loading = false;
                        }
                    },
                    async submitVerifyOtp() {
                        this.errorMessage = '';
                        const val = (this.otp || '').trim().replace(/[^0-9]/g, '');
                        if (val.length !== 6) {
                            this.errorMessage = 'Kode OTP harus berupa 6 digit angka.';
                            return;
                        }

                        this.loading = true;
                        try {
                            const res = await fetch('{{ route('profile.email.verify-otp') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ otp: val })
                            });

                            const data = await res.json();
                            if (res.ok && data.success) {
                                window.location.reload();
                            } else {
                                this.errorMessage = data.message || 'Kode OTP salah atau telah kedaluwarsa.';
                            }
                        } catch (e) {
                            this.errorMessage = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                        } finally {
                            this.loading = false;
                        }
                    }
                }"
            >
                {{-- Langkah 1: Input Alamat Email Baru --}}
                <div x-show="step === 1" class="space-y-6">
                    <div class="space-y-1">
                        <h3 class="text-headline-sm font-bold text-ink">
                            Ubah Alamat Email
                        </h3>
                        <p class="text-body-sm text-ink-muted leading-relaxed">
                            Masukkan alamat email baru Anda. Kami akan mengirimkan kode OTP 6 digit untuk memastikan email valid dan aktif.
                        </p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-low border border-line text-body-xs text-ink-muted">
                        Email saat ini: <strong class="text-ink font-semibold">{{ $user->email }}</strong>
                    </div>

                    <div>
                        <x-input-label for="new_email_input" value="Alamat Email Baru" />
                        <div class="relative mt-1.5 rounded-2xl bg-surface-low border border-line focus-within:border-brand-teal focus-within:ring-2 focus-within:ring-brand-teal/20 transition">
                            <input
                                id="new_email_input"
                                type="email"
                                x-model="newEmail"
                                @keydown.enter.prevent="submitSendOtp()"
                                placeholder="nama@emailbaru.com"
                                class="w-full bg-transparent border-0 px-4 py-3 text-body-sm text-ink placeholder-ink-muted focus:ring-0 focus:outline-none"
                            >
                        </div>
                        <template x-if="errorMessage">
                            <p class="mt-2 text-label-sm text-red-600 font-medium" x-text="errorMessage"></p>
                        </template>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            Batal
                        </x-secondary-button>

                        <button
                            type="button"
                            @click="submitSendOtp()"
                            :disabled="loading"
                            class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 rounded-full bg-brand-gold hover:bg-[#a67a28] text-white font-semibold text-body-sm shadow-sm transition disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer"
                        >
                            <template x-if="loading">
                                <span class="inline-flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>Mengirim OTP...</span>
                                </span>
                            </template>
                            <template x-if="!loading">
                                <span>Kirim Kode OTP</span>
                            </template>
                        </button>
                    </div>
                </div>

                {{-- Langkah 2: Input Kode OTP --}}
                <div x-show="step === 2" style="display: none;" class="space-y-6">
                    <div class="space-y-1">
                        <h3 class="text-headline-sm font-bold text-ink">
                            Verifikasi Kode OTP
                        </h3>
                        <p class="text-body-sm text-ink-muted leading-relaxed">
                            Masukkan 6 digit kode OTP yang telah dikirimkan ke <strong class="text-ink" x-text="newEmail"></strong>.
                        </p>
                    </div>

                    <div>
                        <x-input-label for="otp_input" value="Kode OTP 6 Digit" />
                        <div class="mt-1.5 flex items-center rounded-2xl bg-surface-low border border-line focus-within:border-brand-teal focus-within:ring-2 focus-within:ring-brand-teal/20 transition">
                            <input
                                id="otp_input"
                                type="text"
                                maxlength="6"
                                x-model="otp"
                                @keydown.enter.prevent="submitVerifyOtp()"
                                placeholder="123456"
                                class="w-full bg-transparent border-0 text-center text-display-mobile tracking-[0.35em] font-mono font-bold text-brand-navy dark:text-ink py-3 focus:ring-0 focus:outline-none"
                            >
                        </div>
                        <template x-if="errorMessage">
                            <p class="mt-2 text-label-sm text-red-600 font-medium text-center" x-text="errorMessage"></p>
                        </template>

                        <div class="flex items-center justify-between text-body-xs text-ink-muted pt-3">
                            <span>Berlaku 10 menit</span>
                            <div>
                                <template x-if="countdown > 0">
                                    <span>Kirim ulang dalam <strong class="text-brand-gold font-bold" x-text="countdown"></strong>s</span>
                                </template>
                                <template x-if="countdown === 0">
                                    <button
                                        type="button"
                                        @click="submitSendOtp()"
                                        :disabled="loading"
                                        class="font-semibold text-brand-teal hover:underline cursor-pointer"
                                    >
                                        Kirim Ulang Kode OTP
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-2">
                        <button
                            type="button"
                            @click="step = 1; errorMessage = '';"
                            class="text-body-sm font-semibold text-ink-muted hover:text-ink transition cursor-pointer"
                        >
                            &larr; Ganti Email
                        </button>

                        <div class="flex items-center gap-2">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                Batal
                            </x-secondary-button>

                            <button
                                type="button"
                                @click="submitVerifyOtp()"
                                :disabled="loading"
                                class="inline-flex items-center justify-center min-h-[44px] px-6 py-2.5 rounded-full bg-brand-gold hover:bg-[#a67a28] text-white font-semibold text-body-sm shadow-sm transition disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer"
                            >
                                <template x-if="loading">
                                    <span class="inline-flex items-center gap-2">
                                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>Memverifikasi...</span>
                                    </span>
                                </template>
                                <template x-if="!loading">
                                    <span>Verifikasi & Simpan</span>
                                </template>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </x-modal>

        {{-- MODAL 4: HAPUS AKUN (KONFIRMASI SANDI) --}}
        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8 space-y-6" x-data="{ showModalPassword: false }">
                @csrf
                @method('delete')

                <div class="space-y-1">
                    <h3 class="text-headline-sm font-bold text-ink">
                        Apakah Anda yakin ingin menghapus akun?
                    </h3>
                    <p class="text-body-sm text-ink-muted leading-relaxed">
                        Tindakan ini tidak dapat dibatalkan. Masukkan kata sandi akun Anda untuk mengonfirmasi penghapusan secara permanen.
                    </p>
                </div>

                <div>
                    <x-input-label for="delete_password" value="Kata Sandi Anda" />
                    <div class="relative mt-1.5 flex items-center rounded-2xl bg-surface-low border border-line focus-within:border-red-500 focus-within:ring-2 focus-within:ring-red-500/20 transition">
                        <input
                            id="delete_password"
                            name="password"
                            :type="showModalPassword ? 'text' : 'password'"
                            placeholder="Masukkan kata sandi untuk konfirmasi"
                            class="w-full bg-transparent border-0 px-4 py-3 text-body-sm text-ink placeholder-ink-muted focus:ring-0 focus:outline-none"
                        >
                        <button
                            type="button"
                            @click="showModalPassword = !showModalPassword"
                            class="pr-4 text-ink-muted hover:text-ink transition focus:outline-none"
                            aria-label="Tampilkan atau sembunyikan kata sandi"
                        >
                            <svg x-show="!showModalPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg x-show="showModalPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Batal
                    </x-secondary-button>

                    <x-danger-button>
                        Ya, Hapus Akun
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>
