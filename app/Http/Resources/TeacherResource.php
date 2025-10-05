<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'expertise' => $this->expertise,
            'qualification' => $this->qualification,
            'experience_years' => $this->experience_years,
            'verified' => $this->verified,
            'user' => $this->when($this->relationLoaded('user'), function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ];
            }),
            'courses' => $this->when($this->relationLoaded('courses'), function () {
                return $this->courses;
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
