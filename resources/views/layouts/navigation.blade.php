<nav x-data="{ open: false }" class="bg-white border-b border-emerald-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('beranda') }}" wire:navigate class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-emerald-600">📖 Lentera Quran</span>
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex">
                    <a href="{{ route('beranda') }}" wire:navigate wire:navigate.hover
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('beranda') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Beranda
                    </a>
                    <a href="{{ route('quran.index') }}" wire:navigate wire:navigate.hover
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('quran.*') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Al-Qur'an
                    </a>
                    <a href="{{ route('tahlil.index') }}" wire:navigate wire:navigate.hover
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('tahlil.*') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Tahlil
                    </a>
                    <a href="{{ route('doa.index') }}" wire:navigate wire:navigate.hover
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('doa.*') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Doa
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-emerald-50 hover:text-emerald-700 focus:outline-none transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->isAdmin())
                                <x-dropdown-link :href="route('admin.dashboard')" wire:navigate class="text-emerald-700 font-semibold">
                                    ⚙️ Panel Admin
                                </x-dropdown-link>
                                <div class="border-t border-gray-100"></div>
                            @endif

                            <x-dropdown-link :href="route('tersimpan')" wire:navigate>
                                🔖 Tersimpan
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('pengaturan.edit')" wire:navigate>
                                ⚙️ Pengaturan
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profil.edit')" wire:navigate>
                                👤 Profil
                            </x-dropdown-link>

                            <div class="border-t border-gray-100"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    🚪 Keluar
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" wire:navigate class="text-sm font-medium text-gray-700 hover:text-emerald-600">Masuk</a>
                        <a href="{{ route('register') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700">Daftar</a>
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('beranda')" :active="request()->routeIs('beranda')" wire:navigate>
                Beranda
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('quran.index')" :active="request()->routeIs('quran.*')" wire:navigate>
                Al-Qur'an
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tahlil.index')" :active="request()->routeIs('tahlil.*')" wire:navigate>
                Tahlil
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('doa.index')" :active="request()->routeIs('doa.*')" wire:navigate>
                Doa
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    @if(Auth::user()->isAdmin())
                        <x-responsive-nav-link :href="route('admin.dashboard')" wire:navigate class="text-emerald-700 font-semibold">
                            ⚙️ Panel Admin
                        </x-responsive-nav-link>
                    @endif
                    <x-responsive-nav-link :href="route('tersimpan')" wire:navigate>
                        🔖 Tersimpan
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pengaturan.edit')" wire:navigate>
                        ⚙️ Pengaturan
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profil.edit')" wire:navigate>
                        👤 Profil
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            🚪 Keluar
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="p-4 space-y-2">
                    <a href="{{ route('login') }}" wire:navigate class="block w-full text-center py-2 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-md">Masuk</a>
                    <a href="{{ route('register') }}" wire:navigate class="block w-full text-center py-2 text-sm font-medium text-white bg-emerald-600 rounded-md">Daftar Akun</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
