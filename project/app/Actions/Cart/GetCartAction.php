<?php

namespace App\Actions\Cart;

use App\Domains\Product\Models\Product;
use App\Enums\OrderStatusEnum;
use App\Models\Order;

class GetCartAction
{
    public function execute(): Order
    {
        $cart = Order::where('status', OrderStatusEnum::OPENED)
            ->where('client_id', current_user()->id)
            ->first();

        if (!$cart) {
            throw new \Exception('Without opened orders', '404');
        }

        return $cart;
    }
}
