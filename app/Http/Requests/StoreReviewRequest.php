<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * バリデーション
     */
    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ];
    }

    /**
     * 項目名
     */
    public function attributes(): array
    {
        return [
            'rating' => '評価',
            'comment' => 'コメント',
        ];
    }

    /**
     * メッセージ
     */
    public function messages(): array
    {
        return [
            'rating.required' => '評価を選択してください。',
            'rating.between' => '評価は1〜5の間で選択してください。',
            'comment.required' => 'コメントを入力してください。',
            'comment.max' => 'コメントは1000文字以内で入力してください。',
        ];
    }
}
