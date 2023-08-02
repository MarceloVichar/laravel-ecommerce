<?php

namespace App\Actions\Orders;

use App\Actions\Companies\GetUserCompanyAction;
use App\Models\Order;
use Exception;

class CheckIfOrderIsFromCurrentCompanyAction
{
    /**
     * @throws Exception
     */
    public function execute(Order $order): Order
    {
        $company = (new GetUserCompanyAction())->execute();
        if ($company->id !== $order->company_id) {
            throw new Exception('Order is not from current company', '404');
        }
        return $order;
    }
}
