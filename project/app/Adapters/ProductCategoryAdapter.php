<?php

namespace App\Adapters;

use App\Data\ProductCategoryData;

class ProductCategoryAdapter
{
    public function handle(array $data): ProductCategoryData
    {
        return new ProductCategoryData(
            data_get($data, 'name'),
            data_get($data, 'description'),
        );
    }
}
