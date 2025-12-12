<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - BrawlStore</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900 flex flex-col min-h-screen">

    <x-navbar />

    <main class="flex-grow container mx-auto px-4 py-8 max-w-5xl">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Riwayat Pesanan</h1>
            <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline">Kembali ke Beranda</a>
        </div>

        @if ($orders->count() > 0)
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">

                        <div
                            class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-4 mb-4">
                            <div>
                                <div class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </div>
                                <div class="text-sm font-medium text-gray-700">
                                    Order ID: #{{ $order->order_id }}
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- Badge Pembayaran --}}
                                @if ($order->payment_status == 'paid')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                        Lunas
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                        Belum Bayar
                                    </span>
                                @endif

                                {{-- Badge Pengerjaan --}}
                                @if ($order->work_status == 'done')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                        Selesai
                                    </span>
                                @elseif($order->work_status == 'on_progress')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200 animate-pulse">
                                        Sedang Dikerjakan
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                        Pending
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-16 h-16 rounded-lg bg-blue-50 flex-shrink-0 overflow-hidden border border-blue-100">
                                    @if ($order->package && $order->package->icon_url)
                                        <img src="{{ asset('storage/' . $order->package->icon_url) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-blue-300">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">
                                        {{ $order->package->name ?? 'Paket Tidak Dikenal' }}
                                    </h3>
                                    <p class="text-sm text-gray-500 capitalize">
                                        Layanan: {{ $order->service_type }}
                                    </p>
                                    <p class="text-[#0b45ac] font-bold mt-1">
                                        Rp {{ number_format($order->amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                @if ($order->payment_status == 'pending')
                                    <a href="{{ route('order.invoice', $order->order_id) }}"
                                        class="inline-flex items-center justify-center px-6 py-2 bg-[#0b45ac] hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition shadow-sm w-full md:w-auto">
                                        Bayar Sekarang
                                    </a>
                                @else
                                    {{-- Nanti tombol ini arahkan ke detail progress --}}
                                    <a href="{{ route('order.invoice', $order->order_id) }}"
                                        class="inline-flex items-center justify-center px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-lg transition w-full md:w-auto">
                                        Lihat Invoice
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada pesanan</h3>
                <p class="text-gray-500 mt-1 mb-6">Kamu belum pernah melakukan transaksi apapun.</p>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                    Mulai Belanja
                </a>
            </div>
        @endif

    </main>

    <x-footer />

</body>

</html>
