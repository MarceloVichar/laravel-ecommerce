<?php

namespace Tests\Feature\Auth;

use App\Domains\Auth\Models\User;
use Tests\Cases\TestCaseFeature;

class LoginTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()
            ->admin()
            ->create(['password' => bcrypt('password')]);
    }

    public function test_login_should_success_when_right_credentials()
    {
        $this->post('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ])
            ->assertSuccessful();

    }

    public function test_login_should_fail_when_wrong_credentials()
    {
        $this->post('api/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ])
            ->assertStatus(422)
            ->assertJson(['message' => 'wrong password']);
    }

    public function test_login_should_fail_when_no_exist_email()
    {
        $this->post('api/login', [
            'email' => $this->user->email . '.br',
            'password' => 'password',
        ])
            ->assertStatus(404)
            ->assertJson(['message' => 'user not found']);
    }
}
