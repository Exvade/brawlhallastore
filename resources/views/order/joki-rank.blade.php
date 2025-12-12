<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Joki Rank - BrawlStore</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <x-navbar />

    <div class="w-full max-w-6xl mx-auto px-4 py-8" x-data="{ selectedPackage: null }">

        <div
            class="rounded-2xl p-6 md:p-8 mb-6 text-white shadow-lg bg-gradient-to-r from-[#1e40af] via-[#0b45ac] to-[#03045e]">
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-xl bg-white/10">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold leading-tight">Joki Rank Brawlhalla</h1>
                    <p class="text-white/85 mt-1">Pilih paket, isi data akun, dan bayar—kami proses cepat, aman, dan
                        transparan.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('order.joki-rank.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <section class="lg:col-span-2 bg-white border border-blue-200 rounded-2xl p-5 shadow-sm">
                    <h2 class="text-xl font-bold text-[#0b45ac] mb-4">1. Pilih Paket Joki</h2>

                    @if ($packages->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach ($packages as $pkg)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="package_id" value="{{ $pkg->package_id }}"
                                        class="peer hidden" @click="selectedPackage = {{ json_encode($pkg) }}">

                                    <div
                                        class="rounded-xl border border-blue-200 bg-white p-0 overflow-hidden shadow-sm transition-all peer-checked:border-[#0b45ac] peer-checked:ring-2 peer-checked:ring-[#0b45ac]/30 peer-checked:bg-blue-50 hover:border-[#0b45ac]">
                                        <div class="aspect-square w-full bg-gray-100 relative">
                                            <img src="{{ asset('storage/' . $pkg->icon_url) }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                                            <div
                                                class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                                <div class="bg-emerald-500 rounded-full p-1">
                                                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="3" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-3">
                                            <h3 class="font-semibold text-slate-800 truncate">{{ $pkg->name }}</h3>
                                            <div class="mt-1 text-[#0b45ac] font-bold">
                                                Rp {{ number_format($pkg->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 bg-yellow-50 text-yellow-700 rounded-lg border border-yellow-200">
                            Belum ada paket Joki Rank yang tersedia. Silakan hubungi admin.
                        </div>
                    @endif

                    <div class="mt-6 rounded-xl bg-blue-50 border border-blue-200 p-4 transition-all"
                        x-show="selectedPackage" x-transition>
                        <div class="text-sm text-slate-600">Paket dipilih</div>
                        <div class="mt-1 font-bold text-slate-900 text-lg" x-text="selectedPackage?.name"></div>
                        <div class="text-[#0b45ac] font-extrabold text-xl">
                            Rp <span x-text="new Intl.NumberFormat('id-ID').format(selectedPackage?.price || 0)"></span>
                        </div>
                    </div>

                    @error('package_id')
                        <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </section>

                <section class="bg-white border border-blue-200 rounded-2xl p-5 shadow-sm h-fit sticky top-24">
                    <h2 class="text-xl font-bold text-[#0b45ac] mb-4">2. Data Akun & Kontak</h2>

                    <div class="space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Metode Login Game</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="cursor-pointer">
                                    <input type="radio" name="method" value="ubisoft" class="peer hidden" checked>
                                    <div
                                        class="text-center rounded-lg border border-blue-200 py-2 text-sm font-medium transition-all peer-checked:bg-[#0b45ac] peer-checked:text-white peer-checked:border-[#0b45ac] hover:bg-blue-50">
                                        Ubisoft
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="method" value="steam" class="peer hidden">
                                    <div
                                        class="text-center rounded-lg border border-blue-200 py-2 text-sm font-medium transition-all peer-checked:bg-[#0b45ac] peer-checked:text-white peer-checked:border-[#0b45ac] hover:bg-blue-50">
                                        Steam
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Email / Username Akun</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <input type="text" name="username" placeholder="email@contoh.com" required
                                    class="w-full rounded-lg border border-blue-200 focus:border-blue-400 focus:ring-blue-400/30 pl-10 pr-3 py-2 text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Password Akun</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 11 9 13.5 9 16l-3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                <input type="password" name="password" placeholder="••••••••" required
                                    class="w-full rounded-lg border border-blue-200 focus:border-blue-400 focus:ring-blue-400/30 pl-10 pr-3 py-2 text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </span>
                                <input type="text" name="contact" placeholder="08xxxxxxxxxx" required
                                    class="w-full rounded-lg border border-blue-200 focus:border-blue-400 focus:ring-blue-400/30 pl-10 pr-3 py-2 text-sm">
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Digunakan worker jika ada kendala login.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Catatan / Request Hero</label>
                            <textarea name="notes" rows="3" placeholder="Contoh: Pake Mordex ya bang, jangan main jam 9 malem."
                                class="w-full rounded-lg border border-blue-200 focus:border-blue-400 focus:ring-blue-400/30 p-3 text-sm"></textarea>
                        </div>

                        <div class="rounded-xl bg-blue-50 border border-blue-200 p-4 mt-2">
                            <div class="flex items-center justify-between text-sm text-slate-600 mb-1">
                                <span>Total Tagihan</span>
                                <svg class="w-4 h-4 text-[#0b45ac]" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div class="text-[#0b45ac] text-xl font-extrabold">
                                Rp <span
                                    x-text="selectedPackage ? new Intl.NumberFormat('id-ID').format(selectedPackage.price) : '0'"></span>
                            </div>
                        </div>

                        <button type="submit" :disabled="!selectedPackage"
                            :class="!selectedPackage ? 'bg-slate-400 cursor-not-allowed' : 'bg-[#0b45ac] hover:bg-[#0a3d99]'"
                            class="w-full flex items-center justify-center gap-2 py-3 rounded-lg font-bold text-white transition-colors shadow-md">
                            <span>Lanjut Pembayaran</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>

                    </div>
                </section>
            </div>
        </form>

        <section class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="rounded-xl bg-white border border-blue-200 p-4 shadow-sm">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Proses Cepat
                </h3>
                <p class="text-sm text-slate-600 mt-1">Worker kami siap mengerjakan akun Anda segera setelah
                    pembayaran.</p>
            </div>
            <div class="rounded-xl bg-white border border-blue-200 p-4 shadow-sm">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Data Aman
                </h3>
                <p class="text-sm text-slate-600 mt-1">Privasi akun Anda adalah prioritas kami. Data dihapus setelah
                    joki selesai.</p>
            </div>
            <div class="rounded-xl bg-white border border-blue-200 p-4 shadow-sm">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Harga Transparan
                </h3>
                <p class="text-sm text-slate-600 mt-1">Apa yang Anda lihat adalah yang Anda bayar. Tanpa biaya
                    aneh-aneh.</p>
            </div>
        </section>

    </div>

    <x-footer />
</body>

</html>
