<?php

use App\Http\Controllers\UserCredentialController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:api')->group(function () {

    Route::get('/test-role', function () {
        return 'You have the admin role!';
    })->middleware(['auth:api', 'role:admin']);

    Route::controller(UserCredentialController::class)
        ->group(function () {
            Route::post('/register', 'register')->withoutMiddleware('auth:api');
            Route::post('/login', 'login')->withoutMiddleware('auth:api');
            Route::put('/users/{userId}', 'update')->withoutMiddleware('auth:api')->whereNumber('userId')->name('users.update');
            Route::post('/logout', 'logout')->middleware('auth:api');
            Route::post('/tokens/refresh', 'refreshToken')->middleware('auth:api');
        });

    Route::controller(App\Http\Controllers\ApiController\CommentController::class)
        ->prefix('lessons/{lessonId}/comments')
        ->whereNumber('lessonId')
        ->group(function () {
            Route::get('/', 'index')->withoutMiddleware('auth:api');
            Route::post('/', 'store')->middleware('auth:api');
            Route::get('/{id}', 'show')->withoutMiddleware('auth:api')->whereNumber('id');
            Route::put('/{id}', 'update')->middleware('auth:api')->whereNumber('id');
            Route::delete('/{id}', 'destroy')->middleware('auth:api')->whereNumber('id');

        });
});
