<?php

use App\Http\Controllers\ApiController\LessonController;
use App\Http\Controllers\ApiController\TagController;
use App\Http\Controllers\ApiController\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
   Route::apiResource('users', UserController::class);
   Route::controller(UserController::class)->group(function () {
       Route::get('/user/{id}/lessons', 'userLessons')->name('user.lessons');;
   });


   Route::apiResource('lessons', LessonController::class);
    Route::controller(LessonController::class)->group(function () {
        Route::get('/lessons/{id}/tags', 'LessonTags')->name('lessons.tags');

    });

    Route::apiResource('tags', TagController::class);
    Route::controller(TagController::class)->group(function () {
        Route::get('/tags/{id}/lessons', 'TagLessons')->name('tags.lessons');
    });
});
