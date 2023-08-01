<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
{
    public function rules()
    {
        return [
            'quantity' => 'required|integer'
        ];
    }
}
