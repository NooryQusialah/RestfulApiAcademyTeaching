<?php

namespace App\Providers;

use App\Events\UserLogedIn;
use App\Listeners\RevokedToken;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserCredentialInterface;
use App\Repositories\UserCredentialRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
            $this->app->bind(UserCredentialInterface::class, UserCredentialRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            UserLogedIn::class,
            RevokedToken::class,
        );
    }
}
