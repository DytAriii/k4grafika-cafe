<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use App\Models\roles;
use Illuminate\Support\Facades\Hash;

class KasirController extends Controller
{
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
}
