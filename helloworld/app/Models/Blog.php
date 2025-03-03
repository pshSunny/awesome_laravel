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
}
