<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected bool $hideToken = false;

    public function toArray($request)
    {
        $data = [
            'user_id' => $this->id,
            'full_name' => $this->name,
            'email_address' => $this->email,
            'registered_at' => $this->created_at?->toDateTimeString(),
            'last_updated_at' => $this->updated_at?->toDateTimeString(),
        ];

        if (! $this->hideToken && isset($this->token)) {
            $data['access_token'] = $this->token;
        }

        return $data;
    }

    /**
     * Hide the token from the response.
     */
    public function withoutToken(): static
    {
        $this->hideToken = true;

        return $this;
    }
}
