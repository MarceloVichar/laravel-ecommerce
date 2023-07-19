<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function rules()
    {
        $parameterNames = Route::current()->parameterNames();
        $user = is_array($parameterNames) && !empty($parameterNames) ? $this->route($parameterNames[0]) : null;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user ? $user->id : null),
            ],
        ];


        if ($this->isMethod('post')) {
            $rules['password'] = 'required|confirmed';
        }

        return $rules;
    }
}
