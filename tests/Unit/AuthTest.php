<?php

use App\User\Models\User;
use App\User\Repositories\UserRepository;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{

    public function testLogin()
    {
        $email = (new UserRepository())
            ->findById(1)
            ->entity()
            ->getEmail();

        $response = $this->post('/api/auth/login', [
            'email'     => $email,
            'password'  => 'pass'
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', json_decode($response->getContent(), true));
    }

    public function testLogout()
    {
        $token = JWTAuth::fromUser(User::find(1)->first());

        $response = $this->post('/api/auth/logout', [], [
            'Authorization' => "Bearer ".$token
        ]);

        $response->assertStatus(200);
        $this->assertJsonStringEqualsJsonString('{"message":"Successfully logged out"}', $response->getContent());
    }
}
