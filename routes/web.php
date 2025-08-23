<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usersController;
use App\Http\Controllers\KasirController;

Route::get('/kasir/order', [KasirController::class, 'order'])->name('kasir.order');
// ambil menu berdasarkan kategori (AJAX)
Route::get('/order/category/{id}', [KasirController::class, 'getByCategory'])->name('order.category');
// tambah ke keranjang (sementara dummy)
Route::post('/order/add/{id}', [KasirController::class, 'addToCart'])->name('order.add');

Route::get('/', [usersController::class, 'formLogin'])->name('login'); //menangani page login(page pertama yang didatangi admin/kasir)

Route::post('/', [usersController::class, 'prosesLogin'])->name('login.post');//mengangani proses login

Route::get('/home', [usersController::class, 'home'])->name('home');//rute ke halaman home

Route::get('/admin/create-kasir', [usersController::class, 'kasirCreate'])->name('kasir.create'); //rute ke Tambah Kasir
Route::post('/admin/store-kasir', [usersController::class, 'kasirStore'])->name('kasir.store'); //simpan data kasir

Route::get('/admin/{id}/edit', [usersController::class, 'kasirEdit'])->name('kasir.edit');//rute ke halaman edit kasir ---> mengirimkan id
Route::post('/admin/{id}/update', [usersController::class, 'kasirUpdate'])->name('kasir.update');//update data kasir

Route::get('/admin/{id}/kasir-delete', [usersController::class, 'kasirDelete'])->name('kasir.delete'); //hapus data kasir
Route::get('/logout', [usersController::class, 'logout'])->name('logout');

//admin
Route::get('/admin', [usersController::class, 'dashboard'])->name('admin'); //rute ke halaman dashboard admin
Route::get('/admin/dashboard', [usersController::class, 'dashboard'])->name('dashboard'); //rute ke halaman dashboard
Route::get('/admin/daftarKasir', [usersController::class, 'daftarKasir'])->name('daftarKasir');//Rute ke halaman daftar kasir
Route::get('/admin/manajemenMenu', [usersController::class, 'manajemenMenu'])->name('manajemenMenu');//rute ke halaman manajemen menu


//manajemen menu
Route::get('/admin/create-menu', [usersController::class, 'menuCreate'])->name('menu.create'); //rute ke Tambah menu
Route::post('/admin/store-menu', [usersController::class, 'menuStore'])->name('menu.store'); //simpan data menu

Route::get('/admin/{id}/edit-menu', [usersController::class, 'menuEdit'])->name('menu.edit');//rute ke halaman edit menu ---> mengirimkan id
Route::patch('/admin/{id}/update-menu', [usersController::class, 'menuUpdate'])->name('menu.update');//update data menu

Route::get('/admin/{id}/menu-delete', [usersController::class, 'menuDelete'])->name('menu.delete'); //hapus data menu