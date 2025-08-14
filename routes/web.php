<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usersController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [usersController::class, 'formLogin'])->name('login'); //menangani page login(page pertama yang didatangi admin/kasir)

Route::post('/', [usersController::class, 'prosesLogin'])->name('login.post');//mengangani proses login
Route::get('/daftarkasir', [usersController::class, 'daftarKasir'])->name('daftarKasir');//Rute ke halaman daftar kasir
Route::get('/home', [usersController::class, 'home'])->name('home');//rute ke halaman home

Route::get('/admin/create', [usersController::class, 'kasirCreate'])->name('kasir.create'); //rute ke Tambah Kasir
Route::post('/admin/store', [usersController::class, 'kasirStore'])->name('kasir.store'); //simpan data kasir

Route::get('/admin/{id}/edit', [usersController::class, 'kasirEdit'])->name('kasir.edit');//rute ke halaman edit kasir ---> mengirimkan id
Route::post('/admin/{id}/update', [usersController::class, 'kasirUpdate'])->name('kasir.update');//update data kasir

Route::get('/admin/{id}/delete', [usersController::class, 'kasirDelete'])->name('kasir.delete'); //hapus data kasir
Route::get('/logout', [usersController::class, 'logout'])->name('logout');
