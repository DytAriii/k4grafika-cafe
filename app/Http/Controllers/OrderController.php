<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Category;
use App\Models\Status;

class OrderController extends Controller
{
public function order()
{
    $menus = Menu::all();
    $categories = Category::all();
    $statuses = Status::all();
    return view('kasir.order', compact('menus', 'categories', 'statuses'));
}
    
    // Tambah ke Cart
    // Tambah ke Cart
public function addToCart(Request $request, $id)
{
    $menu = Menu::findOrFail($id);
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['qty']++;
        $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['harga'];
    } else {
        $cart[$id] = [
            'id'       => $menu->id,
            'nama'     => $menu->nama,
            'harga'    => $menu->harga,
            'qty'      => 1,
            'subtotal' => $menu->harga,
        ];
    }
    session()->put('cart', $cart);

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'summary' => $this->cartSummary($cart)
        ]);
    }

    return back();
}

// OrderController
public function update(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $qty = (int) $request->qty;

        // Batasi minimal 1
        if ($qty < 1) {
            $qty = 1;
        }

        $cart[$id]['qty'] = $qty;
        $cart[$id]['subtotal'] = $cart[$id]['harga'] * $qty;
        session()->put('cart', $cart);
    }

    return response()->json([
        'success' => true,
        'cart' => $cart,
        'summary' => [
            'total_items' => count($cart),
            'total_qty'   => array_sum(array_column($cart, 'qty')),
            'total_price' => array_sum(array_column($cart, 'subtotal')),
        ],
    ]);
}

public function removeFromCart(Request $request, $id)
{
    $cart = session()->get('cart', []);
    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'summary' => $this->cartSummary($cart)
        ]);
    }

    return back();
}

private function cartSummary($cart)
{
    return [
        'total_items' => count($cart),
        'total_qty'   => array_sum(array_column($cart, 'qty')),
        'total_price' => array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], $cart)),
    ];
}

    // Checkout & simpan transaksi ke DB
    public function checkout(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string|max:100',
            'order_type'    => 'required|in:dine_in,take_away',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong.');
        }

        // Simpan transaksi utama
        $transaksi = Transaksi::create([
            'nama_customer' => $request->nama_customer,
            'order_type'    => $request->order_type,
            'total'         => array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], $cart)),
        ]);

        // Simpan detail transaksi
        foreach ($cart as $item) {
            $transaksi->detail()->create([
                'menu_id' => $item['id'],
                'qty'     => $item['qty'],
                'harga'   => $item['harga'],
            ]);
        }

        // Kosongkan keranjang setelah checkout
        session()->forget('cart');

        return redirect()->route('kasir.order')->with('success', 'Transaksi berhasil disimpan!');
    }
    public function reset()
{
    // misalnya clear session cart
    session()->forget('cart');

    return redirect()->route('kasir.order')->with('success', 'Pesanan berhasil direset.');
}

}
