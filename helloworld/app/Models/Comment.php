<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'blog_post_id', 'user_id'];

    public function post() {
        return $this->belongsTo(BlogPost::class);
    }
}
