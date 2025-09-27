<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Str;
use App\Models\Menu;

class TransaksiController extends Controller
{
    /**
     * Simpan transaksi langsung bayar (tanpa halaman payment)
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
            'nama_customer' => $request->nama_customer,
            'catatan'       => $request->catatan ?? null,
            'total'         => $total,
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

    /**
     * Proses pembayaran
     */
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

        // Hitung total dari cart
        $total = collect($data['cart'])->sum(fn($i) => $i['harga'] * $i['qty']);

        // Validasi cash
        if ($request->metode === 'cash') {
            $bayar = $request->bayar ?? 0;
            if ($bayar < $total) {
                return back()->with('error', 'Nominal pembayaran cash kurang dari total.');
            }
        }

        // Buat invoice unik
        $invoice = 'INV-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5));
        
        // Simpan transaksi
        $transaksi = Transaksi::create([
            'invoice' => $invoice,
            'nama_customer' => $data['nama_customer'],
            'catatan' => $data['catatan'] ?? null,
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
    public function history(Request $request)
    {
        // Query dengan relasi
        $query = Transaksi::with('details.menu');

        // Hanya transaksi milik kasir yang sedang login
        $query->where('user_id', session('users_id'));

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice', 'like', "%{$search}%")
                  ->orWhere('nama_customer', 'like', "%{$search}%")
                  ->orWhere('catatan', 'like', "%{$search}%");
            });
        }

        // Filter tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter metode pembayaran
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // Filter order type
        if ($request->filled('order')) {
            $query->where('order_type', $request->order);
        }

        // Ambil data dengan pagination, tetap bawa query filter
        $transaksis = $query->latest()->paginate(10)->appends($request->query());

        return view('kasir.history', compact('transaksis'));
    }

    /**
     * Cetak struk
     */
    public function receipt($id)
    {
        $transaksi = Transaksi::with('details.menu')->findOrFail($id);
        return view('kasir.receipt', compact('transaksi'));
    }
}
