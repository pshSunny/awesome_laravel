<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordConfirmRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordConfirmController extends Controller
{
    /**
     * 비밀번호 확인 폼
     */
    public function showPasswordConfirmationForm()
    {
        return view('auth.confirm-password');
    }

    /**
     * 비밀번호 확인
     */
    public function confirm(PasswordConfirmRequest $request)
    {
        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->passwordConfirmed();

        return redirect()->intended();
    }
}
