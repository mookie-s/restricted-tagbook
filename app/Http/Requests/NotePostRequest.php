<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->path() == 'note') {
            return true;
        } elseif ($this->path() == 'broken-note') {
            return true;
        } elseif ($this->path() == 'update-note') {
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
            // 'book_id' => 'nullable|exists:books,id',
            'image' => 'nullable',
            'title' => 'required|between:1,20',
            'story' => 'required|between:200,800',
        ];
    }

    public function messages()
    {
        return [
            'tag_id.required' => 'タグ は選択必須です。',
            'tag_id.exists' => '登録済みのタグの中から選択してください。',
            // 'book_id.exists' => '登録済みのブックの中から選択してください。',
            'title.required' => 'タイトル は入力必須です。',
            'title.between' => 'タイトル は 20 文字以内で入力してください。',
            'story.required' => '執筆内容 は入力必須です。',
            'story.between' => '執筆内容 は 200~800 文字の間で入力してください。'
        ];
    }
}
