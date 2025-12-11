<footer class="bg-[#021462] text-white pt-12 pb-8 border-t border-blue-800">
    <div class="container mx-auto px-6">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">

            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <img src="./brawlhallastore-logo.webp" alt="Logo" class="h-8 w-8 brightness-0 invert">
                    <span class="text-xl font-bold tracking-wider italic">BRAWLHALLASTORE</span>
                </div>
                <p class="text-blue-200 text-sm leading-relaxed">
                    BRAWLHALLASTORE adalah Tempat Jasa Joki, Coaching dan Jual Beli Akun Murah Terpercaya di Indonesia.
                    Tersedia berbagai macam pembayaran lengkap yang pasti memudahkan Anda untuk bertransaksi.
                </p>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">Peta Situs</h3>
                <ul class="space-y-2 text-sm text-blue-200">
                    <li><a href="{{ route('home') }}" class="hover:text-white hover:underline transition">Beranda</a>
                    </li>
                    <li><a href="{{ route('stock.index') }}" class="hover:text-white hover:underline transition">Stok
                            Akun</a></li>
                    <li><a href="{{ route('google.login') }}"
                            class="hover:text-white hover:underline transition">Masuk</a></li>
                    <li><a href="{{ route('google.login') }}"
                            class="hover:text-white hover:underline transition">Daftar</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">Dukungan</h3>
                <ul class="space-y-2 text-sm text-blue-200">
                    <li><a href="#" class="hover:text-white hover:underline transition">WhatsApp</a></li>
                    <li><a href="#" class="hover:text-white hover:underline transition">TikTok</a></li>
                    <li><a href="#" class="hover:text-white hover:underline transition">Email</a></li>
                    <li><a href="#" class="hover:text-white hover:underline transition">Instagram</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-bold mb-4">Legalitas</h3>
                <ul class="space-y-2 text-sm text-blue-200">
                    <li><a href="#" class="hover:text-white hover:underline transition">Kebijakan Pribadi</a></li>
                    <li><a href="#" class="hover:text-white hover:underline transition">Syarat & Ketentuan</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-blue-800/50 my-8"></div>

        <div class="flex flex-col md:flex-row justify-between items-center gap-4">

            <div class="flex items-center gap-4">
                <a href="#" class="bg-blue-900/50 p-2 rounded-full hover:bg-blue-700 transition group">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                    </svg>
                </a>

                <a href="#" class="bg-blue-900/50 p-2 rounded-full hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                    </svg>
                </a>

                <a href="#" class="bg-blue-900/50 p-2 rounded-full hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                        </path>
                    </svg>
                </a>
            </div>

            <div class="text-blue-300 text-sm text-center md:text-right">
                &copy; 2025 BRAWLHALLASTORE All rights reserved.
            </div>

        </div>
    </div>
</footer>
