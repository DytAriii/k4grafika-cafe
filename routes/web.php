<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OrderController;
<<<<<<< HEAD
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransaksiController;

// Kasir
Route::get('/kasir/order', [KasirController::class, 'order'])->name('kasir.order');
=======
use App\Http\Controllers\MenuController;

// ==================== Kasir ====================
Route::get('/kasir/order', [OrderController::class, 'order'])->name('kasir.order');
>>>>>>> 4d38b0132f808684e37c934d4380ccb2422a8ac4
Route::get('/order/category/{id}', [KasirController::class, 'getMenusByCategory']);

// Riwayat transaksi
Route::get('/kasir/history', [TransaksiController::class, 'history'])->name('kasir.history');

// Menu habis
Route::get('/kasir/menu', [KasirController::class, 'menu'])->name('kasir.menu');
Route::post('/kasir/soldout', [TransaksiController::class, 'soldout'])->name('kasir.soldout');

// Payment flow
Route::get('/kasir/payment', [KasirController::class, 'payment'])->name('kasir.payment');
Route::post('/kasir/payment/process', [TransaksiController::class, 'processPayment'])->name('kasir.payment.process');
Route::get('/kasir/receipt/{id}', [TransaksiController::class, 'receipt'])->name('kasir.receipt');

// Checkout
Route::post('/kasir/checkout', [TransaksiController::class, 'checkout'])->name('kasir.checkout');

// Order & Cart
Route::post('/order/add/{id}', [OrderController::class, 'addToCart'])->name('order.add');
Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
Route::post('/order/remove/{id}', [OrderController::class, 'remove'])->name('order.remove');
Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/order/reset', [OrderController::class, 'reset'])->name('order.reset');
Route::get('/order/category/{id}', [OrderController::class, 'getMenuByCategory']);

<<<<<<< HEAD
// Opsional: jika pakai CheckoutController untuk sistem lain
Route::get('/orders/{order}/payment', [CheckoutController::class, 'showPayment'])->name('orders.payment');
Route::post('/orders/{order}/pay/cash', [CheckoutController::class, 'payCash'])->name('orders.pay.cash');
Route::post('/orders/{order}/pay/qris/confirm', [CheckoutController::class, 'confirmQris'])->name('orders.pay.qris.confirm');
=======
// ==================== Login ====================
Route::get('/', [usersController::class, 'formLogin'])->name('login');
Route::post('/', [usersController::class, 'prosesLogin'])->name('login.post');
>>>>>>> 4d38b0132f808684e37c934d4380ccb2422a8ac4

// Login
Route::get('/', [UsersController::class, 'formLogin'])->name('login');
Route::post('/', [UsersController::class, 'prosesLogin'])->name('login.post');

<<<<<<< HEAD
// Home
Route::get('/home', [UsersController::class, 'home'])->name('home');
=======
// ==================== Kasir Management ====================
Route::get('/admin/create-kasir', [KasirController::class, 'kasirCreate'])->name('kasir.create');
Route::post('/admin/store-kasir', [KasirController::class, 'kasirStore'])->name('kasir.store');
Route::get('/admin/{id}/edit', [KasirController::class, 'kasirEdit'])->name('kasir.edit');
Route::post('/admin/{id}/update', [KasirController::class, 'kasirUpdate'])->name('kasir.update');
Route::get('/admin/{id}/kasir-delete', [KasirController::class, 'kasirDelete'])->name('kasir.delete');
>>>>>>> 4d38b0132f808684e37c934d4380ccb2422a8ac4

// Kasir Management
Route::get('/admin/create-kasir', [UsersController::class, 'kasirCreate'])->name('kasir.create');
Route::post('/admin/store-kasir', [UsersController::class, 'kasirStore'])->name('kasir.store');
Route::get('/admin/{id}/edit', [UsersController::class, 'kasirEdit'])->name('kasir.edit');
Route::post('/admin/{id}/update', [UsersController::class, 'kasirUpdate'])->name('kasir.update');
Route::get('/admin/{id}/kasir-delete', [UsersController::class, 'kasirDelete'])->name('kasir.delete');

<<<<<<< HEAD
// Logout
Route::get('/logout', [UsersController::class, 'logout'])->name('logout');
=======
// ==================== Admin Dashboard ====================
Route::get('/admin', [usersController::class, 'dashboard'])->name('admin');
Route::get('/admin/dashboard', [usersController::class, 'dashboard'])->name('dashboard');
Route::get('/admin/daftarKasir', [KasirController::class, 'daftarKasir'])->name('daftarKasir');
Route::get('/admin/manajemenMenu', [MenuController::class, 'manajemenMenu'])->name('manajemenMenu');
>>>>>>> 4d38b0132f808684e37c934d4380ccb2422a8ac4

// Admin Dashboard
Route::get('/admin', [UsersController::class, 'dashboard'])->name('admin');
Route::get('/admin/dashboard', [UsersController::class, 'dashboard'])->name('dashboard');
Route::get('/admin/daftarKasir', [UsersController::class, 'daftarKasir'])->name('daftarKasir');
Route::get('/admin/manajemenMenu', [UsersController::class, 'manajemenMenu'])->name('manajemenMenu');

// Manajemen Menu
Route::prefix('admin')->group(function () {
<<<<<<< HEAD
    Route::get('/create-menu', [UsersController::class, 'menuCreate'])->name('menu.create');
    Route::post('/store-menu', [UsersController::class, 'menuStore'])->name('menu.store');
    Route::get('/{id}/edit-menu', [UsersController::class, 'menuEdit'])->name('menu.edit');
    Route::put('/{id}/update-menu', [UsersController::class, 'menuUpdate'])->name('menu.update');
    Route::get('/{id}/menu-delete', [UsersController::class, 'menuDelete'])->name('menu.delete');
});
=======
    Route::get('/admin/create-menu', [menuController::class, 'menuCreate'])->name('menu.create'); //rute ke Tambah menu
    Route::post('/admin/store-menu', [menuController::class, 'menuStore'])->name('menu.store'); //simpan data menu
    Route::get('/admin/{id}/edit-menu', [menuController::class, 'menuEdit'])->name('menu.edit'); //rute ke halaman edit menu ---> mengirimkan id
    Route::patch('/admin/{id}/update-menu', [menuController::class, 'menuUpdate'])->name('menu.update'); //update data menu
    Route::get('/admin/{id}/menu-delete', [menuController::class, 'menuDelete'])->name('menu.delete'); //hapus data menu
});
>>>>>>> 4d38b0132f808684e37c934d4380ccb2422a8ac4
