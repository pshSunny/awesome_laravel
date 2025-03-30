<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword as ResettablePassword;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use ResettablePassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * 비밀번호 해싱
     */
    public function setPasswordAttribute($password)
    {
        // $this->attributes['password'] = bcrypt($password);
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * 블로그
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class); // User 한명이 여러 개의 Blog를 가질 수 있음
    }

    /**
     * User 관점에서 Blog 구독(subscription) 지칭
     */
    public function subscriptions()
    {
        return $this->belongsToMany(Blog::class)->as('subscription');
    }
}
