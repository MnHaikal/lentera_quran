<x-guest-layout title="Verifikasi Email" description="Verifikasi alamat email akun Lentera Quran Anda.">
    <div class="mb-6">
        <h1 class="text-headline-md font-bold text-brand-navy dark:text-ink">
            Verifikasi Alamat Email
        </h1>
        <p class="mt-1.5 text-body-sm text-ink-muted leading-relaxed">
            Terima kasih telah mendaftar di Lentera Quran! Sebelum memulai, silakan periksa kotak masuk email Anda dan klik tautan verifikasi yang telah kami kirimkan.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 p-4 text-emerald-800 dark:text-emerald-200 text-body-sm flex items-start gap-3 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium leading-relaxed">
                Tautan verifikasi baru telah berhasil dikirim ke alamat email yang Anda gunakan saat mendaftar.
            </span>
        </div>
    @endif

    <div class="space-y-4" x-data="{ submitting: false }">
        <form method="POST" action="{{ route('verification.send') }}" @submit="submitting = true">
            @csrf

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
                    <span>Kirim Ulang Email Verifikasi</span>
                </template>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center pt-2">
            @csrf

            <button
                type="submit"
                class="inline-flex items-center gap-1.5 text-body-sm text-red-600 hover:text-red-700 transition font-semibold"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                <span>Keluar dari Akun</span>
            </button>
        </form>
    </div>
</x-guest-layout>
