<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class KasirController extends Controller
{
    public function index()
{
    $menus = Menu::with('category')->get();
    return view('menus.index', compact('menus'));
}

    public function order(Request $request)
    {
        // Ambil semua kategori
        $categories = Category::all();

        // Ambil kategori pertama
        $firstCategory = Category::first();

        // Ambil menu berdasarkan kategori pertama
        $menus = $firstCategory 
            ? Menu::where('kategori_id', $firstCategory->id)->get() 
            : collect();

        return view('kasir.order', compact('categories', 'menus'));
    }

    // Ambil menu berdasarkan kategori (AJAX)
    public function getMenusByCategory($kategoriId)
    {
        $menus = Menu::where('kategori_id', $kategoriId)->get();
        return response()->json($menus);
    }
}
