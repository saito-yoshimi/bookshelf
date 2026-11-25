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
            'target_date' => '読了予定日',
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages(): array
    {
        return [
            
            'target_date.required' => '読了予定日を入力してください。',
            'target_date.date' => '読了予定日は正しい日付で入力してください。',
        ];
    }
}