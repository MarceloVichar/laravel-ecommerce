<?php

namespace App\Domains\Auth\Adapters;

use App\Domains\Auth\Data\LoginData;

class LoginAdapter
{
    public function handle(array $data): LoginData
    {
        return new LoginData(
            data_get($data, 'email'),
            data_get($data, 'password')
        );
    }
}
