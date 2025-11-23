<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivity;

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
LogActivity::add('Login', $users->nama . ' berhasil login');

            if ($users->roles_id == '2') {
                return redirect()->route('kasir.order');
            } elseif ($users->roles_id == '1') {
                return redirect()->route('admin.dashboard');
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
    $user = users::find(session('users_id')); // Ambil user yang sedang login

    LogActivity::add('Logout', ($user ? $user->nama : 'User') . ' berhasil logout');

    session()->forget(['users_id', 'users_username', 'users_role']);

    return redirect()->route('login');
}

}
