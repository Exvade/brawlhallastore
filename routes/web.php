<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\StockController;

Route::get('/', [LandingController::class, 'index'])->name('home');

// Route Login Google
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('logout', [GoogleAuthController::class, 'logout'])->name('logout');

// Stock Akun
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
// Detail Akun
Route::get('/stock/{id}', [LandingController::class, 'show'])->name('account.show');
