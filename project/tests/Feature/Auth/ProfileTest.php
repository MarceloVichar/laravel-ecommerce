<?php

namespace Tests\Feature\Auth;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\Auth\ProfileController;
use Tests\Cases\TestCaseFeature;

class ProfileTest extends TestCaseFeature
{
    public function setUp(): void
    {
        parent::setUp();
        $this->loginAsCustomer();
        $this->useActionsFromController(ProfileController::class);

    }

    private function getCampaignResourceStructure(): array
    {
        return [
            'id', 'name', 'email', 'role',
        ];
    }

    public function test_should_show_profile()
    {
        $this->getJson($this->controllerAction('show'))
            ->assertSuccessful()
            ->assertStatus(200)
            ->assertJsonStructure($this->getCampaignResourceStructure());
    }

    public function test_should_update_profile()
    {
        $data = [
            'email' => 'joaozinho@email.com',
            'name' => 'joaozinho',
        ];

        $response = $this->putJson($this->controllerAction('update'), $data);

        $response->assertStatus(200);
        $response->assertJsonStructure($this->getCampaignResourceStructure());

    }

    public function test_should_update_profile_when_no_update_email()
    {
        $data = [
            'email' => $this->currentUser->email,
            'name' => 'joaozinho',
        ];

        $response = $this->putJson($this->controllerAction('update'), $data);

        $response->assertOk();
        $response->assertJsonStructure($this->getCampaignResourceStructure());

    }

    public function test_should_not_change_the_profile_if_it_was_from_an_existing_email()
    {
        $otherUser = User::factory()
            ->admin()
            ->create();

        $data = [
            'email' => $otherUser->email,
            'name' => 'joaozinho',
        ];

        $response = $this->putJson($this->controllerAction('update'), $data);

        $response->assertStatus(422);

    }
}
