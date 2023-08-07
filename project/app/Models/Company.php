<?php

namespace App\Models;

use App\Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'trading_name',
        'phone',
        'owner_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public static function newFactory(): CompanyFactory
    {
        return CompanyFactory::new();
    }
}
