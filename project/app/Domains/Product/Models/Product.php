<?php

namespace App\Domains\Product\Models;

use App\Domains\Shared\BaseProduct;

class Product extends BaseProduct
{
    protected $fillable = [
        'name',
        'description',
        'value_cents',
        'available_quantity'
    ];
}
