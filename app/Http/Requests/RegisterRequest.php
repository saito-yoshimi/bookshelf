<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'お名前を入力してください。',

            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスの形式で入力してください。',
            'email.unique' => 'このメールアドレスは既に登録されています。',

            'password.required' => 'パスワードを入力してください。',
            'password.confirmed' => 'パスワードと一致しません。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
        ];
    }
}