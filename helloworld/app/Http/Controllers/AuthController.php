<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function create() {
        return view('auth.regist');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => [Password::defaults()]
        ]);

        $user = User::create(request(['name', 'email', 'password']));
        return redirect()->to('/auth/login');
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
