<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id','invoice','nama_customer','order_type',
        'total','diskon','bayar','kembali','metode_pembayaran'
    ];

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // Relasi ke kasir (user yang melayani transaksi)
    public function kasir()
    {
        return $this->belongsTo(User::class, 'user_id'); 
        // sebaiknya pakai 'user_id', bukan 'users_id'
    }

    // Relasi ke detail item
    public function items()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // Simpan relasi lama kalau masih ingin dipakai (optional)
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
