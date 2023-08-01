<?php

namespace App\Http\Controllers;

use App\Actions\Cart\DeleteOrderAction;
use App\Actions\Cart\FinishOrderAction;
use App\Actions\Cart\GetCartAction;
use App\Http\Resources\OrderResource;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{

    public function show(): JsonResponse
    {
        $cart = (new GetCartAction())->execute();
        $cart->load('orderItems');
        $cart->load('company');
        $cart->load('client');
        return response()->json(OrderResource::make($cart), 200);
    }

    public function finish(): JsonResponse
    {
        $cart = (new GetCartAction())->execute();
        $cart = (new FinishOrderAction())->execute($cart);
        return response()->json(OrderResource::make($cart), 200);
    }

    public function destroy(): JsonResponse
    {
        $cart = (new GetCartAction())->execute();
        (new DeleteOrderAction())->execute($cart);
        return response()->json(['message' => 'deleted entity'], 200);
    }
}
