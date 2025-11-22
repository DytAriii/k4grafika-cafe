<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class users extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = ['username', 'password', 'roles_id'];

    // Relasi ke transaksi (untuk kasir)
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }
}
