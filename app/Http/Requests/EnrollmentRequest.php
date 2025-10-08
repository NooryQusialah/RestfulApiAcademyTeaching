<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
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
            'student_id' => 'sometimes|exists:students,id',
            'course_id' => 'sometimes|exists:courses,id',
            'enrolled_at' => 'required|date',
            'progress' => 'nullable|decimal:min:0|max:5',
            'completed' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.exists' => 'The selected student does not exist.',
            'course_id.exists' => 'The selected course does not exist.',
            'enrolled_at.required' => 'Enrollment date is required.',
            'enrolled_at.date' => 'Enrollment date must be a valid date.',
            'progress.decimal' => 'Progress must be a decimal number between 0 and 5.',
            'completed.boolean' => 'Completed must be true or false.',
        ];
    }
}
