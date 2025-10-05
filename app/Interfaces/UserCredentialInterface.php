<?php

namespace App\Interfaces;

interface UserCredentialInterface
{
    public function register(array $data);
    public function login(array $credentials);
    public function logout();
    public function refreshToken();
}
