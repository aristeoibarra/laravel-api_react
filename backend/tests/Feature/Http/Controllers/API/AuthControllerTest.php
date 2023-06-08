<?php

namespace Tests\Feature\Http\Controllers\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulRegistration()
    {
        $response = $this->postJson('/api/auth/register', [
            'email' => 'john.doe@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
                'data' => [
                    'id',
                    'name',
                    'email'
                ],
            ]);
    }

    public function testFailedRegistration()
    {
        $response = $this->postJson('/api/auth/register', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                    'password',
                ],
            ]);
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'data' => null,
                'message' => 'Logged out successfully.'
            ]);
    }

    public function testProfile()
    {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->get('/api/auth/profile');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email'
                ],
            ]);
    }
}
