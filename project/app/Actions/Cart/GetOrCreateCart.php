<?php

namespace App\Actions\Cart;

use App\Domains\Product\Models\Product;
use App\Enums\OrderStatusEnum;
use App\Models\Order;

class GetOrCreateCart
{
    public function execute(Product $product): Order
    {
        $activeOrder = Order::where('status', OrderStatusEnum::OPENED)
            ->where('client_id', current_user()->id)
            ->first();
        if ($activeOrder) {
            return $activeOrder;
        } else {
            $newOrder = new Order([
                'client_id' => current_user()->id,
                'company_id' => $product->company_id,
                'status' => OrderStatusEnum::OPENED
            ]);

            $newOrder->save();

            return $newOrder;
        }
    }
}
