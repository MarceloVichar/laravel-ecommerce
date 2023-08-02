<?php

namespace App\Domains\Product\Actions;

use App\Actions\Companies\GetUserCompanyAction;
use App\Domains\Product\Models\Product;
use Exception;

class CheckIfProductIsFromCurrentCompanyAction
{
    /**
     * @throws Exception
     */
    public function execute(Product $product): Product
    {
        $company = (new GetUserCompanyAction())->execute();
        if ($company->id !== $product->company_id) {
            throw new Exception('Product is not from your company', '404');
        }
        return $product;
    }
}
