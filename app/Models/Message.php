<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id', 'order_id', 'custom_order_id', 'sender_name',
        'message', 'url_pdf', 'is_reply', 'replied_by', 'read_at',
    ];

    public function user() { return $this->belongsTo(User::class); }
}
