<?php

use App\Http\Controllers\ApiController\CourseController;
use App\Http\Controllers\ApiController\LessonController;
use App\Http\Controllers\ApiController\QuestionController;
use App\Http\Controllers\ApiController\QuizzeController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

// Teacher routes
Route::controller(TeacherController::class)
    ->prefix('teachers')
    ->group(function () {

        Route::post('/', 'store');
        Route::middleware(['auth:api', 'role:teacher'])->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::put('/{userId}', 'update')->whereNumber('userId');
            Route::delete('/{id}', 'destroy')->whereNumber('id');
            Route::get('/{id}/courses', 'courses')->whereNumber('id');
        });
    });

// Course routes
Route::controller(CourseController::class)
    ->prefix('courses')
    ->middleware(['auth:api', 'role:teacher'])
    ->group(function () {
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->whereNumber('id');
    });

// Lesson routes
Route::controller(LessonController::class)
    ->prefix('lessons')
    ->middleware(['auth:api', 'role:teacher'])
    ->group(function () {
        Route::get('/course/{courseId}', 'index')->whereNumber('courseId');
        Route::get('/{id}', 'show')->whereNumber('id');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->whereNumber('id');
    });

// Quiz routes
Route::controller(QuizzeController::class)
    ->prefix('quizzes')
    ->middleware(['auth:api', 'role:teacher'])
    ->group(function () {
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->whereNumber('id');
    });

// Question routes
Route::controller(QuestionController::class)
    ->prefix('questions')
    ->middleware(['auth:api', 'role:teacher'])
    ->group(function () {
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->whereNumber('id');
    });
