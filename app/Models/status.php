<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class status extends Model
{
    protected $table = 'status';
    use HasFactory;

    protected $fillable = ['nama_status'];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'categories_id');
    }
}
