<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class OrderController extends Controller
{
    // Tambah item ke keranjang
    public function addToCart(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
            $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['harga'];
        } else {
            $cart[$id] = [
                'id'      => $menu->id,
                'nama'    => $menu->nama,
                'harga'   => $menu->harga,
                'qty'     => 1,
                'subtotal'=> $menu->harga,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang!');
    }

    // Update jumlah item
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $qty = max(1, (int) $request->qty);
            $cart[$id]['qty'] = $qty;
            $cart[$id]['subtotal'] = $qty * $cart[$id]['harga'];
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Jumlah menu diperbarui!');
    }

    // Hapus item dari keranjang
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Menu dihapus dari keranjang!');
    }

    // Reset keranjang
    public function reset()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Keranjang dikosongkan!');
    }

    // app/Http/Controllers/OrderController.php

public function checkout(Request $request)
{
    $request->validate([
        'nama_customer' => 'required|string|max:100',
        'order_type' => 'required|in:dine_in,takeaway',
    ]);

    $cart = session('cart', []);
    if (empty($cart)) {
        return redirect()->back()->with('error', 'Keranjang kosong.');
    }

    $total = collect($cart)->sum(fn($i) => $i['harga'] * $i['qty']);
    $summary = [
        'nama_customer' => $request->nama_customer,
        'order_type' => $request->order_type,
        'cart' => $cart,
        'total' => $total,
        'total_items' => count($cart),
        'total_qty' => array_sum(array_column($cart, 'qty')),
    ];

    // Simpan di session (sementara)
    session(['payment_data' => $summary]);

    // Redirect ke halaman payment (GET)
    return redirect()->route('kasir.payment');
}
}
