<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'teacher_id' => $this->id,
            'area_of_expertise' => $this->expertise,
            'qualification' => $this->qualification,
            'years_of_experience' => $this->experience_years,
            'is_verified' => (bool) $this->verified,

            // Use UserResource (without token)
            'user_info' => $this->whenLoaded('user', function () {
                return (new UserResource($this->user))->withoutToken();
            }),

            // Include courses only when eager-loaded
            'assigned_courses' => $this->whenLoaded('courses', function () {
                return $this->courses;
            }),

            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
