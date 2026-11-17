<?php

namespace App\Http\Requests;

use App\Enums\ReadingPlanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateReadingPlanRequest extends FormRequest
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

            'status' => [
                'required',
                new Enum(ReadingPlanStatus::class),
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
            'status' => '状態',
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

            'status.required' => '状態を選択してください。',
        ];
    }
}