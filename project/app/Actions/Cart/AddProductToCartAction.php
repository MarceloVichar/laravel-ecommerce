<?php

namespace App\Actions\Cart;

use App\Domains\Product\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;

class AddProductToCartAction
{
    /**
     * @throws Exception
     */
    public function execute($data, Product $product): Order
    {
        if ($data['quantity'] > $product->available_quantity) {
            throw new Exception('Quantity bigger than available', 500);
        }

        $order = (new GetOrCreateCart())->execute($product);

        $existingOrderItem = OrderItem::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingOrderItem) {
            throw new Exception('Product already exists in the cart', 500);
        }

        if ($order->company_id !== $product->company_id) {
            throw new Exception('You have a order opened in other company', 500);
        }


        $order_item = new OrderItem([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_description' => $product->description,
            'product_value' => $product->value_cents,
            'quantity' => $data['quantity']
        ]);

        $order_item->save();

        return $order;
    }
}
