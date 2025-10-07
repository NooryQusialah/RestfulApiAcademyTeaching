<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Default role for user creation
        $this->merge([
            'role' => $this->input('role') ?? 'teacher', // 👈 default role = "student"
        ]);
    }

    public function rules(): array
    {

        // Define teacher-specific rules
        $teacherRules = [
            'expertise' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'verified' => 'boolean',
        ];

        if ($this->isMethod('post')) {
            $teacherRules['user_id'] = 'sometimes|exists:users,id|unique:teachers,id';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $teacherRules = [
                'user_id' => 'sometimes|exists:users,id',
                'expertise' => 'sometimes|string|max:255',
                'qualification' => 'sometimes|string|max:255',
                'experience_years' => 'sometimes|integer|min:0',
                'verified' => 'sometimes|boolean',
            ];
        }

        return $teacherRules;
    }

    public function messages(): array
    {
        return [
            'expertise.required' => 'Expertise is required.',
            'qualification.required' => 'Qualification is required.',
            'experience_years.required' => 'Experience years are required.',
            'experience_years.integer' => 'Experience years must be a number.',
            'user_id.exists' => 'The user does not exist.',
            'user_id.unique' => 'This user is already registered as a teacher.',
        ];

    }
}
