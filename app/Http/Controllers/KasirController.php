<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class KasirController extends Controller
{
    public function order(Request $request)
    {
        // Ambil semua kategori
        $categories = Category::all();

        // Ambil kategori pertama (misalnya Coffee) kalau ada
        $firstCategory = Category::first();

        // Ambil menu berdasarkan kategori pertama
        $menus = $firstCategory 
            ? Menu::where('kategori', $firstCategory->id)->get() 
            : collect();

        return view('kasir.order', compact('categories', 'menus'));
    }

    public function getMenusByCategory($id)
    {
        // Ambil menu berdasarkan kolom 'kategori' (bukan 'category_id')
        $menus = Menu::where('kategori', $id)->get();
        return response()->json($menus);
    }
}
