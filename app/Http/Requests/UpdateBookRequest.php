<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'digits:13'],
            'published_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url'],
            'genres' => ['required', 'array'],
            'genres.*' => ['exists:genres,id'],
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages(): array
    {
        return [
            'title.required' => 'タイトルを入力してください。',
            'author.required' => '著者を入力してください。',
            'isbn.required' => 'ISBNを入力してください。',
            'isbn.digits' => 'ISBNは13桁で入力してください。',
            'published_date.required' => '出版日を入力してください。',
            'image_url.url' => '画像URLの形式が不正です。',
            'genres.required' => 'ジャンルを1つ以上選択してください。',
            'genres.*.exists' => '存在しないジャンルです。',
        ];
    }

}
