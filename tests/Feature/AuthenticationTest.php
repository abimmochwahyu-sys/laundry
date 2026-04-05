<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_register()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'alamat' => 'Jl. Test No. 123',
            'telepon' => '081234567890',
        ];

        $response = $this->post('/register', $userData);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User'
        ]);
        $this->assertDatabaseHas('pelanggans', [
            'telepon' => '081234567890',
            'alamat' => 'Jl. Test No. 123'
        ]);
    }

    #[Test]
    public function user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'pelanggan'
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/pelanggan/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function user_cannot_login_with_wrong_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    #[Test]
    public function authenticated_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    }
}