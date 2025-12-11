<nav x-data="{ isMobileMenuOpen: false }" @click.outside="isMobileMenuOpen = false"
    class="bg-gradient-to-t from-[#021462] to-[#163894] backdrop-blur-sm border-b border-blue-800/30 p-4 shadow-xl sticky top-0 left-0 right-0 z-50">
    <div class="container mx-auto flex justify-between items-center">

        <a href="{{ route('home') }}"
            class="flex items-center cursor-pointer hover:scale-105 transition-transform duration-200">
            <img src="{{ asset('brawlhallastore-logo.webp') }}" alt="Logo"
                class="h-8 sm:h-10 mr-2 sm:mr-3 drop-shadow-lg">
            <span class="text-lg sm:text-xl font-bold text-white uppercase italic tracking-wide drop-shadow-md">
                BrawlhallaStore
            </span>
        </a>

        <div class="hidden md:flex items-center space-x-8">
            {{-- Menu Items --}}
            <a href="{{ route('home') }}"
                class="text-blue-100 hover:text-white transition-all duration-200 font-medium hover:scale-105">
                Beranda
            </a>
            <a href="#"
                class="text-blue-100 hover:text-white transition-all duration-200 font-medium hover:scale-105">
                Topup
            </a>

            {{-- Dropdown Joki (Opsional, atau link langsung) --}}
            <div class="relative group">
                <button
                    class="text-blue-100 hover:text-white transition-all duration-200 font-medium hover:scale-105 flex items-center gap-1">
                    Joki
                </button>
                <div
                    class="absolute left-0 mt-2 w-48 bg-[#021462] border border-blue-700 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left">
                    <a href="#"
                        class="block px-4 py-2 text-sm text-blue-100 hover:bg-blue-800 hover:text-white">Joki Rank</a>
                    <a href="#"
                        class="block px-4 py-2 text-sm text-blue-100 hover:bg-blue-800 hover:text-white">Joki
                        Battlepass</a>
                </div>
            </div>

            <a href="#"
                class="text-blue-100 hover:text-white transition-all duration-200 font-medium hover:scale-105">
                Coaching
            </a>

            <a href="{{ route('stock.index') }}"
                class="text-blue-100 hover:text-white transition-all duration-200 font-medium hover:scale-105">
                Stok Akun
            </a>

            <div class="h-6 w-px bg-blue-300/40"></div>

            @auth
                {{-- Jika User SUDAH Login --}}
                <div class="relative group" x-data="{ openProfile: false }">
                    <button @click="openProfile = !openProfile"
                        class="hover:scale-110 transition-transform duration-200 flex items-center gap-2">
                        @if (Auth::user()->avatar)
                            <img src="{{ Str::startsWith(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar) }}"
                                alt="Profil"
                                class="w-10 h-10 rounded-full object-cover border-2 border-white/20 shadow-lg">
                        @else
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center font-bold text-white shadow-lg border-2 border-white/20 text-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </button>

                    <div
                        class="absolute right-0 mt-2 w-48 bg-[#021462] border border-blue-700 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="px-4 py-2 border-b border-blue-800">
                            <p class="text-sm text-white font-bold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-blue-300 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        @if (Auth::user()->role === 'admin')
                            <a href="/admin" class="block px-4 py-2 text-sm text-blue-100 hover:bg-blue-800">Dashboard
                                Admin</a>
                        @endif
                        <a href="{{ route('logout') }}"
                            class="block px-4 py-2 text-sm text-red-400 hover:bg-blue-800">Logout</a>
                    </div>
                </div>
            @else
                {{-- Jika User BELUM Login --}}
                <a href="{{ route('google.login') }}"
                    class="flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-blue-900 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-lg hover:from-cyan-300 hover:to-blue-300 transition-all shadow-lg">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M21.35 11.1h-9.17v2.73h6.51c-.33 3.81-3.5 5.44-6.5 5.44C8.36 19.27 5 16.25 5 12c0-4.1 3.2-7.27 7.2-7.27 3.09 0 4.9 1.97 4.9 1.97L19 4.72S16.56 2 12.1 2C6.42 2 2.03 6.8 2.03 12c0 5.05 4.13 10 10.22 10 5.35 0 9.25-3.67 9.25-9.09 0-1.15-.15-2.15-.15-2.15z" />
                    </svg>
                    Login Google
                </a>
            @endauth
        </div>

        <div class="flex md:hidden items-center">
            <button @click="isMobileMenuOpen = !isMobileMenuOpen"
                class="text-white p-2 hover:bg-white/10 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden mt-4 pt-4 border-t border-blue-700/30"
        style="display: none;">
        <div class="flex flex-col space-y-3">
            <a href="{{ route('home') }}"
                class="text-left text-blue-100 py-2 px-4 rounded-lg hover:bg-white/10">Beranda</a>
            <a href="#" class="text-left text-blue-100 py-2 px-4 rounded-lg hover:bg-white/10">Topup</a>
            <a href="#" class="text-left text-blue-100 py-2 px-4 rounded-lg hover:bg-white/10">Joki Rank</a>
            <a href="#" class="text-left text-blue-100 py-2 px-4 rounded-lg hover:bg-white/10">Joki Battlepass</a>
            <a href="#" class="text-left text-blue-100 py-2 px-4 rounded-lg hover:bg-white/10">Coaching</a>

            <div class="h-px bg-blue-700/30 my-2"></div>

            @auth
                <div class="flex items-center gap-3 px-4 py-2">
                    @if (Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" class="w-8 h-8 rounded-full object-cover">
                    @else
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="text-white text-sm font-semibold">{{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}" class="text-red-300 text-xs">Logout</a>
                    </div>
                </div>
            @else
                <a href="{{ route('google.login') }}"
                    class="mx-4 flex justify-center items-center gap-2 font-semibold text-blue-900 bg-gradient-to-r from-cyan-400 to-blue-400 py-2.5 px-4 rounded-lg">
                    Login Google
                </a>
            @endauth
        </div>
    </div>
</nav>
