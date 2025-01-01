<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create() {
        return view('auth.regist');
    }

    public function store(RegisterUserRequest $request) {
        // 인자 Request $request -> RegisterUserRequest $request 변경 전 유효성 검증
        // $request->validate([
        //     'name' => 'required|max:255',
        //     'email' => 'required|email|unique:users|max:255',
        //     'password' => [Password::defaults()]
        // ]);

        $user = User::create(request(['name', 'email', 'password']));

        // 이메일 인증 전송 후 리다이렉트
        event(new Registered($user)); // Registered 이벤트 : 이메일 인증 전송
        auth()->login($user);
        return to_route('verification.notice');

        // 로그인 처리 후 홈 라우트로 리다이렉트
        // auth()->login($user); 
        // return redirect()->to('/');

        // 로그인 라우트로 리다이렉트
        // return redirect()->to('/auth/login');
    }

    public function login() {
        return view('auth.login');
    }

    public function login_store(Request $request) {
        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/blog');
        }

        return back()->withErrors(([
            'message' => '이메일 혹은 비밀번호가 일치하지 않습니다.'
        ]));
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/blog');
    }
}
