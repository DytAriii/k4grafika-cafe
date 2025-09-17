<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    // public function index(Request $request)
    // {
    //     $today = now()->toDateString();

    //     // 1) Hitung jumlah transaksi yang dibuat hari ini
    //     $todayCount = Transaksi::whereDate('created_at', $today)->count();

    //     // 2) Jumlahkan total (kolom `total`) semua transaksi hari ini
    //     $todayTotal = Transaksi::whereDate('created_at', $today)->sum('total');

    //     // 3) Cari menu terlaris hari ini (dari tabel detail transaksi)
    //     $topMenu = TransaksiDetail::select('menu_id', DB::raw('SUM(jumlah) as total_qty'))
    //         ->groupBy('menu_id')
    //         ->orderByDesc('total_qty')
    //         ->with('menu')   // eager load relasi menu supaya bisa ambil nama
    //         ->first();

    //     $topMenuName = $topMenu?->menu?->nama ?? '-';

    //     // 4) Hitung jumlah kasir (user) yang aktif hari ini — distinct user_id
    //     $activeCashiers = Transaksi::whereDate('created_at', $today)->distinct('user_id')->count('user_id');

    //     // 5) Hitung jumlah menu aktif (contoh sederhana dari tabel Menu)
    //     $activeMenus = Menu::where('status', 'active')->count();

    //     // 6) Return data ke view dashboard
    //     return view('admin.dashboard', compact(
    //         'todayCount',
    //         'todayTotal',
    //         'topMenuName',
    //         'activeCashiers',
    //         'activeMenus'
    //     ));
    // }

    public function index()
    {
        return view('admin.dashboard');
    }
}
