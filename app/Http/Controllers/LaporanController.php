<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Menampilkan laporan harian dari database
     */
    public function harian()
    {
        $laporan = DB::table('penjualan_harian')
                    ->orderBy('tanggal', 'desc')
                    ->get();

        $totalKeseluruhan = $laporan->sum('total');

        return view('kasir.harian', compact('laporan', 'totalKeseluruhan'));
    }

    /**
     * Menampilkan laporan kasir (versi dummy / contoh)
     */
    public function kasirIndex(Request $request)
    {
        // Dummy data kasir
        $kasirs = [
            1 => "Kasir 1",
            2 => "Kasir 2",
        ];

        $selectedKasir = $request->get('kasir', 1);

        // Dummy laporan per kasir
        $laporan = [
            1 => [
                "nama" => "Kasir 1",
                "jam_kerja" => "4 Jam",
                "jumlah_transaksi" => 20,
                "transaksi" => [
                    [
                        "invoice" => "INV-001",
                        "menu" => "Kopi Hitam",
                        "metode" => "Cash",
                        "total" => "Rp12.000",
                        "waktu" => "22/09/2025 08:10"
                    ],
                    [
                        "invoice" => "INV-002",
                        "menu" => "Cappuccino",
                        "metode" => "QRIS",
                        "total" => "Rp24.000",
                        "waktu" => "22/09/2025 09:00"
                    ]
                ]
            ],
            2 => [
                "nama" => "Kasir 2",
                "jam_kerja" => "2 Jam",
                "jumlah_transaksi" => 9,
                "transaksi" => [
                    [
                        "invoice" => "INV-101",
                        "menu" => "Es Teh",
                        "metode" => "Cash",
                        "total" => "Rp5.000",
                        "waktu" => "21/09/2025 14:20"
                    ],
                    [
                        "invoice" => "INV-102",
                        "menu" => "Roti Bakar",
                        "metode" => "Cash",
                        "total" => "Rp10.000",
                        "waktu" => "21/09/2025 15:05"
                    ]
                ]
            ]
        ];

        return view('admin.laporan_kasir', [
            'kasirs' => $kasirs,
            'selectedKasir' => $selectedKasir,
            'laporan' => $laporan[$selectedKasir]
        ]);
    }
}
