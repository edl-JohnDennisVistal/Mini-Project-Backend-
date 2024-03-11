<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginValidation extends FormRequest{
    public function rules(){
        return [
            'email' => 'required|string',
            'password' => 'required|string|min:5'
        ];
    }
}
