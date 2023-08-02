<?php

namespace App\Actions\Orders;

use App\Models\Order;
use Exception;

class CheckIfOrderIsFromCurrentCustomerAction
{
    /**
     * @throws Exception
     */
    public function execute(Order $order): Order
    {
        $userId = current_user()->id;
        if ($userId !== $order->client_id) {
            throw new Exception('Order is not from current user', '404');
        }
        return $order;
    }
}
