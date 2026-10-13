<?php

namespace Tests\Feature\API\auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    //Test user dapat login
    public function test_user_dapat_login(): void
    {
        // Arrange
        $user =User::factory()->create();


        // Act
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Assert
        $response->assertStatus(200);
        // $response->assertOk();
        $response->assertJsonStructure([
            'token',
            'user' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    //Test user tidak dapat login dengan kredensial salah
    public function test_user_tidak_dapat_login_dengan_kredensial_salah(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        // Assert
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Invalid credentials',
        ]);
    }

    //Test user dapat register
    public function test_user_dapat_register(): void{
        // Arrange
        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
        ];
        // Act
        $response = $this->postJson('/api/auth/register', $userData);
        // Assert
        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);
    }

    //Test user dapat logout
    public function test_user_dapat_logout(): void{
        // Arrange
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;
        // Act
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/auth/logout');
        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Logged out successfully',
        ]);
    }
}
