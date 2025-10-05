<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'expertise' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'verified' => 'boolean',
        ];

        // For create (POST), require id (user_id)
        if ($this->isMethod('post')) {
            $rules['id'] = 'required|exists:users,id|unique:teachers,id';
        }

        // For update (PUT/PATCH), id is optional
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['id'] = 'sometimes|exists:users,id';
            $rules['expertise'] = 'sometimes|string|max:255';
            $rules['qualification'] = 'sometimes|string|max:255';
            $rules['experience_years'] = 'sometimes|integer|min:0';
        }

        return $rules;
    }
}
