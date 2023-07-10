<?php

namespace App\Models;

use App\Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'products_categories';

    protected $fillable = [
        'name',
        'description'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
