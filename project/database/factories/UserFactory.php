<?php

namespace Database\Factories;

use App\Domains\Auth\Models\User;
use App\Enums\UserRolesEnum;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->randomNumber(4),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }

    public function customer()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => UserRolesEnum::CUSTOMER,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => UserRolesEnum::ADMIN,
            ];
        });
    }

    public function company()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => UserRolesEnum::COMPANY_ADMIN,
                'company_id' => Company::factory()
            ];
        });
    }
}
