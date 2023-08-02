<?php

namespace App\Actions\CartItems;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DeleteCartItemAction
{
    public function execute(Order $cart, OrderItem $item)
    {
        try {
            DB::beginTransaction();

            $item->delete();

            $itemsCountAfterDelete = $cart->orderItems()->count();

            if ($itemsCountAfterDelete === 0) {
                $cart->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('Failed to delete cart and your items', 500);
        }
    }
}
