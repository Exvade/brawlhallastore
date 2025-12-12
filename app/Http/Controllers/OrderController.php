<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JokiRankPackage;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 1. Tampilkan Form Order Joki Rank
    public function jokiRankForm()
    {
        $packages = JokiRankPackage::all();
        return view('order.joki-rank', compact('packages'));
    }

    // 2. Proses Simpan Order (Checkout)
    public function jokiRankStore(Request $request)
    {
        // Validasi Input
        $request->validate([
            'package_id' => 'required|exists:joki_rank_packages,package_id',
            'method' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'contact' => 'required|string',
            'notes' => 'nullable|string', // Kolom Catatan Baru
        ]);

        $package = JokiRankPackage::find($request->package_id);

        // Gabungkan data kredensial jadi satu JSON
        $credentials = [
            'method' => $request->method,
            'username' => $request->username,
            'password' => $request->password, // Nanti di real-world harus dienkripsi
            'notes' => $request->notes, // Masukkan catatan ke sini
        ];

        // Buat Order Baru di Database
        $order = Order::create([
            // Generate ID Order Unik (misal: JR-20230001)
            // Karena kita pakai bigInt di migrasi awal, kita biarkan auto-increment atau set manual jika mau custom string ID.
            // Untuk simplifikasi, biarkan auto-increment default Laravel.

            'user_id' => Auth::id(),
            'package_id' => $package->package_id,
            'service_type' => 'rank',
            'amount' => $package->price,
            'payment_status' => 'pending', // Belum bayar
            'work_status' => 'pending',
            'account_credentials' => $credentials, // <--- Langsung array saja
            'contact' => $request->contact,
        ]);

        // Redirect ke Halaman Invoice (Pembayaran)
        return redirect()->route('order.invoice', $order->order_id);
    }

    // 3. Halaman Invoice / Pembayaran Dummy
    public function invoice($id)
    {
        $order = Order::with('user')->findOrFail($id);

        // Pastikan yang akses adalah pemilik order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order.invoice', compact('order'));
    }

    // 4. Proses Bayar Dummy (Simulasi Sukses)
    public function payDummy($id)
    {
        $order = Order::findOrFail($id);

        // Update status jadi Paid
        $order->update([
            'payment_status' => 'paid',
            'midtrans_order_id' => 'DUMMY-' . time(), // ID Transaksi Palsu
        ]);

        return redirect()->route('order.invoice', $id)->with('success', 'Pembayaran Berhasil! (Simulasi)');
    }
}
