<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'name' => 'required|string|min:5|max:255',
            'description' => 'required|string|min:5|max:255',
            'value_cents' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:1',
        ];

        if ($this->isMethod('post')) {
            $rules['category_id'] = 'required|exists:products_categories,id';
        }

        return $rules;

    }
}
