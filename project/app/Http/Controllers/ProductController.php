<?php

namespace App\Http\Controllers;

use App\Domains\Product\Actions\CreateProductAction;
use App\Domains\Product\Actions\UpdateProductAction;
use App\Domains\Product\Adapters\ProductAdapter;
use App\Domains\Product\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Support\PaginationBuilder;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): PaginationBuilder
    {
        return PaginationBuilder::for(Product::class)
            ->resource(ProductResource::class);
    }

    public function store(ProductRequest $request)
    {
        $productData = (new ProductAdapter())->handle($request->validated());
        $product = (new CreateProductAction())->execute($productData);
        return ProductResource::make($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $productData = (new ProductAdapter())->handle($request->validated());
        $product = (new UpdateProductAction())->execute($product, $productData);
        return ProductResource::make($product);
    }

    public function show(Product $product): JsonResponse
    {
        $product->load('category');
        return response()->json(ProductResource::make($product), 200);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->deleteOrFail();
        return response()->json(['message'=>'deleted entity'], 200);
    }
}
