<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * 로그인 폼
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * 로그인
     */
    public function login(LoginRequest $request)
    {
        // 첫 번째 매개변수: 로그인 처리, 두 번째 매개변수: 로그인 유지 여부
        if (! auth()->attempt($request->validated(), $request->boolean('remember'))) {
            // 뷰에서 $errors 사용하여 에러 표현
            return back()->withErrors(['failed' => __('auth.failed')]);
        }

        // 사용자 접근 시도했던 페이지로 리턴
        return redirect()->intended();
    }

    /**
     * 로그아웃
     */
    public function logout(Request $request)
    {
        auth()->logout(); // 로그아웃 처리
        $request->session()->invalidate(); // 보안 위해 세션 ID 재생성과 모든 값 지움
        $request->session()->regenerateToken(); // CSRF TOKEN 갱신
        return redirect()->to(RouteServiceProvider::HOME);
    }
}
