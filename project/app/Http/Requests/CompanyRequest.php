<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'name' => 'required|string|min:5|max:255',
            'trading_name' => 'string|min:5|max:255',
            'cnpj' => 'required|string|min:5|max:255',
            'phone' => 'required|string|min:8',
        ];

        if ($this->isMethod('post')) {
            $rules['owner_name'] = 'required|string|min:5|max:255';
            $rules['owner_email'] = 'required|email|unique:users,email';
            $rules['owner_password'] = 'required|confirmed';
        }

        return $rules;
    }
}
