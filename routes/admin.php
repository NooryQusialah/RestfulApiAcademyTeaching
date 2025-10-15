<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserCredentialController;
use Illuminate\Support\Facades\Route;

// User management routes
Route::controller(UserCredentialController::class)
    ->group(function () {
        Route::post('/register', 'register')->withoutMiddleware('auth:api');
        Route::post('/login', 'login')->withoutMiddleware('auth:api');
        Route::post('/logout', 'logout');
        Route::post('/tokens/refresh', 'refreshToken');
        Route::put('/users/{userId}', 'update')->whereNumber('userId');
    });

// Role management routes
Route::controller(RoleController::class)
    ->prefix('roles')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->whereNumber('id');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->whereNumber('id');

        Route::post('/{roleId}/permission/assign', 'assignPermission')->whereNumber('roleId');
        Route::delete('/{roleId}/permission/remove', 'removePermission')->whereNumber('roleId');

        Route::post('/user/assign/role', 'assignRoleToUser');
        Route::put('/user/update/role', 'updateRoleOfUser');
        Route::delete('/user/{userId}/remove/role', 'removeRoleFromUser')->whereNumber('userId');
    });

Route::controller(PermissionController::class)
    ->prefix('permissions')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->whereNumber('id');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->whereNumber('id');

        Route::post('/{permissionId}/role/assign', 'assignRole')->whereNumber('permissionId');
        Route::delete('/{permissionId}/role/remove', 'removeRole')->whereNumber('permissionId');
    });
