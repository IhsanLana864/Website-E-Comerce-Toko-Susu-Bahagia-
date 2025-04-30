<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

###USER
    #INDEX
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/page', [CustomerController::class, 'index']);
    Route::get('/search', [CustomerController::class, 'search'])->name('search');
    Route::post('/add-to-cart', [CustomerController::class, 'addToCart'])->name('add.to.cart');
    #CART
    Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
    Route::post('/update-cart', [CustomerController::class, 'updateCart'])->name('update.cart');
    Route::post('/remove-from-cart', [CustomerController::class, 'removeFromCart'])->name('remove.from.cart');
    Route::get('/cart-detail', [CustomerController::class, 'cartDetail'])->name('cartDetail');
    Route::post('/checkout-cart', [CustomerController::class, 'checkout'])->name('checkout.cart');
    #ABOUT
    Route::get('/about', [CustomerController::class, 'about'])->name('about');
    #TRACKING
    Route::get('/tracking', [CustomerController::class, 'tracking'])->name('tracking');
    Route::post('/tracking', [CustomerController::class, 'showPesanan'])->name('tracking.show');

###ADMIN
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('kategoris', KategoriController::class);
    Route::resource('barangs', BarangController::class);
    Route::resource('masuk', BarangMasukController::class);
    Route::resource('keluar', BarangKeluarController::class);
    Route::resource('pesanan', PesananController::class);
    #LAPORAN
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPDF'])->name('laporan.exportPDF');
    #ACCOUNT
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.index');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [UserController::class, 'passwordForm'])->name('profile.password');
    Route::put('/profile/password', [UserController::class, 'changePassword'])->name('profile.password.update');
    #NOTIF
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    #SEARCH
    Route::get('/search-barang', [BarangMasukController::class, 'searchBarangAjax'])->name('search.barang');
});

#USER
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
