<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReadingPlanRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'book_id' => [
                'required',
                'exists:books,id',
            ],

            'target_date' => [
                'required',
                'date',
            ],
        ];
    }

    /**
     * 項目名
     */
    public function attributes(): array
    {
        return [
            'book_id' => '書籍',
            'target_date' => '読了予定日',
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages(): array
    {
        return [
            'book_id.required' => '書籍を選択してください。',
            'book_id.exists' => '選択した書籍が存在しません。',

            'target_date.required' => '読了予定日を入力してください。',
            'target_date.date' => '読了予定日は正しい日付で入力してください。',
        ];
    }
}