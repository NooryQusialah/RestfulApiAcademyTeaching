<?php

namespace App\Providers;

use App\Events\UserLogedIn;
use App\Interfaces\RoleInterface;
use App\Listeners\RevokedToken;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserCredentialInterface;
use App\Repositories\UserCredentialRepository;
use App\Interfaces\TeacherInterface;
use App\Repositories\TeacherRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
            $this->app->bind(UserCredentialInterface::class, UserCredentialRepository::class);
            $this->app->bind(TeacherInterface::class, TeacherRepository::class);
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
