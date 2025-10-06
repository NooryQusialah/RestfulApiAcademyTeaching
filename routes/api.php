<?php



use App\Http\Controllers\ApiController\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserCredentialController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TeacherController;




Route::prefix('v1')->middleware('auth:api')->group(function () {

Route::get('/test-role', function () {
    return 'You have the admin role!';
})->middleware(['auth:api', 'check.admin']);
Route::controller(UserCredentialController::class)
      ->group(function () {
        Route::post('/register', 'register')->withoutMiddleware('auth:api');
        Route::post('/login', 'login')->withoutMiddleware('auth:api');
        Route::post('/logout','logout')->middleware('auth:api');
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
        Route::put('/{id}', 'update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->whereNumber('id');
        Route::get('/{id}/courses', 'courses')->whereNumber('id');
});


Route::controller(CourseController::class)->prefix('courses')
       ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show')->whereNumber('id');
        Route::post('/', 'store');
        Route::put('/{id}', 'update')->whereNumber('id');
        Route::delete('/{id}', 'destroy')->whereNumber('id');
});

});
