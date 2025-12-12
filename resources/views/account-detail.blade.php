<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $account->title }} - BrawlStore</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <x-navbar />

    @php
        function makeWaLink($number, $text)
        {
            if (!$number) {
                return null;
            }
            $n = preg_replace('/[^\d]/', '', $number); // Hapus karakter non-angka
            if (str_starts_with($n, '0')) {
                $n = '62' . substr($n, 1);
            }
            return "https://wa.me/$n?text=" . urlencode($text);
        }

        $rekberLink = makeWaLink(
            $account->rekber_number,
            'Halo Admin Rekber, saya ingin rekber untuk: ' . $account->title,
        );
        $sellerLink = makeWaLink(
            $account->seller_number,
            "Halo, apakah akun \"" . $account->title . "\" masih tersedia?",
        );

        // Pastikan image_url berbentuk array (safety check)
        $images = is_array($account->image_url) ? $account->image_url : [];
    @endphp

    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="mb-6">
                <a href="{{ route('home') }}" class="text-blue-600 hover:underline flex items-center gap-1">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M19 12H5" />
                        <path d="M12 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Stok
                </a>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                <aside class="xl:col-span-1 order-2 xl:order-1">
                    <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden sticky top-24">
                        <div class="p-6 lg:p-8 bg-[#021462]">

                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-2 bg-white/20 rounded-lg">
                                    <svg class="text-white w-6 h-6" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                        <path d="M9 12l2 2 4-4" />
                                    </svg>
                                </div>
                                <h3 class="text-xl lg:text-2xl font-bold text-white">
                                    Tahapan Rekber
                                </h3>
                            </div>

                            <div class="space-y-4">
                                @foreach (['Pembeli chat ke WhatsApp / Instagram penjual untuk menanyakan ketersediaan akun.', 'Silahkan melakukan negosiasi sampai kedua pihak sepakat.', 'Jika sudah sepakat silahkan chat ke Admin Rekber untuk melakukan rekber.', 'Ikuti tahapan yang diberikan oleh Admin Rekber sampai selesai.'] as $index => $step)
                                    <div class="flex gap-3">
                                        <div
                                            class="flex-shrink-0 w-6 h-6 bg-white/20 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                            {{ $index + 1 }}
                                        </div>
                                        <p class="text-white/90 text-sm leading-relaxed">
                                            {{ $step }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="h-px bg-white/20 my-6"></div>

                            <div class="space-y-3">
                                <h4 class="text-lg font-semibold text-white flex items-center gap-2">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                    Catatan Penting!
                                </h4>
                                <ul class="space-y-2 text-sm text-white/90">
                                    <li class="flex gap-2">
                                        <span class="text-white/60">•</span>
                                        <span>Kami tidak pernah mengalihkan nomor Admin Post / Admin Rekber.</span>
                                    </li>
                                    <li class="flex gap-2">
                                        <span class="text-white/60">•</span>
                                        <span>Jangan pernah melakukan transaksi langsung kepada penjual.</span>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </aside>

                <section class="xl:col-span-2 order-1 xl:order-2">
                    <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">

                        <div class="relative group bg-gray-900 aspect-video lg:aspect-[4/3]" x-data="{ activeSlide: 0, slides: {{ json_encode($images) }} }">

                            @if (count($images) > 0)
                                <template x-for="(slide, index) in slides" :key="index">
                                    <div x-show="activeSlide === index"
                                        x-transition:enter="transition opacity duration-500"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        class="absolute inset-0 flex items-center justify-center bg-gray-900">
                                        <img :src="'/storage/' + slide" class="w-full h-full object-contain">
                                    </div>
                                </template>

                                @if (count($images) > 1)
                                    <button
                                        @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 backdrop-blur-sm p-3 rounded-full text-white transition z-10">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M15 18l-6-6 6-6" />
                                        </svg>
                                    </button>
                                    <button
                                        @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 backdrop-blur-sm p-3 rounded-full text-white transition z-10">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M9 18l6-6-6-6" />
                                        </svg>
                                    </button>

                                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-10">
                                        <template x-for="(slide, index) in slides">
                                            <button @click="activeSlide = index"
                                                class="w-2.5 h-2.5 rounded-full transition-all"
                                                :class="activeSlide === index ? 'bg-white scale-125' : 'bg-white/50'">
                                            </button>
                                        </template>
                                    </div>
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-500 flex-col">
                                    <span class="text-4xl mb-2">📷</span>
                                    <p>Tidak ada gambar</p>
                                </div>
                            @endif
                        </div>

                        <div class="p-6 lg:p-8">

                            <div class="mb-6">
                                <h1 class="text-2xl lg:text-4xl font-bold text-gray-900 mb-3 leading-tight">
                                    {{ $account->title }}
                                </h1>
                                <div class="flex items-center gap-2">
                                    <span class="text-3xl lg:text-4xl font-bold text-[#163894]">
                                        Rp {{ number_format($account->price, 0, ',', '.') }}
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">
                                        Tersedia
                                    </span>
                                </div>
                            </div>

                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                                <span
                                    class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $account->description }}</span>
                            </div>

                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontak</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                        <div class="flex items-center gap-3 mb-2">
                                            <svg class="text-blue-600 w-5 h-5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path
                                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                            </svg>
                                            <span class="font-medium text-gray-900">Penjual</span>
                                        </div>
                                        <p class="text-gray-600 font-mono">{{ $account->seller_number ?? '-' }}</p>
                                    </div>

                                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                        <div class="flex items-center gap-3 mb-2">
                                            <svg class="text-green-600 w-5 h-5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                                <path d="M9 12l2 2 4-4" />
                                            </svg>
                                            <span class="font-medium text-gray-900">Rekber</span>
                                        </div>
                                        <p class="text-gray-600 font-mono">{{ $account->rekber_number ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <a href="{{ $rekberLink ?? '#' }}" target="_blank"
                                    class="group relative overflow-hidden rounded-xl px-6 py-4 font-semibold text-white transition-all duration-200 bg-[#021462] hover:shadow-lg hover:-translate-y-0.5 {{ !$rekberLink ? 'opacity-60 cursor-not-allowed' : '' }}">
                                    <div class="relative flex items-center justify-center gap-3">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                            <path d="M9 12l2 2 4-4" />
                                        </svg>
                                        <span>Chat Admin Rekber</span>
                                    </div>
                                </a>

                                <a href="{{ $sellerLink ?? '#' }}" target="_blank"
                                    class="group relative overflow-hidden rounded-xl px-6 py-4 font-semibold text-white transition-all duration-200 bg-[#163894] hover:shadow-lg hover:-translate-y-0.5 {{ !$sellerLink ? 'opacity-60 cursor-not-allowed' : '' }}">
                                    <div class="relative flex items-center justify-center gap-3">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                        </svg>
                                        <span>Chat Penjual</span>
                                    </div>
                                </a>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="flex items-center justify-center gap-6 text-sm text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <svg class="text-green-500 w-4 h-4" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                            <path d="M9 12l2 2 4-4" />
                                        </svg>
                                        <span>Transaksi Aman</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="text-blue-500 w-4 h-4" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10" />
                                            <polyline points="12 6 12 12 16 14" />
                                        </svg>
                                        <span>Respon Cepat</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <x-footer />
</body>

</html>
