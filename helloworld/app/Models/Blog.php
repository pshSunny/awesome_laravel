<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Blog는 User에 속함
    }

    /**
     * 라우트 키를 id(PK) 대신 name으로 지정
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Blog 관점에서 User 내 구독자(subscriber) 지칭
     */
    public function subscribers()
    {
        return $this->belongsToMany(User::class)->as('subscription');
    }

    public function posts()
    {
        return $this->hasMany(Post::class); // Blog에 속한 Post 리스트
    }

    /**
     * 관련 게시물을 통해 연결된 댓글을 검색하는 다대다-중계 관계입니다.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function comments()
    {
        // hasManyThrough : 댓글의 상위모델인 Post를 거치지 않고도 블러그에 소속된 모든 댓글 조회
        // 댓글은 다형성 관계로 secondKey와 where() 사용
        return $this->hasManyThrough(Comment::class, Post::class, secondKey: 'commentable_id')
            ->where('commentable_type', Post::class);
    }
}
