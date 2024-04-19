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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'tag_id' => 'required|exists:tags,id',
            'book_id' => 'nullable|exists:books,id',
            'image' => 'nullable',
            'title' => 'required|min:1|max:20',
            'story' => 'required|min:200|max:400',
        ];
    }
}
