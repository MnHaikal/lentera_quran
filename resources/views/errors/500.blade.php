<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Terjadi Kesalahan Server | Lentera Qur'an</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF7F0] text-[#1C1C15] antialiased min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl border border-[#EAE3D2] p-8 text-center shadow-sm">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-2xl font-bold">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold text-[#001833] tracking-tight mb-2">500</h1>
        <h2 class="text-lg font-bold text-[#1C1C15] mb-2">Terjadi Kendala pada Server</h2>
        <p class="text-sm text-[#43474E] mb-6">
            Mohon maaf, sistem sedang mengalami kendala teknis sementara. Silakan coba muat ulang beberapa saat lagi.
        </p>
        <div class="flex flex-col sm:flex-row gap-2 justify-center">
            <a href="{{ route('beranda') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-[#001833] text-white text-sm font-semibold hover:bg-[#0F2D4F] transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>

