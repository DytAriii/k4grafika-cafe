<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 30 transaksi dengan detail
        Transaksi::factory()
            ->count(30)
            ->create()
            ->each(function ($transaksi) {
                // Setiap transaksi punya 1-4 item menu
                $jumlahItem = rand(1, 4);
                
                $totalTransaksi = 0;
                
                for ($i = 0; $i < $jumlahItem; $i++) {
                    $detail = TransaksiDetail::factory()->make();
                    $detail->transaksi_id = $transaksi->id;
                    $detail->save();
                    
                    $totalTransaksi += $detail->subtotal;
                }
                
                // Update total transaksi berdasarkan detail
                $diskon = $transaksi->diskon;
                $totalSetelahDiskon = $totalTransaksi - $diskon;
                $bayar = $totalSetelahDiskon + rand(0, 50000);
                $kembali = $bayar - $totalSetelahDiskon;
                
                $transaksi->update([
                    'total' => $totalTransaksi,
                    'bayar' => $bayar,
                    'kembali' => $kembali,
                ]);
            });
    }
}
