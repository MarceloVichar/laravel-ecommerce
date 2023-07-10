<?php

namespace App\Domains\Product\Actions;

use App\Domains\Product\Models\Product;
use App\Domains\Product\Data\ProductData;

class UpdateProductAction
{
    public function execute(Product $product, ProductData $productData): Product
    {
        $product->update($productData->toArray());
        return $product;
    }
}
