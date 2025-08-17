<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'content'
    ];

    public function user()
    {
        // Comment belongs to User
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        // commentable_id : 외래키, commentable_type : 네임스페이스 포함한 클래스(Ex. App\Models\Post)
        return $this->morphTo();
    }

    public function parent()
    {
        // 자식 댓글에서 부모 댓글 조회 (소프트 삭제된 모델도 포함)
        return $this->belongsTo(Comment::class, 'parent_id')
            ->withTrashed();
    }

    public function replies()
    {
        // 부모 댓글에서 자식 댓글 조회 (소프트 삭제된 모델도 포함)
        return $this->hasMany(Comment::class, 'parent_id')
            ->withTrashed();
    }
}
