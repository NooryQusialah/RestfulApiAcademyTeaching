<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Tag ID'=>$this->id,
            'Tag Name'=>$this->name,
            'Created At'=>$this->created_at,
            'Updated At'=>$this->updated_at,
        ];
    }
}
