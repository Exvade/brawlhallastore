<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        // Ambil order milik user yang login, urutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
            ->with('package') // Eager load relasi paket biar ringan
            ->latest()
            ->paginate(10); // 10 order per halaman

        return view('history.index', compact('orders'));
    }
}
