<section class="space-y-6" x-data="{ submitting: false }">
    <header class="flex items-start justify-between gap-4">
        <div>
            <h2 class="text-headline-sm font-bold text-ink">
                Informasi Profil
            </h2>
            <p class="mt-1 text-body-sm text-ink-muted">
                Perbarui nama lengkap dan alamat email yang digunakan untuk masuk ke akun Anda.
            </p>
        </div>
        <div class="w-10 h-10 rounded-2xl bg-brand-teal/10 text-brand-teal flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        </div>
    </header>

    @if (session('status') === 'profile-updated')
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 p-4 text-emerald-800 dark:text-emerald-200 text-body-sm flex items-center justify-between gap-3 shadow-xs"
        >
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">Profil Anda berhasil diperbarui.</span>
            </div>
            <button @click="show = false" type="button" aria-label="Tutup pemberitahuan" class="text-emerald-600 hover:text-emerald-800 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" @submit="submitting = true" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <div class="relative mt-1.5 flex items-center rounded-2xl bg-surface-low border border-line focus-within:border-brand-teal focus-within:ring-2 focus-within:ring-brand-teal/20 transition">
                <span class="pl-4 text-ink-muted">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </span>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Masukkan nama lengkap Anda"
                    class="w-full bg-transparent border-0 px-3.5 py-3 text-body-sm text-ink placeholder-ink-muted focus:ring-0 focus:outline-none"
                >
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Alamat Email" />
            <div class="relative mt-1.5 flex items-center rounded-2xl bg-surface-low border border-line focus-within:border-brand-teal focus-within:ring-2 focus-within:ring-brand-teal/20 transition">
                <span class="pl-4 text-ink-muted">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </span>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="username"
                    placeholder="nama@email.com"
                    class="w-full bg-transparent border-0 px-3.5 py-3 text-body-sm text-ink placeholder-ink-muted focus:ring-0 focus:outline-none"
                >
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 text-amber-800 dark:text-amber-200 text-body-sm">
                    <p class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span>Alamat email Anda belum diverifikasi.</span>
                        <button form="send-verification" class="underline font-semibold hover:text-amber-900 transition ml-1">
                            Kirim ulang email verifikasi
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-label-md font-semibold text-emerald-700 dark:text-emerald-300">
                            Tautan verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="pt-2">
            <button
                type="submit"
                :disabled="submitting"
                class="inline-flex items-center justify-center min-h-[46px] px-7 py-2.5 rounded-full bg-brand-gold hover:bg-[#a67a28] text-white font-semibold text-body-sm shadow-sm transition disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer"
            >
                <template x-if="submitting">
                    <svg class="animate-spin w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <template x-if="!submitting">
                    <span>Simpan Perubahan</span>
                </template>
            </button>
        </div>
    </form>
</section>
