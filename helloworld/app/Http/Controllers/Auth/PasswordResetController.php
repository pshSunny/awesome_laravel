<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetLinkRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * 비밀번호 재설정 요청 폼
     */
    public function request()
    {
        return view('auth.forgot-password');
    }

    /**
     * 비밀번호 재설정 링크 이메일 발송
     */
    public function email(SendResetLinkRequest $request)
    {
        $status = Password::sendResetLink($request->validated()); // 비밀번호 초기화를 위한 이메일 발송

        return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
    }

    /**
     * 비밀번호 재설정 폼
     */
    public function reset(string $token)
    {
        return view('auth.reset-password', [
            'token' => $token
        ]);
    }

    /**
     * 비밀번호 재설정 업데이트
     */
    public function update(ResetPasswordRequest $request)
    {
        // 비밀번호 강제 설정 (email 속성 및 비밀번호 확인 등 유효성 검증  + token 검증)
        $status = Password::reset($request->validated(), function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ]) // 비밀번호 강제로 재설정
            ->setRememberToken(Str::random(60)); // RememberToken 초기화

            $user->save(); // 저장

            event(new PasswordReset($user)); // PasswordReset 이벤트 발동하여 비밀번호 리셋되었음을 어플리케이션에 알림
        });

        return $status === Password::PASSWORD_RESET
        ? to_route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
    }
}
