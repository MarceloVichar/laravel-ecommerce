<?php

namespace Tests\Cases;

use App\Enums\UserRolesEnum;
use App\Domains\Auth\Models\User;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Event;
use Tests\CreatesApplication;

abstract class TestCaseFeature extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected ?User $currentUser = null;

    protected ?string $currentController = null;


    protected function beforeRefreshingDatabase()
    {
        Event::listen(MigrationsEnded::class, function () {
        });
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
    }

    protected function loginAsAdmin()
    {
        $this->currentUser = User::factory()
            ->admin()
            ->create();

        $this->actingAs($this->currentUser);

        return $this->currentUser;
    }

    protected function loginAsCustomer()
    {
        $this->currentUser = User::factory()
            ->customer()
            ->create();


        $this->actingAs($this->currentUser);

        return $this->currentUser;
    }

        protected function loginAsCompany()
    {
        $this->currentUser = User::factory()
            ->company()
            ->create();


        $this->actingAs($this->currentUser);

        return $this->currentUser;
    }

    protected function useActionsFromController(string $controllerClass)
    {
        $this->currentController = $controllerClass;

        return $this;
    }

    protected function controllerAction($action = null, $params = []): ?string
    {
        if (!$action) {
            return action($this->currentController, $params);
        }

        return action([$this->currentController, $action], $params);
    }
}
