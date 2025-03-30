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
}
