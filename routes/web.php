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

Route::get('/admin/create', [usersController::class, 'kasirCreate'])->name('kasir.create'); //Tambah Kasir