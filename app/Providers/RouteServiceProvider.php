<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // Admin API routes
            Route::middleware(['api', 'auth:api', 'role:admin'])
                ->prefix('api/v1')
                ->group(base_path('routes/admin.php'));

            Route::prefix('api/v1')
                ->group(base_path('routes/teacher.php'));

            Route::prefix('api/v1')
                ->group(base_path('routes/student.php'));

        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Optional: define rate limiting for your API routes
        // e.g., using the default 'api' limiter
        // RateLimiter::for('api', function (Request $request) {
        //     return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        // });
    }
}
