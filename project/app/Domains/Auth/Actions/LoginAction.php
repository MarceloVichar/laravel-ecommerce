<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Data\LoginData;
use App\Domains\Auth\Models\User;

class LoginAction
{
    public function execute(LoginData $loginData)
    {
        return User::query()->where('email', $loginData->email)->first();
    }
}
