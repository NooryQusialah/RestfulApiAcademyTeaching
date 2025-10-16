<?php

use App\Http\Controllers\ApiController\CourseController;
use App\Http\Controllers\ApiController\QuestionController;
use App\Http\Controllers\ApiController\QuizzeController;
use App\Http\Controllers\ApiController\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::controller(StudentController::class)
    ->prefix('students')
    ->group(function () {
        Route::post('/', 'store');
        Route::middleware(['auth:api', 'role:student'])->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'destroy')->whereNumber('id');

            Route::get('/{id}/enrollments', 'enrollments')->whereNumber('id');
            Route::get('/{id}/payments', 'payments')->whereNumber('id');
            Route::get('/{id}/quiz-attempts', 'quizAttempts')->whereNumber('id');

            Route::get('/courses', 'courses');
            Route::get('/courses/{courseId}', 'studentCourse')->whereNumber('courseId');
            Route::post('/courses', 'assignCourse');
            Route::delete('/courses/{courseId}', 'unassignCourse')->whereNumber('courseId');
        });
    });

// Course routes
Route::controller(CourseController::class)
    ->prefix('courses')
    ->middleware(['auth:api', 'role:student|teacher'])
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->whereNumber('id');
    });

// Quiz routes
Route::controller(QuizzeController::class)
    ->prefix('quizzes')
    ->middleware(['auth:api', 'role:student|teacher'])
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->whereNumber('id');
    });

// Question routes
Route::controller(QuestionController::class)
    ->prefix('questions')
    ->middleware(['auth:api', 'role:student|teacher'])
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->whereNumber('id');
    });
