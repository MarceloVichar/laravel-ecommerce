<?php

namespace App\Actions\Cart;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DeleteOrderAction
{
    public function execute(Order $order)
    {
        try {
            DB::beginTransaction();

            $order->orderItems()->delete();

            $order->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception('Failed to delete cart and your items', 500);
        }
    }
}
