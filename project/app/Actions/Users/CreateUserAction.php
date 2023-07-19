<?php

namespace App\Actions\Users;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Data\RegisterData;
use App\Enums\UserRolesEnum;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute($data, $role): User
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = $role;
        $user = new User($data);
        $user->save();

        return $user;
    }
}
