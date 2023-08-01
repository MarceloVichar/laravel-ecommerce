<?php

namespace App\Http\Controllers;

use App\Actions\Cart\DeleteOrderAction;
use App\Actions\Cart\GetCartAction;
use App\Actions\CartItems\UpdateCartItemAction;
use App\Http\Requests\OrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;

class CartItemController extends Controller
{

    public function show(OrderItem $item): JsonResponse
    {
        $cart = (new GetCartAction())->execute();
        if ($cart->id !== $item->order_id) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $item->load('product');
        $item->load('order');
        return response()->json(OrderItemResource::make($item), 200);
    }

    public function update(OrderItemRequest $request, OrderItem $item): JsonResponse
    {
        $data = $request->validated();
        $cart = (new GetCartAction())->execute();
        if ($cart->id !== $item->order_id) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        $item = (new UpdateCartItemAction())->execute($item, $data);
        return response()->json(OrderItemResource::make($item), 200);
    }

    public function destroy(OrderItem $item): JsonResponse
    {
        $cart = (new GetCartAction())->execute();
        if ($cart->id !== $item->order_id) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        (new DeleteOrderAction())->execute($cart);
        return response()->json(['message' => 'deleted entity'], 200);
    }
}
