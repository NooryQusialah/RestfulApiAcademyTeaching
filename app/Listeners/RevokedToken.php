<?php

namespace App\Listeners;

use App\Events\UserLogedIn;
use Illuminate\Support\Facades\Log;

class RevokedToken
{
    public function handle(UserLogedIn $event)
    {
        // Revoke all tokens for the user
        $event->user->tokens()->delete();

        // Log the token revocation
        Log::info('All tokens revoked for user: ' . $event->user->id);
    }
}
