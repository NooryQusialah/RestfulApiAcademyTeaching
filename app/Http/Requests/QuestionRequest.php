<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_option' => 'required|in:A,B,C,D',
        ];
    }

    public function messages(): array
    {
        return [
            'quiz_id.required' => 'The quiz ID is required.',
            'quiz_id.exists' => 'The selected quiz ID is invalid.',
            'question_text.required' => 'The question text is required.',
            'option_a.required' => 'Option A is required.',
            'option_b.required' => 'Option B is required.',
            'option_c.required' => 'Option C is required.',
            'option_d.required' => 'Option D is required.',
            'correct_option.required' => 'The correct option is required.',
            'correct_option.in' => 'The correct option must be one of the following: A, B, C, D.',
        ];
    }
    
}
