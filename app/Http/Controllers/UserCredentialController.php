<?php

namespace App\Http\Controllers;

use App\Services\UserCredentialService;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Helpers\ResponseHelper;

class UserCredentialController extends Controller
{
    protected $userCredentialService;

    public function __construct(UserCredentialService $userCredentialService)
    {
        $this->userCredentialService = $userCredentialService;
    }

    public function register(UserRegisterRequest $request)
    {
        try {

            $user = $this->userCredentialService->register($request);

            if (!$user) {

                return ResponseHelper::error('Registration failed', 500);
            }
            return ResponseHelper::success(new UserResource($user), 'User registered successfully');
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Registration failed: ' . $e->getMessage()
            ], 500);
            //  return ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function login(UserLoginRequest $request)
    {
        try {
                $result = $this->userCredentialService->login($request->validated());
                $user = $result['user'];
                $user->token = $result['token'];

                return response()->json([
                    'token' => $result['token'],
                ], 200);

            } catch (\Exception $e) {
                return ResponseHelper::error($e->getMessage(), 401);
            }
    }

    public function logout()
    {
        try {
            $this->userCredentialService->logout();
            return ResponseHelper::success(' ', 'Logout successful');
        } catch (\Exception $e) {
                return ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function refreshToken()
    {
        try {
            $result = $this->userCredentialService->refreshToken();
            return ResponseHelper::success([
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ], 'Token refreshed successfully');
        } catch (\Exception $e) {
                return ResponseHelper::error($e->getMessage(), 500);
        }
    }
}
