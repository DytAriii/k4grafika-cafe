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
     * Menampilkan laporan kasir dari database
     */
    public function kasirIndex(Request $request)
    {
        // Ambil semua kasir (roles_id = 2)
        $kasirs = \App\Models\Users::where('roles_id', 2)
            ->pluck('username', 'id')
            ->toArray();

        // Jika tidak ada kasir, redirect dengan pesan
        if (empty($kasirs)) {
            return redirect()->back()->with('error', 'Tidak ada kasir yang terdaftar');
        }

        // Pilih kasir pertama sebagai default jika tidak ada yang dipilih
        $selectedKasir = $request->get('kasir', array_key_first($kasirs));

        // Ambil data kasir yang dipilih
        $kasir = \App\Models\Users::find($selectedKasir);

        if (!$kasir) {
            return redirect()->back()->with('error', 'Kasir tidak ditemukan');
        }

        // Ambil transaksi kasir dengan detail menu
        $transaksis = \App\Models\Transaksi::where('user_id', $selectedKasir)
            ->with(['details.menu'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung jam kerja (dari transaksi pertama ke terakhir hari ini)
        $transaksiHariIni = \App\Models\Transaksi::where('user_id', $selectedKasir)
            ->whereDate('created_at', today())
            ->orderBy('created_at')
            ->get();

        $jamKerja = '0 Jam';
        if ($transaksiHariIni->count() > 0) {
            $mulai = $transaksiHariIni->first()->created_at;
            $selesai = $transaksiHariIni->last()->created_at;
            $selisih = $mulai->diffInHours($selesai);
            $jamKerja = $selisih . ' Jam';
        }

        // Format data transaksi untuk view
        $transaksiData = [];
        foreach ($transaksis as $trx) {
            // Gabungkan semua menu dalam transaksi
            $menuList = $trx->details->map(function($detail) {
                return $detail->menu->nama . ' (x' . $detail->jumlah . ')';
            })->join(', ');

            $transaksiData[] = [
                'invoice' => $trx->invoice,
                'menu' => $menuList ?: '-',
                'metode' => ucfirst($trx->metode_pembayaran),
                'total' => 'Rp' . number_format($trx->total, 0, ',', '.'),
                'waktu' => $trx->created_at->format('d-m-Y H:i')
            ];
        }

        // Hitung total pendapatan
        $totalPendapatan = $transaksis->sum('total');
        $rataRata = $transaksis->count() > 0 ? $totalPendapatan / $transaksis->count() : 0;

        $laporan = [
            'nama' => $kasir->username,
            'jam_kerja' => $jamKerja,
            'jumlah_transaksi' => $transaksis->count(),
            'total_pendapatan' => $totalPendapatan,
            'rata_rata' => $rataRata,
            'transaksi' => $transaksiData
        ];

        return view('admin.laporan_kasir', [
            'kasirs' => $kasirs,
            'selectedKasir' => $selectedKasir,
            'laporan' => $laporan
        ]);
    }
}
