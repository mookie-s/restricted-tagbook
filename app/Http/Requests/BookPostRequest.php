<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->path() == 'store-book') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tag_id' => 'required|exists:tags,id',
            'cover' => 'required|between:1,10,',
        ];
    }

    public function messages()
    {
        return [
            'tag_id.required' => 'タグ は選択必須です。',
            'tag_id.exists' => '登録済みのタグの中から選択してください。',
            'cover.required' => 'ブック名 は入力必須です。',
            'cover.between' => 'ブック名 は 10 文字以内で入力してください。',
        ];
    }
}
