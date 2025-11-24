<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        'invoice','customer_name','total_items','total_qty','total_price',
        'payment_method','paid_amount','change_amount','status'
    ];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
