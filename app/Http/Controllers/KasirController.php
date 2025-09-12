<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\roles;
use Illuminate\Support\Facades\Hash;

class KasirController extends Controller
{
<<<<<<< HEAD
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
=======
    public function daftarKasir()
    {
        if (!session()->has('users_id')) {
            return redirect()->route('login');
        }
        $users = users::all();
        return view('admin.daftarKasir', compact('users'));
>>>>>>> 4d38b0132f808684e37c934d4380ccb2422a8ac4
    }

    public function kasirCreate()
    {
        $roles = roles::where('id', 2)->where('nama_role', 'kasir')->first();
        return view('admin.kasir-create', compact('roles'));
    }

    public function kasirStore(Request $request)
    {
        $data = $request->only('username', 'roles_id');
        $data['password'] = Hash::make($request->password);
        users::create($data);
        return redirect()->route('daftarKasir');
    }

    public function kasirEdit($id)
    {
        $users = users::findOrFail($id);
        return view('admin.kasir-edit', compact('users'));
    }

    public function kasirUpdate(Request $request, $id)
    {
        $users = users::findOrFail($id);
        $users->update($request->only('username', 'roles_id'));
        if ($request->filled('password')) {
            $users->password = Hash::make($request->password);
        }
        $users->save();
        return redirect()->route('daftarKasir');
    }

    public function kasirDelete($id)
    {
        $users = users::findOrFail($id);
        $users->delete();
        return redirect()->route('daftarKasir');
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
