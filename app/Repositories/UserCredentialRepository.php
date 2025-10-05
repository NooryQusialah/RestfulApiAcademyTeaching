<?php

namespace App\Repositories;

use App\Interfaces\UserCredentialInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserCredentialRepository implements UserCredentialInterface
{
public function register($data)
{
    $user = User::create($data);
    $user->assignRole('admin');

    $user->tokens()->delete();
    $token = $user->createToken('authToken')->accessToken;

    // Attach token to model for returning if needed
    $user->token = $token;

    return $user;
}


    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            throw new \Exception('Invalid credentials');
        }

        $user = Auth::user();
        // Delete existing tokens
        $user->tokens()->delete();

        $token = $user->createToken('authToken')->accessToken;

        return ['user' => $user, 'token' => $token];

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
