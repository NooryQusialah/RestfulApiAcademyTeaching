<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'guard_name' => 'sometimes|string|max:255',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'guard_name' => $this->input('guard_name', 'api'),
        ]);
    }
}
