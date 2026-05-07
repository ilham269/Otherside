<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'customer_name', 'customer_phone',
        'customer_email', 'qty', 'total_price', 'status', 'payment_proof',
        'fulfilled_by', 'snap_token', 'midtrans_order_id', 'payment_type',
        'shipping_address', 'shipping_city', 'shipping_province',
        'shipping_postal_code', 'shipping_notes',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
