<?php

namespace App\Listeners;

use App\Events\UserLogedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RevokedToken
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLogedIn $event): void
    {
        $event->user->tokens()->delete();
    }
}
