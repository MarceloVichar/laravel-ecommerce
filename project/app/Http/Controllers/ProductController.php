<?php

namespace App\Http\Controllers;

use App\Domains\Product\Actions\CreateProductAction;
use App\Domains\Product\Actions\UpdateProductAction;
use App\Domains\Product\Adapters\ProductAdapter;
use App\Domains\Product\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public function index()
    {
        return QueryBuilder::for(Product::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('name'),
            ])
            ->paginate(10);
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
}