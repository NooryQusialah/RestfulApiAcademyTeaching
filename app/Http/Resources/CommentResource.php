<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'user_id' => $this->user_id,
            // 'lesson_id' => $this->lesson_id,
            'content' => $this->content,
            'user' => new UserResource($this->whenLoaded('user')),
            'lesson' => new LessonResource($this->whenLoaded('lesson')),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
