<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usersController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;

// ==================== Kasir ====================
Route::get('/kasir/order', [OrderController::class, 'order'])->name('kasir.order');
Route::get('/order/category/{id}', [KasirController::class, 'getMenusByCategory']);

// ==================== Order & Cart ====================
Route::post('/order/add/{id}', [OrderController::class, 'addToCart'])->name('order.add');
Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
Route::post('/order/remove/{id}', [OrderController::class, 'removeFromCart'])->name('order.remove');
Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/order/reset', [OrderController::class, 'reset'])->name('order.reset');
Route::get('/order/category/{id}', [OrderController::class, 'getMenuByCategory']);

// ==================== Login ====================
Route::get('/', [usersController::class, 'formLogin'])->name('login');
Route::post('/', [usersController::class, 'prosesLogin'])->name('login.post');

// ==================== Home ====================
Route::get('/home', [usersController::class, 'home'])->name('home');

// ==================== Kasir Management ====================
Route::get('/admin/create-kasir', [KasirController::class, 'kasirCreate'])->name('kasir.create');
Route::post('/admin/store-kasir', [KasirController::class, 'kasirStore'])->name('kasir.store');
Route::get('/admin/{id}/edit', [KasirController::class, 'kasirEdit'])->name('kasir.edit');
Route::post('/admin/{id}/update', [KasirController::class, 'kasirUpdate'])->name('kasir.update');
Route::get('/admin/{id}/kasir-delete', [KasirController::class, 'kasirDelete'])->name('kasir.delete');

// ==================== Logout ====================
Route::get('/logout', [usersController::class, 'logout'])->name('logout');

// ==================== Admin Dashboard ====================
Route::get('/admin', [usersController::class, 'dashboard'])->name('admin');
Route::get('/admin/dashboard', [usersController::class, 'dashboard'])->name('dashboard');
Route::get('/admin/daftarKasir', [KasirController::class, 'daftarKasir'])->name('daftarKasir');
Route::get('/admin/manajemenMenu', [MenuController::class, 'manajemenMenu'])->name('manajemenMenu');

// ==================== Manajemen Menu ====================
Route::prefix('admin')->group(function () {
    Route::get('/admin/create-menu', [menuController::class, 'menuCreate'])->name('menu.create'); //rute ke Tambah menu
    Route::post('/admin/store-menu', [menuController::class, 'menuStore'])->name('menu.store'); //simpan data menu
    Route::get('/admin/{id}/edit-menu', [menuController::class, 'menuEdit'])->name('menu.edit'); //rute ke halaman edit menu ---> mengirimkan id
    Route::patch('/admin/{id}/update-menu', [menuController::class, 'menuUpdate'])->name('menu.update'); //update data menu
    Route::get('/admin/{id}/menu-delete', [menuController::class, 'menuDelete'])->name('menu.delete'); //hapus data menu
});
