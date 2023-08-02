<?php

namespace App\Actions\Cart;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Support\Facades\DB;

class FinishOrderAction
{
    public function execute(Order $cart): Order
    {
        try {
            DB::beginTransaction();
            $order_items = OrderItem::where('order_id', $cart->id)->get();

            foreach ($order_items as $orderItem) {
                if ($orderItem->quantity > $orderItem->product->available_quantity) {
                    throw new Exception('Quantity bigger than available', 500);
                }

                $newAvailableQuantity = $orderItem->product->available_quantity - $orderItem->quantity;
                $orderItem->product->update(['available_quantity' => $newAvailableQuantity]);
            }

            $cart->update(['status' => OrderStatusEnum::FINISHED]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }


        return $cart;
    }
}
