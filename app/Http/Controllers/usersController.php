<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class usersController extends Controller
{
    public function formLogin()
    {
        return view('login');
    }

    public function prosesLogin(Request $request)
    {
        $users = users::where('username', $request->username)->first();
        if ($users && Hash::check($request->password, $users->password)) {
            session([
                'users_id' => $users->id,
                'users_username' => $users->username,
                'users_role' => $users->role
            ]);

            if ($users->role === 'kasir') {
                return redirect()->route('kasir.order');
            } elseif ($users->role === 'admin') {
                return redirect()->route('admin');
            } else {
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
        if (!session()->has('users_id')) {
            return redirect()->route('login');
        }
        $users = users::all();
        return view('admin.daftarKasir', compact('users'));
    }

    public function kasirCreate()
    {
        return view('admin.kasir-create');
    }

    public function kasirStore(Request $request)
    {
        $data = $request->only('username', 'role');
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
        session()->forget(['users_id', 'users_username']);
        return redirect()->route('login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function manajemenMenu()
    {
        if (!session()->has('users_id')) {
            return redirect()->route('login');
        }
        $menu = Menu::all();
        return view('admin.manajemenMenu', compact('menu'));
    }

    public function menuCreate()
    {
        $categories = Category::all();
        return view('admin.create-menu', compact('categories'));
    }

    public function menuEdit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit-menu', compact('menu', 'categories'));
    }

    public function menuStore(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|exists:categories,id',
            'status' => 'required',
            'gambar' => 'required|image|mimes:jpg,JPG,jpeg,JPEG,png'
        ]);

        $data = $request->only('nama', 'harga', 'kategori_id', 'status');
        $data['gambar'] = $request->file('gambar')->store('menu', 'public');

        Menu::create($data);

        return redirect()->route('manajemenMenu')->with('success', 'Menu berhasil ditambahkan!');
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

    public function menuUpdate(Request $request, $id)
{
    $menu = Menu::findOrFail($id);

    $request->validate([
        'nama' => 'required',
        'harga' => 'required|numeric',
        'kategori_id' => 'required|exists:categories,id',
        'status' => 'required',
        'gambar' => 'nullable|image|mimes:jpg,JPG,jpeg,JPEG,png'
    ]);

    $data = $request->only('nama', 'harga', 'kategori_id', 'status');

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
