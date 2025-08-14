<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use Illuminate\Support\Facades\Hash;

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
                return redirect()->route('home');
            } elseif ($users->role === 'admin') {
                return redirect()->route('daftarKasir');
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
        return view('daftarKasir', compact('users'));
    }

        public function kasirCreate()
    {
        return view('siswa.create');
    }
}
