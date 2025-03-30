<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnsubscribeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // 인증/권한 점검 필요 X, true 리턴
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'blog_id' => 'required|exists:blogs,id'
        ];
    }
}
