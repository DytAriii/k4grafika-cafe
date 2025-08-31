<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('details.menu')->latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $menus = Menu::where('status', 'on')->get();
        return view('transaksi.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $transaksi = Transaksi::create([
            'user_id' => auth()->id(),
            'total' => $request->total,
            'diskon' => $request->diskon ?? 0,
            'bayar' => $request->bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        foreach ($request->menus as $menu) {
            $subtotal = $menu['jumlah'] * $menu['harga'];
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'menu_id' => $menu['id'],
                'jumlah' => $menu['jumlah'],
                'harga' => $menu['harga'],
                'subtotal' => $subtotal,
            ]);
        }

        return redirect()->route('transaksi.index')->with('success','Transaksi berhasil!');
    }
}
