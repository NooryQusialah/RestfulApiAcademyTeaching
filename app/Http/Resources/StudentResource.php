<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'student_id' => $this->id,
            'enrollment_number' => $this->enrollment_number,
            'level' => $this->level,
            'major' => $this->major,
            'date_of_birth' => $this->date_of_birth ? $this->date_of_birth : null,
            'user_id' => $this->user_id,

            // Include related user info when eager-loaded
            'user_info' => $this->whenLoaded('user', function () {
                return (new UserResource($this->user))->withoutToken();
            }),

            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
