<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->path() == 'store-tag') {
            return true;
        } elseif ($this->path() == 'update') {
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
            'tagname' => 'required|between:1,10,',
            'abbreviation' => 'required|between:1,4,',
        ];
    }

    public function messages()
    {
        return [
            'tagname.required' => 'タグ名 は入力必須です。',
            'tagname.between' => 'タグ名 は 10 文字以内で入力してください。',
            'abbreviation.required' => 'タグ略称 は入力必須です。',
            'abbreviation.between' => 'タグ略称 は 4 文字以内で入力してください。',
        ];
    }
}
