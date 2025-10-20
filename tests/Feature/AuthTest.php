<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret123',
            'role' => 'user',
        ];

        $response = $this->postJson('/api/v1/register', $userData);
        $response->assertStatus(200)->assertJsonStructure(['data' => ['user_id', 'full_name', 'email_address', 'access_token']]);

        // login
        $login = $this->postJson('/api/v1/login', ['email' => 'test@example.com', 'password' => 'secret123']);
        $login->assertStatus(200)->assertJsonStructure(['user' => ['user_id', 'full_name', 'email_address', 'access_token']]);
    }
}
