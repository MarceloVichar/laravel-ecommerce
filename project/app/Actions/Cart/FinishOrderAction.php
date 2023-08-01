<?php

namespace App\Actions\Cart;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;

class FinishOrderAction
{
    public function execute(Order $cart): Order
    {

        $order_items = OrderItem::where('order_id', $cart->id)->get();

        foreach ($order_items as $orderItem) {
            if ($orderItem->quantity > $orderItem->product->available_quantity) {
                 throw new Exception('Quantity bigger than available', 500);
            }
        }

        $cart->update(['status' => OrderStatusEnum::FINISHED]);
        return $cart;
    }
}
