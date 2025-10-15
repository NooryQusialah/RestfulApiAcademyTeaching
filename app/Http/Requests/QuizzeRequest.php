<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizzeRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_marks' => 'nullable|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'course_id.required' => 'Course is required',
            'course_id.exists' => 'Course does not exist',
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must be less than 255 characters',
            'description.string' => 'Description must be a string',
            'total_marks.integer' => 'Total marks must be an integer',
            'total_marks.min' => 'Total marks must be at least 0',
        ];
    }
}
