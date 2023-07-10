<?php

namespace App\Actions\ProductsCategories;

use App\Data\ProductCategoryData;
use App\Models\ProductCategory;

class UpdateProductCategoryAction
{
    public function execute(ProductCategory $productCategory, ProductCategoryData $productCategoryData): ProductCategory
    {
        $productCategory->update($productCategoryData->toArray());
        return $productCategory;
    }
}
