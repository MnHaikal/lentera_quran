<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan | Lentera Qur'an</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF7F0] text-[#1C1C15] antialiased min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl border border-[#EAE3D2] p-8 text-center shadow-sm">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold text-[#001833] tracking-tight mb-2">404</h1>
        <h2 class="text-lg font-bold text-[#1C1C15] mb-2">Halaman Tidak Ditemukan</h2>
        <p class="text-sm text-[#43474E] mb-6">
            Halaman, surah, atau bacaan yang Anda cari tidak tersedia atau tautan telah dipindahkan.
        </p>
        <div class="flex flex-col sm:flex-row gap-2 justify-center">
            <a href="{{ route('beranda') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-[#001833] text-white text-sm font-semibold hover:bg-[#0F2D4F] transition">
                Kembali ke Beranda
            </a>
            <a href="{{ route('quran.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-white border border-[#EAE3D2] text-[#001833] text-sm font-semibold hover:bg-[#FAF7F0] transition">
                Daftar Surah
            </a>
        </div>
    </div>
</body>
</html>
