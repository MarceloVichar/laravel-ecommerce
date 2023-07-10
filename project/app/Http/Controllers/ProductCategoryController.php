<?php

namespace App\Http\Controllers;

use App\Actions\ProductsCategories\CreateProductCategoryAction;
use App\Actions\ProductsCategories\UpdateProductCategoryAction;
use App\Adapters\ProductCategoryAdapter;
use App\Http\Requests\ProductCategoryRequest;
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

    public function store(ProductCategoryRequest $request): JsonResponse
    {
        $productCategoryData = (new ProductCategoryAdapter())->handle($request->validated());
        $productCategory = (new CreateProductCategoryAction())->execute($productCategoryData);
        return response()->json(ProductCategoryResource::make($productCategory), 201);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory): JsonResponse
    {
        $productCategoryData = (new ProductCategoryAdapter())->handle($request->validated());
        $productCategory = (new UpdateProductCategoryAction())->execute($productCategory, $productCategoryData);
        return response()->json(ProductCategoryResource::make($productCategory), 200);
    }

    public function show(ProductCategory $productCategory): JsonResponse
    {
        return response()->json(ProductCategoryResource::make($productCategory), 200);
    }

    public function destroy(ProductCategory $productCategory): JsonResponse
    {
        $productCategory->deleteOrFail();
        return response()->json(['message'=>'deleted entity'], 200);
    }
}
