<?php

namespace App\Services;

use App\Interfaces\UserCredentialInterface;
use Illuminate\Support\Facades\Hash;

class UserCredentialService
{
    protected $userCredentialRepository;

    public function __construct(UserCredentialInterface $userCredentialRepository)
    {
        $this->userCredentialRepository = $userCredentialRepository;
    }

    public function register($userRequest)
    {
        // $data = $userRequest->all();
        $userRequest['password'] = Hash::make($userRequest['password']);

        return $this->userCredentialRepository->register($userRequest);
    }

    public function updateUser(array $data, $userId)
    {
        return $this->userCredentialRepository->updateUser($data, $userId);
    }

    public function login(array $credentials)
    {
        return $this->userCredentialRepository->login($credentials);
    }

    public function logout()
    {
        $this->userCredentialRepository->logout();
    }

    public function refreshToken()
    {
        return $this->userCredentialRepository->refreshToken();
    }
}
