<?php

namespace App\Models;
use App\Models\TransaksiDetail;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','invoice','nama_customer', 'catatan',
        'total','diskon','bayar','kembali','metode_pembayaran'
    ];

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // Relasi ke kasir (user yang melayani transaksi)
    public function kasir()
    {
        // Pastikan kolom di tabel transaksi bernama 'user_id'
        return $this->belongsTo(Users::class, 'user_id', 'id')->withDefault();
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
