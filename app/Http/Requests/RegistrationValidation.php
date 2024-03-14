<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationValidation extends FormRequest{
    public function rules(){
        return [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:user_details',
            'password' => 'required|string|min:5',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required',
            'role' => 'required|string|max:255|in:ROLE_BASIC,ROLE_ADMIN,ROLE_SUPERVISOR',
            'gender' => 'required|string|max:10',
            'age' => 'required|numeric|min:18|max:120',
        ];
    }
}
