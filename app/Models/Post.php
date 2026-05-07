<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'admin_id', 'title', 'slug', 'thumbnail', 'body',
        'tags', 'meta_title', 'meta_description', 'status', 'published_at',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function admin() { return $this->belongsTo(Admin::class); }
}
