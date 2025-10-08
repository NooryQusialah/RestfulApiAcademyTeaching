<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Default role for user creation
        $this->merge([
            'role' => $this->input('role') ?? 'student', // 👈 default role = "student"
        ]);
    }

    public function rules(): array
    {
        $studentId = $this->route('userId'); // or 'student' if your route param is named that

        $rules = [
            'enrollment_number' => 'required|string|max:255|unique:students,enrollment_number',
            'level' => 'required|string|max:255',
            'major' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ];

        if ($this->isMethod('post')) {
            $rules['user_id'] = 'sometimes|exists:users,id|unique:students,user_id';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules = [
                'user_id' => 'sometimes|exists:users,id',
                'enrollment_number' => 'sometimes|string|max:255|unique:students,enrollment_number,'.$studentId.',user_id',
                'level' => 'sometimes|string|max:255',
                'major' => 'sometimes|string|max:255',
                'date_of_birth' => 'sometimes|date',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'enrollment_number.required' => 'Enrollment number is required.',
            'enrollment_number.unique' => 'This enrollment number already exists.',
            'level.required' => 'Level is required.',
            'user_id.exists' => 'The selected user does not exist.',
            'user_id.unique' => 'This user is already registered as a student.',
        ];
    }
}
