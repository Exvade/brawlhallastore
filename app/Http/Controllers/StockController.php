<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrawlhallaAccount;
use App\Models\Banner;

class StockController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Banner (Kategori 'Jual Beli')
        $banners = Banner::where('category', 'Jual Beli')->latest()->get();

        // 2. Logic Filtering Akun
        $query = BrawlhallaAccount::query();

        // Filter: Search Judul
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // Filter: Harga Min
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // Filter: Harga Max
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 3. Ambil data dengan Pagination (12 per halaman)
        // 'with' seller agar hemat query database
        $accounts = $query->with('seller')->latest()->paginate(12);

        // Pertahankan query string (misal ?q=abc) saat pindah halaman
        $accounts->appends($request->all());

        return view('stock', compact('accounts', 'banners'));
    }
}
