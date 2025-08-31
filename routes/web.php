<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usersController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OrderController;

// ==================== Kasir ====================
Route::get('/kasir/order', [KasirController::class, 'order'])->name('kasir.order');
Route::get('/order/category/{id}', [KasirController::class, 'getMenusByCategory']);

// ==================== Order & Cart ====================
Route::post('/order/add/{id}', [OrderController::class, 'addToCart'])->name('order.add');
Route::post('/order/update/{id}', [OrderController::class, 'update'])->name('order.update');
Route::post('/order/remove/{id}', [OrderController::class, 'removeFromCart'])->name('order.remove');
Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/order/reset', [OrderController::class, 'reset'])->name('order.reset');

// ==================== Login ====================
Route::get('/', [usersController::class, 'formLogin'])->name('login'); 
Route::post('/', [usersController::class, 'prosesLogin'])->name('login.post');

// ==================== Home ====================
Route::get('/home', [usersController::class, 'home'])->name('home');

// ==================== Kasir Management ====================
Route::get('/admin/create-kasir', [usersController::class, 'kasirCreate'])->name('kasir.create');
Route::post('/admin/store-kasir', [usersController::class, 'kasirStore'])->name('kasir.store');
Route::get('/admin/{id}/edit', [usersController::class, 'kasirEdit'])->name('kasir.edit');
Route::post('/admin/{id}/update', [usersController::class, 'kasirUpdate'])->name('kasir.update');
Route::get('/admin/{id}/kasir-delete', [usersController::class, 'kasirDelete'])->name('kasir.delete');

// ==================== Logout ====================
Route::get('/logout', [usersController::class, 'logout'])->name('logout');

// ==================== Admin Dashboard ====================
Route::get('/admin', [usersController::class, 'dashboard'])->name('admin');
Route::get('/admin/dashboard', [usersController::class, 'dashboard'])->name('dashboard');
Route::get('/admin/daftarKasir', [usersController::class, 'daftarKasir'])->name('daftarKasir');
Route::get('/admin/manajemenMenu', [usersController::class, 'manajemenMenu'])->name('manajemenMenu');

// ==================== Manajemen Menu ====================
Route::prefix('admin')->group(function () {
    Route::get('/create-menu', [usersController::class, 'menuCreate'])->name('menu.create');
    Route::post('/store-menu', [usersController::class, 'menuStore'])->name('menu.store');
    Route::get('/{id}/edit-menu', [usersController::class, 'menuEdit'])->name('menu.edit');
    Route::put('/{id}/update-menu', [usersController::class, 'menuUpdate'])->name('menu.update');
    Route::get('/{id}/menu-delete', [usersController::class, 'menuDelete'])->name('menu.delete');
});
