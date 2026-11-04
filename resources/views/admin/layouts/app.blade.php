<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Super Admin Dashboard — Lentera Quran')</title>

    <script>
        document.documentElement.classList.remove('dark');
        try { localStorage.removeItem('lq_theme'); } catch (e) {}
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body
    x-data="{
        sidebarOpen: false,
        activeRange: '30d'
    }"
    class="min-h-screen bg-[#FAF6EC] dark:bg-[#071526] text-[#1E2B3A] dark:text-[#FFFBF0] font-sans antialiased selection:bg-brand-gold selection:text-brand-navy"
>
    <div class="min-h-screen flex flex-col lg:flex-row">
        {{-- Mobile Top Bar --}}
        @include('admin.partials.mobile-topbar')

        {{-- Left Sidebar (Deep Navy) --}}
        @include('admin.partials.sidebar')

        {{-- Right Main Workspace --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Header Bar --}}
            @include('admin.partials.topbar')

            {{-- Main Content Container --}}
            <main class="flex-1 px-5 sm:px-7 py-4 sm:py-5 space-y-4 max-w-[1280px] w-full mx-auto">
                @yield('content')
            </main>

            {{-- Bottom Copyright Line --}}
            @include('admin.partials.footer')
        </div>
    </div>

    @stack('modals')
    @livewireScripts
</body>
</html>
