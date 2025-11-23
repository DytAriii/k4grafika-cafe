<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Category;
use App\Models\Status;
use App\Helpers\LogActivity;

class OrderController extends Controller
{
    // Halaman order (pilih menu)
    public function order(Request $request)
    {
        $categories = Category::all();
        $statuses   = Status::all();

        $menus = Menu::query();

        // 🔍 filter search nama/harga
        if ($request->filled('search')) {
            $search = $request->search;
            $menus->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('harga', 'like', "%{$search}%");
            });
        }

        // 🔖 filter kategori (jika ada)
        if ($request->filled('category') && $request->category != 'all') {
            $menus->where('categories_id', $request->category);
        }

        $menus = $menus->get();

        return view('kasir.order', compact('menus', 'categories', 'statuses'));
    }

    // Tambah item ke keranjang
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

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart' => $cart,
                'summary' => $this->cartSummary($cart),
            ]);
        }

        return redirect()->back()->with('success', 'Jumlah menu diperbarui!');
    }

    // Hapus item dari keranjang
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

        return redirect()->back()->with('success', 'Menu dihapus dari keranjang!');
    }

    // Reset keranjang
    public function reset()
    {
        session()->forget('cart');
        return redirect()->route('kasir.order')->with('success', 'Keranjang dikosongkan!');
    }

    // Ringkasan keranjang
    private function cartSummary($cart)
    {
        return [
            'total_items' => count($cart),
            'total_qty'   => array_sum(array_column($cart, 'qty')),
            'total_price' => array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], $cart)),
        ];
    }

    // Checkout (simpan data ke session dulu, lalu redirect ke halaman payment)
    public function checkout(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string|max:100',
            'catatan'       => 'nullable|string|max:255',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $total = collect($cart)->sum(fn($i) => $i['harga'] * $i['qty']);
        $summary = [
            'nama_customer' => $request->nama_customer,
            'catatan'       => $request->catatan, 
            'cart'          => $cart,
            'total'         => $total,
            'total_items'   => count($cart),
            'total_qty'     => array_sum(array_column($cart, 'qty')),
        ];

        session(['payment_data' => $summary]);

        return redirect()->route('kasir.payment');
    }

    public function menuHabis()
    {
        $menu = Menu::all();
        $categories = Category::all();
        $statuses = Status::all();

        return view('kasir.menuhabis', compact('menu', 'categories', 'statuses'));
    }

    public function updateMenuStatus(Request $request)
    {
        $statusUpdates = $request->input('status', []);
        foreach ($statusUpdates as $menuId => $statusId) {
            $menu = Menu::find($menuId);
            if ($menu) {
                $menu->status_id = $statusId;
                $menu->save();
            }
        }
        return redirect()->route('menuhabis')->with('success', 'Status menu berhasil diperbarui.');
    }
    
    public function category($id)
    {
        $query = Menu::query();
        if ($id !== 'all') {
            $query->where('category_id', $id);
        }
        $menus = $query->get(['id','nama','harga','gambar','status_id']);
        return response()->json($menus);
    }
}