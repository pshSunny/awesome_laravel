<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/**
 * 이메일 인증 서비스에 대한 비즈니스 로직
 */
class EmailVerificationController extends Controller
{
    /**
     * 회원 가입하고 이메일 인증 전송 후 리다이렉트되는 화면
     */
    public function notice()
    {
        return view('auth.verify-email');
    }

    /**
     * 이메일 인증
     * EmailVerificationRequest 사용자 정의 폼 요청
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill(); // 이메일 인증

        return redirect()->to(RouteServiceProvider::HOME);
    }

    /**
     * 이메일 인증 재전송
     */
    public function send(Request $request)
    {
        $user = $request->user();

        $user->sendEmailVerificationNotification(); // 이메일 재전송

        return back();
    }
}
