<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'lesson_id' => 'nullable|exists:lessons,id',
            'content' => 'required|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Content is required.',
            'content.string' => 'Content must be a string.',
            'content.max' => 'Content may not be greater than 2000 characters.',
        ];
    }
}
