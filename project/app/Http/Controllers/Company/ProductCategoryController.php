<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return QueryBuilder::for(ProductCategory::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
            ])
            ->paginate(10);
    }

    public function show(ProductCategory $products_category): JsonResponse
    {
        return response()->json(ProductCategoryResource::make($products_category), 200);
    }
}
