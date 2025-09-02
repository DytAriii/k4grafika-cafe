<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['user_id','total','diskon','bayar','metode_pembayaran'];

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
