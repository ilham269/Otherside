<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'customer_name', 'customer_phone',
        'customer_email', 'qty', 'total_price', 'status', 'payment_proof', 'fulfilled_by',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
