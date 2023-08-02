<?php

namespace App\Models;

use App\Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{

    use SoftDeletes;
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
