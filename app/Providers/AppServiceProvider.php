<?php

namespace App\Providers;

use App\Events\UserLogedIn;
use App\Interfaces\CourseInterface;
use App\Interfaces\LessonInterface;
use App\Interfaces\TeacherInterface;
use App\Interfaces\UserCredentialInterface;
use App\Listeners\RevokedToken;
use App\Repositories\CourseRepository;
use App\Repositories\LessonRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\UserCredentialRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserCredentialInterface::class, UserCredentialRepository::class);
        $this->app->bind(TeacherInterface::class, TeacherRepository::class);
        $this->app->bind(CourseInterface::class, CourseRepository::class);
        $this->app->bind(LessonInterface::class, LessonRepository::class);

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
