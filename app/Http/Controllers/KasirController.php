<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class KasirController extends Controller
{
    // Tampilkan semua menu dengan kategori
    public function index()
    {
        $menus = Menu::with('category')->get();
        return view('menus.index', compact('menus'));
    }

    // Halaman order (ambil kategori & menu pertama)
    public function order(Request $request)
    {
        $categories = Category::all();
        $firstCategory = Category::first();

        $menus = $firstCategory 
            ? Menu::where('kategori_id', $firstCategory->id)->get() 
            : collect();

        return view('kasir.order', compact('categories', 'menus'));
    }

    // Ambil menu berdasarkan kategori (AJAX)
    public function getMenusByCategory($kategoriId)
    {
        $menus = Menu::where('kategori_id', $kategoriId)->get();
        return response()->json($menus);
    }

public function payment(Request $request)
{
    $data = session('payment_data');
    if (!$data) {
        return redirect()->route('kasir.order')->with('error', 'Tidak ada data pembayaran. Silakan pilih menu dan klik Bayar.');
    }

    // Kirim ke view payment (payment.blade.php)
    return view('kasir.payment', ['payment' => $data]);
}

    // Riwayat transaksi
    public function history()
    {
        return view('kasir.history');
    }

    // Halaman menu (status menu habis / aktif)
    public function menu()
    {
        return view('kasir.menu');
    }

    // Halaman soldout (menu habis)
    public function soldout()
    {
        return view('kasir.soldout');
    }
}
