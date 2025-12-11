<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JokiRankPackage;
use App\Models\JokiBattlepassPackage;
use App\Models\BrawlhallaAccount;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil semua data dari database
        $rankPackages = JokiRankPackage::all();
        $battlepassPackages = JokiBattlepassPackage::all();
        $accounts = BrawlhallaAccount::with('seller')->latest()->get(); // Pakai with seller biar nama penjual ke-load

        // Kirim data ke view 'welcome'
        return view('welcome', compact('rankPackages', 'battlepassPackages', 'accounts'));
    }

    public function show($id)
    {
        // Cari akun berdasarkan ID, sekalian ambil data penjualnya
        $account = \App\Models\BrawlhallaAccount::with('seller')->findOrFail($id);

        // Kirim ke view
        return view('account-detail', compact('account'));
    }
}
