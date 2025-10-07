<?php

namespace App\Repositories;

use App\Interfaces\UserCredentialInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserCredentialRepository implements UserCredentialInterface
{
    public function register($data)
    {
        $user = User::create($data);
        $user->assignRole($data['role']);
        $user->tokens()->delete();
        $token = $user->createToken('authToken')->accessToken;

        // Attach token to model for returning if needed
        $user->token = $token;

        return $user;
    }

    public function login(array $credentials)
    {
        if (! Auth::guard('web')->attempt($credentials)) {
            throw new \Exception('Invalid credentials');
        }

        $user = Auth::guard('web')->user();

        // Delete old tokens
        $user->tokens()->delete();

        // Create new token
        $token = $user->createToken('authToken')->accessToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function updateUser(array $data, $userId)
    {
        $userId = User::findOrFail($userId);
        $data['password'] = Hash::make($data['password']);
        $userId->update($data);

        return $userId;

    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
    }

    public function refreshToken()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        $token = $user->createToken('authToken')->accessToken;

        return ['user' => $user, 'token' => $token];
    }
}
