<?php

namespace App\Http\Controllers\Company;

use App\Actions\Companies\GetUserCompanyAction;
use App\Actions\Orders\CheckIfOrderIsFromCurrentCompanyAction;
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
        $company = (new GetUserCompanyAction())->execute();

        return PaginationBuilder::for(Order::class)
            ->criteria([
                new WhereCriteria('status', OrderStatusEnum::FINISHED),
                new WhereCriteria('company_id', $company->id),
            ])
            ->resource(OrderResource::class);
    }

    public function show(Order $order): JsonResponse
    {
        (new CheckIfOrderIsFromCurrentCompanyAction())->execute($order);
        $order->load('orderItems');
        $order->load('client');
        return response()->json(OrderResource::make($order), 200);
    }
}
