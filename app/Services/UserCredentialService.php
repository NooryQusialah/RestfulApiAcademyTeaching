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

    public function register($userRequest )
    {
        $data = $userRequest->all();
        $data['password'] = Hash::make($data['password']);
        return $this->userCredentialRepository->register($data);
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
