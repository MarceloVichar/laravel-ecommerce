<?php

namespace App\Http\Controllers\Customer;

use App\Actions\Orders\CheckIfOrderIsFromCurrentCustomerAction;
use App\Criterias\Common\WhereCriteria;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Support\PaginationBuilder;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function index(): PaginationBuilder
    {
        return PaginationBuilder::for(Order::class)
            ->criteria([
                new WhereCriteria('status', OrderStatusEnum::FINISHED),
                new WhereCriteria('client_id', current_user()->id),
            ])
            ->resource(OrderResource::class);
    }

    public function show(Order $order): JsonResponse
    {
        (new CheckIfOrderIsFromCurrentCustomerAction())->execute($order);
        $order->load('orderItems');
        $order->load('company');
        return response()->json(OrderResource::make($order), 200);
    }
}
