<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $fillable = ['nama', 'harga', 'categories_id', 'status_id', 'gambar'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
