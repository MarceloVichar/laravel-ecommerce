<?php

namespace App\Http\Controllers\Customer;

use App\Actions\Cart\AddProductToCartAction;
use App\Domains\Product\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderItemRequest;
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

    public function show(Product $product): JsonResponse
    {
        $product->load('category');
        $product->load('company');
        return response()->json(ProductResource::make($product), 200);
    }

    public function addToCart(OrderItemRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        (new AddProductToCartAction())->execute($data, $product);
        return response()->json(['message'=>'product added to cart'], 200);
    }
}
