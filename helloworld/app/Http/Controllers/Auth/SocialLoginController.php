<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Provider;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class SocialLoginController extends Controller
{
    /**
     * 서비스 제공자의 권한 승인 페이지로 리다이렉트
     */
    public function redirect(Provider $provider)
    {
        return Socialite::driver($provider->value) // 서비스 제공자 지정
        ->redirect(); // 서비스 제공자의 권한 승인 페이지로 리다이렉트
    }

    /**
     * 콜백
     */
    public function callback(Provider $provider)
    {
        $socialUser = Socialite::driver($provider->value)->user(); // 사용자 정보
        $user = $this->register($socialUser); // 사용자 등록

        auth()->login($user); // 로그인

        session()->socialite($provider, $socialUser->getEmail()); // 세션 지정

        return redirect()->intended();
    }

    /**
     * 사용자 업데이트 또는 생성
     */
    private function register(SocialiteUser $socialUser)
    {
        $name = $socialUser->getName() ?? $socialUser->getNickname(); // name이 없으면 nickname 사용
        $user = User::updateOrCreate([
            'email' => $socialUser->getEmail(),
        ], [
            'name' => $name,
        ]);

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return $user;
    }
}
