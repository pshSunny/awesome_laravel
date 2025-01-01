<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    /**
     * 인증/권한 점검
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // 인증/권한 점검 필요 X, true 리턴
    }

    /**
     * 유효성 검사
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => ['required', 'max:255', Password::defaults()]
        ];
    }
}
