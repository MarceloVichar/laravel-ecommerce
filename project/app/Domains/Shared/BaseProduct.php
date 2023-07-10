<?php

namespace App\Domains\Shared;

use Illuminate\Database\Eloquent\Model;

class BaseProduct extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'value_cents',
        'available_quantity'
    ];
}
