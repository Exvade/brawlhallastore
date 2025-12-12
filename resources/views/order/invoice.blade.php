<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_id }} - BrawlStore</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased text-gray-900">

    <x-navbar />

    <div class="min-h-[80vh] flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full overflow-hidden border border-gray-200">

            <div class="bg-blue-900 text-white p-6 text-center">
                <div class="mb-4 inline-block p-3 rounded-full bg-blue-800">
                    <svg class="w-8 h-8 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold">Tagihan Pembayaran</h1>
                <p class="text-blue-200 text-sm">Order ID: #{{ $order->order_id }}</p>
            </div>

            <div class="p-6">
                <div class="flex justify-center mb-6">
                    @if ($order->payment_status === 'paid')
                        <span
                            class="px-4 py-2 bg-green-100 text-green-700 font-bold rounded-full text-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            LUNAS (PAID)
                        </span>
                    @else
                        <span
                            class="px-4 py-2 bg-yellow-100 text-yellow-700 font-bold rounded-full text-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            MENUNGGU PEMBAYARAN
                        </span>
                    @endif
                </div>

                <div class="space-y-4 text-sm text-gray-600 mb-8">
                    <div class="flex justify-between border-b pb-2">
                        <span>Layanan</span>
                        <span class="font-bold text-gray-900">Joki Rank</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span>Total Biaya</span>
                        <span class="font-bold text-blue-900 text-lg">Rp
                            {{ number_format($order->amount, 0, ',', '.') }}</span>
                    </div>

                    {{-- PERBAIKAN DI SINI: Akses langsung sebagai Array --}}
                    @php
                        // Cek jaga-jaga kalau datanya masih string (kasus double encode), kita decode.
                        // Kalau sudah array, biarkan.
                        $creds = $order->account_credentials;
                        if (is_string($creds)) {
                            $creds = json_decode($creds, true);
                        }
                    @endphp

                    <div class="flex justify-between border-b pb-2">
                        <span>Metode Login</span>
                        {{-- Akses pakai array key ['method'] --}}
                        <span class="capitalize font-medium">{{ $creds['method'] ?? '-' }}</span>
                    </div>

                    @if (isset($creds['notes']) && $creds['notes'])
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <span class="block text-xs font-bold text-gray-500 uppercase mb-1">Catatan:</span>
                            <p class="italic text-gray-700">"{{ $creds['notes'] }}"</p>
                        </div>
                    @endif
                </div>

                @if ($order->payment_status !== 'paid')
                    <form action="{{ route('order.pay-dummy', $order->order_id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition transform active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Bayar Sekarang (Simulasi)
                        </button>
                    </form>
                @else
                    <a href="{{ route('home') }}"
                        class="block w-full text-center py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-xl transition">
                        Kembali ke Beranda
                    </a>
                @endif
            </div>
        </div>
    </div>

</body>

</html>
