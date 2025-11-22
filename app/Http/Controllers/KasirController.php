<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Roles;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Transaksi;          
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Hash;

class KasirController extends Controller
{
    // Halaman order (ambil kategori & menu pertama)
    public function order(Request $request)
    {
        $categories = Category::all();
        $firstCategory = Category::first();

        $menus = $firstCategory
            ? Menu::where('categories_id', $firstCategory->id)->get()
            : collect();

        return view('kasir.order', compact('categories', 'menus'));
    }
    
    public function getByCategory($id)
    {
        if ($id === "all") {
            $menus = Menu::with('category')->get();
        } else {
            $menus = Menu::where('categories_id', $id)->with('category')->get();
        }

        return response()->json($menus);
    }

    public function history(Request $request)
    {
        $query = Transaksi::with('details.menu');

        // Filter tanggal
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter metode pembayaran
        if ($request->metode) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // Filter tipe pesanan
        if ($request->order) {
            $query->where('order_type', $request->order);
        }

        // Ambil data dengan filter
        $transaksis = $query->orderBy('created_at', 'desc')->get();

        return view('kasir.history', compact('transaksis'));
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

    // Halaman pembayaran
    public function payment(Request $request)
    {
        $data = session('payment_data');
        if (!$data) {
            return redirect()->route('kasir.order')
                ->with('error', 'Tidak ada data pembayaran. Silakan pilih menu dan klik Bayar.');
        }

        return view('kasir.payment', ['payment' => $data]);
    }

    public function print($id)
    {
        $transaksi = Transaksi::with('details.menu')->findOrFail($id);
        return view('kasir.receipt', compact('transaksi'));
    }

    // ✅ Halaman daftar kasir (sekaligus kirim $roles)
    public function daftarKasir()
    {
        if (!session()->has('users_id')) {
            return redirect()->route('login');
        }

        $users = Users::all();
        $roles = Roles::where('nama_role', 'kasir')->first(); // tambahin ini

        return view('admin.daftarKasir', compact('users', 'roles'));
    }

    public function kasirCreate()
    {
        $roles = Roles::where('id', 2)
            ->where('nama_role', 'kasir')
            ->first();

        return view('admin.kasir-create', compact('roles'));
    }

   public function kasirStore(Request $request)
    {
        Users::create([
            'username' => $request->username,
            'roles_id' => 2,
            'password' => Hash::make($request->password)
        ]);

        return redirect()
            ->route('daftarKasir')
            ->with('success', 'Kasir berhasil ditambahkan!');
    }

    public function kasirEdit($id)
    {
        $users = Users::findOrFail($id);
        return view('admin.kasir-edit', compact('users'));
    }

    public function kasirUpdate(Request $request, $id)
    {
        $users = Users::findOrFail($id);
        $users->update($request->only('username', 'roles_id'));

        if ($request->filled('password')) {
            $users->password = Hash::make($request->password);
        }

        $users->save();

        return redirect()->route('daftarKasir');
    }

    public function destroy($id)
{
    $user = Users::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'Kasir berhasil dihapus');
}

}
