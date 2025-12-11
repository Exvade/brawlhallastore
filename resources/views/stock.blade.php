<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Akun - BrawlStore</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <x-navbar />

    <div class="w-full max-w-7xl mx-auto px-4 py-8">

        <section class="mb-8" x-data="{
            activeSlide: 0,
            slides: {{ $banners->count() }},
            autoplay() { setInterval(() => { this.activeSlide = (this.activeSlide + 1) % this.slides }, 3500) }
        }" x-init="autoplay()">

            @if ($banners->count() > 0)
                <div class="relative rounded-xl overflow-hidden border border-blue-200 h-48 md:h-[450px]">
                    @foreach ($banners as $index => $banner)
                        <div x-show="activeSlide === {{ $index }}"
                            x-transition:enter="transition opacity duration-700" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" class="absolute inset-0">
                            <img src="{{ asset('storage/' . $banner->image_url) }}" class="w-full h-full object-cover"
                                alt="{{ $banner->title }}">
                        </div>
                    @endforeach

                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-10">
                        @foreach ($banners as $index => $banner)
                            <button @click="activeSlide = {{ $index }}"
                                class="w-2.5 h-2.5 rounded-full transition-all"
                                :class="activeSlide === {{ $index }} ? 'bg-blue-600 scale-125' : 'bg-blue-200/80'">
                            </button>
                        @endforeach
                    </div>
                </div>
            @else
                <div
                    class="w-full h-48 md:h-[450px] rounded-xl bg-blue-100 flex items-center justify-center text-blue-300">
                    Banner belum tersedia
                </div>
            @endif
        </section>

        <div class="mb-8" x-data="{ open: {{ request()->hasAny(['q', 'min_price', 'max_price']) ? 'true' : 'false' }} }">

            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-blue-900">Stok Akun</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Menampilkan <span class="font-bold text-gray-800">{{ $accounts->total() }}</span> akun tersedia
                    </p>
                </div>

                <button @click="open = !open"
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 text-gray-700 font-medium transition active:scale-95">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="4" y1="21" x2="4" y2="14"></line>
                        <line x1="4" y1="10" x2="4" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12" y2="3"></line>
                        <line x1="20" y1="21" x2="20" y2="16"></line>
                        <line x1="20" y1="12" x2="20" y2="3"></line>
                        <line x1="1" y1="14" x2="7" y2="14"></line>
                        <line x1="9" y1="8" x2="15" y2="8"></line>
                        <line x1="17" y1="16" x2="23" y2="16"></line>
                    </svg>
                    <span>Filter Pencarian</span>
                    <svg :class="open ? 'rotate-180' : ''" class="transition-transform duration-200 text-gray-400"
                        width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>
            </div>

            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                style="display: none;">

                <div class="bg-white border border-gray-200 p-5 rounded-xl shadow-sm">
                    <form method="GET" action="{{ route('stock.index') }}">
                        <div class="flex flex-col lg:flex-row gap-4 items-end lg:items-center">

                            <div class="w-full lg:flex-[2]">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 block">Cari
                                    Akun</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </span>
                                    <input type="text" name="q" value="{{ request('q') }}"
                                        placeholder="Cari berdasarkan kode..."
                                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
                                </div>
                            </div>

                            <div class="w-full lg:flex-[1.5] flex gap-2">
                                <div class="w-1/2">
                                    <label
                                        class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 block">Min
                                        Harga</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">Rp</span>
                                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                                            placeholder="0"
                                            class="w-full pl-8 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
                                    </div>
                                </div>
                                <div class="w-1/2">
                                    <label
                                        class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 block">Max
                                        Harga</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">Rp</span>
                                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                                            placeholder="Unlimited"
                                            class="w-full pl-8 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="w-full lg:w-auto flex gap-2">
                                <button type="submit"
                                    class="flex-1 lg:flex-none bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-md whitespace-nowrap">
                                    Terapkan
                                </button>

                                @if (request()->hasAny(['q', 'min_price', 'max_price']))
                                    <a href="{{ route('stock.index') }}"
                                        class="flex-none flex items-center justify-center px-4 py-2.5 border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-100 hover:text-red-500 transition"
                                        title="Reset Filter">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </a>
                                @endif
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if ($accounts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach ($accounts as $acc)
                    <div
                        class="group relative rounded-xl overflow-hidden shadow-lg h-[380px] border border-blue-100 bg-gray-900 cursor-pointer">

                        <a href="{{ route('account.show', $acc->account_id) }}" class="absolute inset-0 z-20"></a>

                        @php
                            $images = is_array($acc->image_url) ? $acc->image_url : [];
                            $firstImage = $images[0] ?? null;
                        @endphp

                        @if ($firstImage)
                            <img src="{{ asset('storage/' . $firstImage) }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100"
                                alt="{{ $acc->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-500">
                                <span class="text-4xl opacity-50">🎮</span>
                            </div>
                        @endif

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                        </div>

                        <div
                            class="absolute bottom-0 left-0 right-0 p-6 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300 z-10 flex flex-col items-start text-left">

                            <h3 class="text-white font-bold text-lg leading-tight mb-2 line-clamp-2 drop-shadow-md">
                                {{ $acc->title }}
                            </h3>

                            <p class="text-cyan-400 font-extrabold text-2xl drop-shadow-md">
                                Rp {{ number_format($acc->price, 0, ',', '.') }}
                            </p>

                        </div>

                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $accounts->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-blue-50 rounded-xl border border-blue-100 border-dashed">
                <p class="text-blue-500 text-lg">Tidak ada akun yang cocok.</p>
                <a href="{{ route('stock.index') }}" class="text-sm text-blue-700 underline mt-2 block">Reset
                    Filter</a>
            </div>
        @endif

        <section class="mt-12 border-gray-200">
            <h2 class="text-2xl font-bold text-center mb-8 text-blue-900">Kenapa Pilih Kami?</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div
                    class="flex items-start gap-4 bg-white border border-blue-200 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600 shrink-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-blue-900 mb-1">Proses Cepat</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">Order diproses otomatis/cepat setelah
                            pembayaran terverifikasi.</p>
                    </div>
                </div>

                <div
                    class="flex items-start gap-4 bg-white border border-blue-200 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600 shrink-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            <path d="M9 12l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-blue-900 mb-1">Pembayaran Aman</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">Terintegrasi Midtrans; transaksi aman dan
                            terpercaya.</p>
                    </div>
                </div>

                <div
                    class="flex items-start gap-4 bg-white border border-blue-200 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600 shrink-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-blue-900 mb-1">Harga Transparan</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">Tidak ada biaya tersembunyi. Harga jelas
                            sesuai yang tertera.</p>
                    </div>
                </div>

                <div
                    class="flex items-start gap-4 bg-white border border-blue-200 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-600 shrink-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                            <path
                                d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-blue-900 mb-1">Support Responsif</h4>
                        <p class="text-slate-600 text-sm leading-relaxed">Tim support siap membantu jika ada kendala
                            pada pesanan.</p>
                    </div>
                </div>

            </div>
        </section>

    </div>
    <x-footer />
</body>

</html>
