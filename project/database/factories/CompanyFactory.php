<?php

namespace Database\Factories;

use App\Domains\Auth\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'id' => fake()->unique()
                ->randomNumber(4),
            'name' => fake()->name(),
            'cnpj' => fake()->name(),
            'trading_name' => fake()->name(),
            'phone' => fake()->name(),
            'owner_id' => User::factory()
        ];
    }
}
