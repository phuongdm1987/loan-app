<?php
declare(strict_types=1);

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 *
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     */
    public function test_can_authenticate(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->post('/api/login', [
                'email' => $user->email,
                'password' => 'password',
            ]);

        $this->assertAuthenticated();

        $response
            ->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('statusCode')
                ->has('data.accessToken')
                ->where('data.tokenType', 'Bearer')
            );
    }

    /**
     *
     */
    public function test_can_not_authenticate_with_email_not_exists(): void
    {
        $response = $this
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->post('/api/login', [
                'email' => 'email@domain.com',
                'password' => 'password',
            ]);

        $this->assertGuest();

        $response
            ->assertStatus(422)
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('message')
                ->where('errors.email.0', 'These credentials do not match our records.')
            );
    }

    /**
     *
     */
    public function test_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->post('/api/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);

        $this->assertGuest();

        $response
            ->assertStatus(422)
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('message')
                ->where('errors.email.0', 'These credentials do not match our records.')
            );
    }
}
