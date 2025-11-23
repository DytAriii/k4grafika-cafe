<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Status; 
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function manajemenMenu()
    {
        if (!session()->has('users_id')) {
            return redirect()->route('login');
        }

        $menu = Menu::with(['category', 'status'])->get(); 
        $categories = Category::all();
        $statuses = Status::all();

        return view('admin.manajemenmenu', compact('menu', 'categories', 'statuses'));
    }

    public function menuCreate()
    {
        $categories = Category::all();
        $statuses = Status::all();
        return view('admin.create-menu', compact('categories', 'statuses'));
    }

    public function menuStore(Request $request) 
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'categories_id' => 'required',
            'status_id' => 'required',
            'gambar' => 'required|image|mimes:jpg,JPG,jpeg,JPEG,png,webp'
        ]);

        $data = $request->only('nama', 'harga', 'categories_id', 'status_id');
        $data['gambar'] = $request->file('gambar')->store('menu', 'public');

        Menu::create($data);

        return redirect()->route('manajemenMenu');
    }

    public function menuDelete($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
            Storage::disk('public')->delete($menu->gambar);
        }

        $menu->delete();

        return redirect()->route('manajemenMenu');
    }

    public function menuEdit($id)
    {
        $categories = Category::all();
        $statuses = Status::all();
        $menu = Menu::findOrFail($id);

        return view('admin.edit-menu', compact('menu', 'categories', 'statuses'));
    }

    public function menuUpdate(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'categories_id' => 'required',
            'status_id' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,JPG,jpeg,JPEG,png,webp'
        ]);

        $data = $request->only('nama', 'harga', 'categories_id', 'status_id');

        if ($request->hasFile('gambar')) {
            if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
                Storage::disk('public')->delete($menu->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('menu', 'public');
        }

        $menu->update($data);

        return redirect()->route('manajemenMenu');
    }
}
