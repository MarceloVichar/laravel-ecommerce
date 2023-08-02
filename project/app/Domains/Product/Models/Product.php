<?php

namespace App\Domains\Product\Models;

use App\Domains\Shared\BaseProduct;
use App\Models\Company;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseProduct
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'value_cents',
        'company_id',
        'available_quantity',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
