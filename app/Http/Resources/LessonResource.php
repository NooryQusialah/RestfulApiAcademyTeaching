<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Lesson ID'=>$this->id,
            'Lesson Title'=>$this->title,
            'Lesson Body'=>$this->body,
            'Created At'=>$this->created_at,
            'Updated At'=>$this->updated_at,
        ];
    }
}
