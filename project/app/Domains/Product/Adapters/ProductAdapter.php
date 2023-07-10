<?php

namespace App\Domains\Product\Adapters;

use App\Domains\Product\Data\ProductData;

class ProductAdapter
{
    public function handle(array $data): ProductData
    {
        return new ProductData(
            data_get($data, 'name'),
            data_get($data, 'description'),
            data_get($data, 'value_cents'),
            data_get($data, 'available_quantity')
        );
    }
}
