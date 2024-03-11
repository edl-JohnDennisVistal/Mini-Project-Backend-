<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDetailsValidation extends FormRequest{
    public function rules(){
        return [
            'first_name' => 'required|string|regex:/^[A-Za-z\s]+$/|max:45',
            'last_name' => 'required|string|regex:/^[A-Za-z\s]+$/|max:45',
            'age' => 'required|numeric|between:1,100',
            'gender' => 'required|max:10',
            'address' => 'required|max:50',
            'users_id' => 'required|numeric',
        ];
    }
}
