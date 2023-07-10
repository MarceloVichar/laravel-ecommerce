<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Data\RegisterData;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function execute(RegisterData $registerData): User
    {
        $registerData->password = Hash::make($registerData->password);
        $user = new User($registerData->toArray());
        $user->save();

        return $user;
    }
}
