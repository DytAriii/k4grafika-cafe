<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MenuController;

// ==================== Kasir ====================
Route::get('/kasir/order', [OrderController::class, 'order'])->name('kasir.order');
Route::get('/order/category/{id}', [OrderController::class, 'getMenuByCategory']);
Route::get('/kasir/history', [TransaksiController::class, 'history'])->name('kasir.history');
Route::get('/kasir/menu', [KasirController::class, 'menu'])->name('kasir.menu');
Route::post('/kasir/soldout', [TransaksiController::class, 'soldout'])->name('kasir.soldout');
Route::get('/kasir/payment', [KasirController::class, 'payment'])->name('kasir.payment');
Route::post('/kasir/payment/process', [TransaksiController::class, 'processPayment'])->name('kasir.payment.process');
Route::get('/kasir/receipt/{id}', [TransaksiController::class, 'receipt'])->name('kasir.receipt');
Route::post('/kasir/checkout', [TransaksiController::class, 'checkout'])->name('kasir.checkout');

// ==================== Order & Cart ====================
Route::post('/order/add/{id}', [OrderController::class, 'addToCart'])->name('order.add');
Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
Route::post('/order/remove/{id}', [OrderController::class, 'removeFromCart'])->name('order.remove');
Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/order/reset', [OrderController::class, 'reset'])->name('order.reset');

// ==================== Opsional: CheckoutController ====================
Route::get('/orders/{order}/payment', [CheckoutController::class, 'showPayment'])->name('orders.payment');
Route::post('/orders/{order}/pay/cash', [CheckoutController::class, 'payCash'])->name('orders.pay.cash');
Route::post('/orders/{order}/pay/qris/confirm', [CheckoutController::class, 'confirmQris'])->name('orders.pay.qris.confirm');

// ==================== Login ====================
Route::get('/', [UsersController::class, 'formLogin'])->name('login');
Route::post('/', [UsersController::class, 'prosesLogin'])->name('login.post');
Route::get('/home', [UsersController::class, 'home'])->name('home');
Route::get('/logout', [UsersController::class, 'logout'])->name('logout');

// ==================== Admin Dashboard ====================
Route::get('/admin', [UsersController::class, 'dashboard'])->name('admin');
Route::get('/admin/dashboard', [UsersController::class, 'dashboard'])->name('dashboard');
Route::get('/admin/daftarKasir', [UsersController::class, 'daftarKasir'])->name('daftarKasir');
Route::get('/admin/manajemenMenu', [MenuController::class, 'manajemenMenu'])->name('manajemenMenu');

// ==================== Kasir Management ====================
Route::get('/admin/create-kasir', [UsersController::class, 'kasirCreate'])->name('kasir.create');
Route::post('/admin/store-kasir', [UsersController::class, 'kasirStore'])->name('kasir.store');
Route::get('/admin/{id}/edit', [UsersController::class, 'kasirEdit'])->name('kasir.edit');
Route::post('/admin/{id}/update', [UsersController::class, 'kasirUpdate'])->name('kasir.update');
Route::get('/admin/{id}/kasir-delete', [UsersController::class, 'kasirDelete'])->name('kasir.delete');

// ==================== Manajemen Menu ====================
Route::prefix('admin')->group(function () {
    Route::get('/create-menu', [MenuController::class, 'menuCreate'])->name('menu.create');
    Route::post('/store-menu', [MenuController::class, 'menuStore'])->name('menu.store');
    Route::get('/{id}/edit-menu', [MenuController::class, 'menuEdit'])->name('menu.edit');
    Route::put('/{id}/update-menu', [MenuController::class, 'menuUpdate'])->name('menu.update');
    Route::get('/{id}/menu-delete', [MenuController::class, 'menuDelete'])->name('menu.delete');
});
