<?php

namespace Tests\Feature\Auth;

use App\Domains\Auth\Models\User;
use Tests\Cases\TestCaseFeature;

class RegisterTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()
            ->customer()
            ->create(['password' => bcrypt('password')]);

    }

    public function test_should_register_user()
    {
        $response = $this->post('/api/register', [
            'name' => 'novo nome',
            'email' => 'novoemail@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201);
    }

    public function test_register_should_fail_id_user_already_exists()
    {
        $response = $this->post('/api/register', [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertStatus(422);

        $response->assertJsonValidationErrors('email');

    }
}
