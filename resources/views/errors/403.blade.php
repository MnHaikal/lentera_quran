<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | Lentera Qur'an</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF7F0] text-[#1C1C15] antialiased min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl border border-[#EAE3D2] p-8 text-center shadow-sm">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-2xl font-bold">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold text-[#001833] tracking-tight mb-2">403</h1>
        <h2 class="text-lg font-bold text-[#1C1C15] mb-2">Akses Ditolak</h2>
        <p class="text-sm text-[#43474E] mb-6">
            Mohon maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Halaman ini diproteksi khusus untuk Administrator.
        </p>
        <div class="flex flex-col sm:flex-row gap-2 justify-center">
            <a href="{{ route('beranda') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-[#001833] text-white text-sm font-semibold hover:bg-[#0F2D4F] transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
