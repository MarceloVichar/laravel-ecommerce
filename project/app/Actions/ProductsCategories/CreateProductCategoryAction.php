<?php

namespace App\Actions\ProductsCategories;

use App\Data\ProductCategoryData;
use App\Models\ProductCategory;

class CreateProductCategoryAction
{
    public function execute(ProductCategoryData $productCategoryData): ProductCategory
    {
        $productCategory = new ProductCategory($productCategoryData->toArray());
        $productCategory->save();

        return $productCategory;
    }
}
