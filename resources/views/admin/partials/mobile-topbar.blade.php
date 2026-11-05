{{-- Mobile Top Bar --}}
<div class="lg:hidden sticky top-0 z-40 flex items-center justify-between bg-[#0B2239] text-white px-4 py-3 border-b border-white/10 shadow-xs">
    {{-- Profile Super Admin (Sebelah Kiri) --}}
    <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-full bg-[#1C5868] border border-[#4AB3BF]/40 flex items-center justify-center text-xs font-bold text-white shrink-0">
            {{ strtoupper(substr(Auth::user()?->name ?? 'SA', 0, 2)) }}
        </div>
        <div class="leading-tight">
            <p class="text-xs font-bold text-white">{{ Auth::user()?->name ?? 'Super Admin' }}</p>
            <p class="text-[10px] text-[#7CE3B3] font-bold uppercase">{{ Auth::user()?->role?->isSuperAdmin() ? 'Super Admin' : 'Admin' }}</p>
        </div>
    </div>

    {{-- Menu Button (Sebelah Kanan) --}}
    <div class="flex items-center">
        <button
            type="button"
            @click="sidebarOpen = !sidebarOpen"
            class="p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10"
            aria-label="Buka menu navigasi admin"
        >
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</div>
