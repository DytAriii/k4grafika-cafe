<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'harga', 'category', 'gambar', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }
}
