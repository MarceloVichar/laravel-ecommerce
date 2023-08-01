<?php

namespace App\Actions\CartItems;

use App\Domains\Product\Models\Product;
use App\Models\OrderItem;
use Exception;

class UpdateCartItemAction
{
    public function execute(OrderItem $order_item, $data): OrderItem
    {
        $product = Product::where('id', $order_item->product_id)
            ->first();

        if (!$product) {
            throw new Exception('Product not found', 500);
        }

        if ($product->available_quantity < $data['quantity']) {
            throw new Exception('Quantity unavailable', 500);
        }

        $order_item->update($data);

        return $order_item;
    }
}
