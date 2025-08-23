<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\Menu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class usersController extends Controller
{
    public function formLogin() //mengatur halaman login
    {
        return view('login');
    }

    public function prosesLogin(Request $request) //menangani proses login
    {
        $users = users::where('username', $request->username)->first();
        if ($users && Hash::check($request->password, $users->password)) {
            // simpan ke session
            session([
                'users_id' => $users->id,
                'users_username' => $users->username,
                'users_role' => $users->role // simpan role ke session jika perlu
            ]);

            if ($users->role === 'kasir') {
                return redirect()->route('kasir.order');
            } elseif ($users->role === 'admin') {
                return redirect()->route('admin');
            } else {
                // Jika role tidak dikenali, diarahkan ke halaman login
                return redirect()->route('login');
            }
        }
        return back()->with('error', 'Username atau password salah.');
    }

    public function home()
    {
        return view('home');
    }

    public function daftarKasir()
    {
        if (!session()->has('users_id')) { //mengecek session
            return redirect()->route('login');
        }
        $users = users::all(); // Ambil semua data pengguna dalam tabel
        return view('admin.daftarKasir', compact('users'));
    }

    public function kasirCreate()
    {
        return view('admin.kasir-create');
    }

    public function kasirStore(Request $request) //untuk menyimpan data kasir
    {
        $data = $request->only('username', 'role');
        $data['password'] = Hash::make($request->password); // hash password sebelum simpan
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
        $users->update($request->only('username', 'role'));
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

    public function logout()
    {
        //hapus session
        session()->forget(['users_id', 'users_username']);
        return redirect()->route('login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function manajemenMenu()
    {
        if (!session()->has('users_id')) { //mengecek session
            return redirect()->route('login');
        }
        $menu = Menu::all(); // Ambil semua data menu dalam tabel
        return view('admin.manajemenMenu', compact('menu'));
    }

    public function menuCreate()
    {
        return view('admin.create-menu');
    }

    public function menuStore(Request $request) //untuk menyimpan data menu
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required',
            'status' => 'required',
            'gambar' => 'required|image|mimes:jpg,JPG,jpeg,JPEG,png'
        ]);

        $data = $request->only('nama', 'harga', 'kategori', 'gambar', 'status');
        $data['gambar'] = $request->file('gambar')->store('menu', 'public');
        Menu::create($data);
        return redirect()->route('manajemenMenu');
    }

    public function menuDelete($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus file gambar dari storage jika ada
        if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
            Storage::disk('public')->delete($menu->gambar);
        }

        $menu->delete();
        return redirect()->route('manajemenMenu');
    }

    public function menuEdit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.edit-menu', compact('menu'));
    }

    public function menuUpdate(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori' => 'required',
            'status' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,JPG,jpeg,JPEG,png'
        ]);

        $data = $request->only('nama', 'harga', 'kategori', 'status');

        if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
            Storage::disk('public')->delete($menu->gambar);
        }
        // Simpan gambar baru
        $data['gambar'] = $request->file('gambar')->store('menu', 'public');
    }

        $menu->update($data);
        return redirect()->route('manajemenMenu');
    }
}
