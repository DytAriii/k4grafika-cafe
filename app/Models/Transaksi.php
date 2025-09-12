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

    public function kasir()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function items()
{
    return $this->hasMany(TransaksiDetail::class);
}

}
