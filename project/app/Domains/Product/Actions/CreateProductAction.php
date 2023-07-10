<?php

namespace App\Domains\Product\Actions;

use App\Domains\Product\Models\Product;
use App\Domains\Product\Data\ProductData;

class CreateProductAction
{
    public function execute(ProductData $productData): Product
    {
        $product = new Product($productData->toArray());
        $product->save();

        return $product;
    }
}
