<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Data\RegisterData;
use App\Enums\UserRolesEnum;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function execute(RegisterData $registerData): User
    {
        $registerData->password = Hash::make($registerData->password);
        $registerData = $registerData->toArray();
        $registerData['role'] = UserRolesEnum::CUSTOMER;
        $user = new User($registerData);
        $user->save();

        return $user;
    }
}
