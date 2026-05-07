<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomOrder extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'track_id_pos', 'track_id_store',
        'customer_email', 'qty', 'subject', 'notes', 'reference_file',
        'estimated_price', 'type', 'status', 'fulfilled_by',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
