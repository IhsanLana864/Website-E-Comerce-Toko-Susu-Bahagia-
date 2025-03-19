<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PesananController;

#INDEX
Route::get('/', [CustomerController::class, 'index'])->name('index');
Route::post('/add-to-cart', [CustomerController::class, 'addToCart'])->name('add.to.cart');

#CART
Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
Route::post('/update-cart', [CustomerController::class, 'updateCart'])->name('update.cart');
Route::post('/remove-from-cart', [CustomerController::class, 'removeFromCart'])->name('remove.from.cart');
Route::get('/cart-detail', [CustomerController::class, 'cartDetail'])->name('cartDetail');
Route::post('/checkout-cart', [CustomerController::class, 'checkout'])->name('checkout.cart');

Route::get('/about', function () {return view('about');});

#TRACKING
Route::get('/tracking', [CustomerController::class, 'tracking'])->name('tracking');
Route::post('/detail-pesanan', [CustomerController::class, 'showPesanan'])->name('tracking.show');

Route::get('/admin', function () {return view('admin.dashboard');});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('kategoris', KategoriController::class);
    Route::resource('barangs', BarangController::class);
    Route::resource('masuk', BarangMasukController::class);
    Route::resource('keluar', BarangKeluarController::class);
    Route::resource('pesanan', PesananController::class);
});