<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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

            if ($users->roles_id == '2') {
                return redirect()->route('kasir.order');
            } elseif ($users->roles_id == '1') {
                return redirect()->route('dashboard');
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

    public function logout()
    {
        session()->forget(['users_id', 'users_username']);
        return redirect()->route('login');
    }
}
