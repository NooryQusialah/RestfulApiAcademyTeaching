<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        // You can add authorization logic here if needed (e.g., only teacher can add)
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|integer|min:1',
            'order' => 'required|integer|min:1',
            'course_id' => 'required|exists:courses,id',
        ];

        // For update requests, make fields optional
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['title'] = 'sometimes|string|max:255';
            $rules['content'] = 'sometimes|string';
            $rules['order'] = 'sometimes|integer|min:1';
            $rules['course_id'] = 'sometimes|exists:courses,id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Lesson title is required.',
            'content.required' => 'Lesson content is required.',
            'order.required' => 'Lesson order is required.',
            'course_id.exists' => 'Invalid course ID.',
        ];
    }
}
