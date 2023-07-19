<?php

namespace App\Actions\Users;

use App\Domains\Auth\Models\User;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Data\ProductData;

class UpdateUserAction
{
    public function execute(User $user, $data): User
    {
        $user->update($data);
        return $user;
    }
}
