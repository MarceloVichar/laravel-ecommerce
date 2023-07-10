<?php

namespace App\Domains\Auth\Adapters;

use App\Domains\Auth\Data\RegisterData;

class RegisterAdapter
{
    public function handle(array $data): RegisterData
    {
        return new RegisterData(
            data_get($data, 'name'),
            data_get($data, 'email'),
            data_get($data, 'password')
        );
    }
}
