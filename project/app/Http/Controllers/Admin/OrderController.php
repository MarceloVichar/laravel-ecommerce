<?php

namespace App\Http\Controllers\Admin;

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
                new WhereCriteria('status', OrderStatusEnum::FINISHED)
            ])
            ->resource(OrderResource::class);
    }


    public function show(Order $order): JsonResponse
    {
        $order->load('orderItems');
        $order->load('client');
        $order->load('company');
        return response()->json(OrderResource::make($order), 200);
    }
}
