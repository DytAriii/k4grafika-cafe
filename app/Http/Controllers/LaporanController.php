<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // Menampilkan laporan harian
    public function harian()
    {
        $laporan = DB::table('penjualan_harian')
                    ->orderBy('tanggal', 'desc')
                    ->get();

        $totalKeseluruhan = $laporan->sum('total');

        return view('kasir.harian', compact('laporan', 'totalKeseluruhan'));
    }
}
