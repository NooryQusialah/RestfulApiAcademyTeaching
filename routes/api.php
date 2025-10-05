<?php



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserCredentialController;

Route::prefix('v1')->group(function () {
    Route::post('/register', [UserCredentialController::class, 'register']);
    Route::post('/login', [UserCredentialController::class, 'login']);
    Route::post('/logout', [UserCredentialController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/refresh-token', [UserCredentialController::class, 'refreshToken'])->middleware('auth:sanctum');
});
