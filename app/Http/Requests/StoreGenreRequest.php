<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenreRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:50',
                'unique:genres,name',
            ],
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages(): array
    {
        return [
            'name.required' => 'ジャンル名を入力してください。',
            'name.max' => 'ジャンル名は50文字以内で入力してください。',
            'name.unique' => 'そのジャンル名は既に登録されています。',
        ];
    }
}