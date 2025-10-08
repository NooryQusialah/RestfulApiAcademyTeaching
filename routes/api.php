<?php

use App\Http\Controllers\ApiController\CommentController;
use App\Http\Controllers\ApiController\CourseController;
use App\Http\Controllers\ApiController\LessonController;
use App\Http\Controllers\ApiController\QuestionController;
use App\Http\Controllers\ApiController\StudentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserCredentialController;
use App\Http\Controllers\ApiController\QuizzeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:api')->group(function () {

    Route::get('/test-role', function () {
        return 'You have the admin role!';
    })->middleware(['auth:api', 'check.admin']);
    Route::controller(UserCredentialController::class)
        ->group(function () {
            Route::post('/register', 'register')->withoutMiddleware('auth:api');
            Route::post('/login', 'login')->withoutMiddleware('auth:api');
            Route::put('/users/{userId}', 'update')->withoutMiddleware('auth:api')->whereNumber('userId')->name('users.update');
            Route::post('/logout', 'logout')->middleware('auth:api');
            Route::post('/tokens/refresh', 'refreshToken')->middleware('auth:api');
        });

    Route::controller(RoleController::class)->prefix('roles')
        ->middleware(['check.admin'])
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::post('/', 'store');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'destroy')->whereNumber('id');
            Route::post('/{roleId}/permission/assign', 'assignPermission')->whereNumber('roleId');
            Route::delete('/{roleId}/permission/remove', 'removePermission')->whereNumber('roleId');
        });

    Route::controller(PermissionController::class)
        ->prefix('permissions')->middleware(['check.admin'])
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::post('/', 'store');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'destroy')->whereNumber('id');
            Route::post('/{permissionId}/role/assign', 'assignRole')->whereNumber('permissionId');
            Route::delete('/{permissionId}/role/remove', 'removeRole')->whereNumber('permissionId');
        });

    Route::controller(TeacherController::class)->prefix('teachers')
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::post('/', 'store');
            Route::put('/{userId}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'destroy')->whereNumber('id');
            Route::get('/{id}/courses', 'courses')->whereNumber('id');
        });

    Route::controller(StudentController::class)->prefix('students')
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::post('/', 'store');
            Route::put('/{userId}', 'update')->whereNumber('userId');
            Route::delete('/{id}', 'destroy')->whereNumber('id');

            Route::get('/courses', 'courses')->whereNumber('id');
            Route::get('/courses/{courseId}', 'studentCourse')->whereNumber('courseId');
            Route::post('/courses', 'assignCourse');
            Route::delete('/courses/{courseId}', 'unassignCourse')->whereNumber('courseId');
            Route::get('/{id}/enrollments', 'enrollments')->whereNumber('id');
            Route::get('/{id}/payments', 'payments')->whereNumber('id');
            Route::get('/{id}/quiz-attempts', 'quizAttempts')->whereNumber('id');

        });

    Route::controller(CourseController::class)->prefix('courses')
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::post('/', 'store');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'destroy')->whereNumber('id');
        });

    Route::controller(LessonController::class)->prefix('lessons')
        ->group(function () {
            Route::get('/course/{courseId}', 'index')->whereNumber('courseId');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::post('/', 'store');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'destroy')->whereNumber('id');
        });


    Route::controller(QuizzeController::class)->prefix('quizzes')
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::post('/', 'store');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'destroy')->whereNumber('id');
      });

    Route::controller(QuestionController::class)->prefix('questions')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->whereNumber('id');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->whereNumber('id');
    });

    Route::controller(CommentController::class)->prefix('lessons/{lessonId}/comments')
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show')->whereNumber('id');
            Route::post('/', 'store');
            Route::put('/{id}', 'update')->whereNumber('id');
            Route::delete('/{id}', 'destroy')->whereNumber('id');
        });


});
