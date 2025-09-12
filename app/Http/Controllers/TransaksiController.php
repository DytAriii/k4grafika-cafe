<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    /**
     * Simpan transaksi langsung bayar
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (!$cart || count($cart) === 0) {
            return redirect()
                ->route('kasir.order')
                ->with('error', 'Keranjang masih kosong!');
        }

        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);

        // Simpan transaksi utama
        $transaksi = Transaksi::create([
            'nama_pelanggan'     => $request->nama_pelanggan,
            'metode_pembayaran'  => $request->metode_pembayaran,
            'total'              => $total,
        ]);

        // Simpan detail transaksi
        foreach ($cart as $id => $item) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'menu_id'      => $id,
                'jumlah'       => $item['qty'],
                'harga'        => $item['harga'],
                'subtotal'     => $item['harga'] * $item['qty'],
            ]);
        }

        // Hapus session cart
        session()->forget('cart');

        return redirect()
            ->route('kasir.order')
            ->with('success', 'Transaksi berhasil!');
    }

   public function processPayment(Request $request)
{
    $request->validate([
        'metode' => 'required|in:cash,qris',
        'bayar'  => 'nullable|numeric',
    ]);

    // Ambil data dari session
    $data = session('payment_data');
    if (!$data) {
        return redirect()->route('kasir.order')->with('error', 'Data pembayaran tidak ditemukan.');
    }

    // Hitung total berdasarkan session cart (trusted server-side calculation)
    $total = collect($data['cart'])->sum(fn($i) => $i['harga'] * $i['qty']);

    // Validasi jika cash wajib bayar cukup
    if ($request->metode === 'cash') {
        $bayar = $request->bayar ?? 0;
        if ($bayar < $total) {
            return back()->with('error', 'Nominal pembayaran cash kurang dari total.');
        }
    }

    // invoice
    $invoice = 'INV-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5));

    // Simpan transaksi
    $transaksi = Transaksi::create([
        'invoice' => $invoice,
        'nama_customer' => $data['nama_customer'],
        'order_type' => $data['order_type'],
        'total' => $total,
        'metode_pembayaran' => $request->metode,
        'bayar' => $request->metode === 'cash' ? $request->bayar : null,
        'kembali' => $request->metode === 'cash' ? ($request->bayar - $total) : null,
        'user_id' => session('users_id'),
    ]);

    // Simpan detail transaksi
    foreach ($data['cart'] as $menuId => $item) {
        TransaksiDetail::create([
            'transaksi_id' => $transaksi->id,
            'menu_id' => $item['id'] ?? $menuId,
            'jumlah' => $item['qty'],
            'harga' => $item['harga'],
            'subtotal' => $item['qty'] * $item['harga'],
        ]);
    }

    // Bersihkan session
    session()->forget(['cart', 'payment_data']);

    return redirect()->route('kasir.receipt', $transaksi->id);
}
    /**
     * Riwayat transaksi
     */
    public function history()
    {
        $transaksis = Transaksi::with('details.menu')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kasir.history', compact('transaksis'));
    }

    public function receipt($id)
{
    $transaksi = Transaksi::with('details.menu')->findOrFail($id);
    return view('kasir.receipt', compact('transaksi'));
}
}
