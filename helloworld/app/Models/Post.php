<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class); // Post는 Blog에 속함
    }

    /**
     * 코멘트 리스트
     */
    public function comments()
    {
        // 포스트는 다형성 관계를 통해 여러 댓글을 가질 수 있음 (삭제된 댓글 포함)
        return $this->morphMany(Comment::class, 'commentable')->withTrashed();
    }
}
