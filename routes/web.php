<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\OrderController;

Route::get('/', [LandingController::class, 'index'])->name('home');

// Route Login Google
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::get('logout', [GoogleAuthController::class, 'logout'])->name('logout');

// Stock Akun
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
// Detail Akun
Route::get('/stock/{id}', [LandingController::class, 'show'])->name('account.show');


Route::middleware(['auth'])->group(function () {

  // Form Joki Rank
  Route::get('/order/joki-rank', [OrderController::class, 'jokiRankForm'])->name('order.joki-rank');
  Route::post('/order/joki-rank', [OrderController::class, 'jokiRankStore'])->name('order.joki-rank.store');

  // Invoice & Pembayaran Dummy
  Route::get('/order/invoice/{id}', [OrderController::class, 'invoice'])->name('order.invoice');
  Route::post('/order/pay/{id}', [OrderController::class, 'payDummy'])->name('order.pay-dummy');

  Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');
});
