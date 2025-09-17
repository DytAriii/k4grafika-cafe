<?php

use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\dashboardController;

// ==================== Kasir ====================
Route::get('/kasir/order', [OrderController::class, 'order'])->name('kasir.order');
Route::get('/order/category/{id}', [KasirController::class, 'getMenusByCategory']);
Route::get('/kasir/history', [KasirController::class, 'history'])->name('kasir.history');
Route::get('/menu/menuHabis/', [OrderController::class, 'menuHabis'])->name('menuhabis');
Route::post('/menu/updateStatus', [OrderController::class, 'updateMenuStatus'])->name('menuhabis.update');
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

// pindah kategori
Route::get('/order/category/{id}', function ($id) {
    if ($id === 'all') {
        return Menu::all();
    }
    return Menu::where('categories_id', $id)->get();
});

// print nota
Route::get('/kasir/print/{id}', [KasirController::class, 'print'])->name('kasir.print');

// ==================== Login ====================
Route::get('/', [UsersController::class, 'formLogin'])->name('login');
Route::post('/', [UsersController::class, 'prosesLogin'])->name('login.post');
Route::get('/home', [UsersController::class, 'home'])->name('home');
Route::get('/logout', [UsersController::class, 'logout'])->name('logout');

// ==================== Admin Dashboard ====================
Route::get('/admin/dashboard', [dashboardController::class, 'index'])->name('dashboard');
Route::get('/admin/daftarKasir', [KasirController::class, 'daftarKasir'])->name('daftarKasir');
Route::get('/admin/manajemenMenu', [MenuController::class, 'manajemenMenu'])->name('manajemenMenu');

// ==================== Kasir Management ====================
Route::get('/admin/create-kasir', [KasirController::class, 'kasirCreate'])->name('kasir.create');
Route::post('/admin/store-kasir', [KasirController::class, 'kasirStore'])->name('kasir.store');
Route::get('/admin/{id}/edit', [KasirController::class, 'kasirEdit'])->name('kasir.edit');
Route::patch('/admin/{id}/update', [KasirController::class, 'kasirUpdate'])->name('kasir.update');
Route::get('/admin/{id}/kasir-delete', [KasirController::class, 'kasirDelete'])->name('kasir.delete');

// ==================== Manajemen Menu ====================
Route::prefix('admin')->group(function () {
    Route::get('/create-menu', [MenuController::class, 'menuCreate'])->name('menu.create');
    Route::post('/store-menu', [MenuController::class, 'menuStore'])->name('menu.store');
    Route::get('/{id}/edit-menu', [MenuController::class, 'menuEdit'])->name('menu.edit');
    Route::patch('/{id}/update-menu', [MenuController::class, 'menuUpdate'])->name('menu.update');
    Route::get('/{id}/menu-delete', [MenuController::class, 'menuDelete'])->name('menu.delete');
});