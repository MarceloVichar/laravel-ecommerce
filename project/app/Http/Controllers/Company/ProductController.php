<?php

namespace App\Http\Controllers\Company;

use App\Actions\Companies\GetUserCompanyAction;
use App\Criterias\Common\WhereCriteria;
use App\Domains\Product\Actions\CheckIfProductIsFromCurrentCompanyAction;
use App\Domains\Product\Actions\CreateProductAction;
use App\Domains\Product\Actions\UpdateProductAction;
use App\Domains\Product\Adapters\ProductAdapter;
use App\Domains\Product\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCompanyRequest;
use App\Http\Resources\ProductResource;
use App\Support\PaginationBuilder;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): PaginationBuilder
    {
        $company = (new GetUserCompanyAction())->execute();

        return PaginationBuilder::for(Product::class)
            ->criteria([
                new WhereCriteria('company_id', $company->id)
            ])
            ->resource(ProductResource::class);
    }

    public function store(ProductCompanyRequest $request): JsonResponse
    {
        $company = (new GetUserCompanyAction())->execute();
        $data = $request->validated();
        $data['company_id'] = $company->id;
        $productData = (new ProductAdapter())->handle($data);
        $product = (new CreateProductAction())->execute($productData);
        return response()->json(ProductResource::make($product), 200);
    }

    public function update(ProductCompanyRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        (new CheckIfProductIsFromCurrentCompanyAction())->execute($product);
        $data['company_id'] = $product->company_id;
        $productData = (new ProductAdapter())->handle($data);
        $product = (new UpdateProductAction())->execute($product, $productData);
        return response()->json(ProductResource::make($product), 200);
    }

    public function show(Product $product): JsonResponse
    {
        (new CheckIfProductIsFromCurrentCompanyAction())->execute($product);
        $product->load('category');
        $product->load('company');
        return response()->json(ProductResource::make($product), 200);
    }

    public function destroy(Product $product): JsonResponse
    {
        (new CheckIfProductIsFromCurrentCompanyAction())->execute($product);
        $product->deleteOrFail();
        return response()->json(['message'=>'deleted entity'], 200);
    }
}
