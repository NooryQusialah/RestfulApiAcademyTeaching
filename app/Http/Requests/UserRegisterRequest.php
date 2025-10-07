<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'role' => $this->input('role') ?? 'user', // default role
        ]);
    }

    public function rules(): array
    {
        // Check if this is an update request (usually via PUT/PATCH)
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);
        $userId = $this->route('userId') ?? null; // assuming route model binding or /users/{user}

        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'email',
                $isUpdate
                    ? Rule::unique('users', 'email')->ignore($userId)
                    : Rule::unique('users', 'email'),
            ],
            'password' => [
                $isUpdate ? 'nullable' : 'required',
                'min:6',
            ],
            'role' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
        ];
    }
}
