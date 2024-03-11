<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegistrationValidation;
use App\Http\Requests\LoginValidation;
use App\Models\User;

/* 
* Docu: This class is for user related processes.
*/
class users extends Controller{
    /* 
    * Registers a new user.
    * Validates the form data using RegistrationValidation class.
    * Returns the user object.
    */
    public function register(RegistrationValidation $request){
        $validatedData = $request->validated();
        $user = User::create($validatedData);
        return $user;
    }
    /* 
    * Logs in a user.
    * Validates the form data using LoginValidation class.
    * Returns the token.
    * Returns an error message if the credentials are invalid.
    */
    public function login(LoginValidation $request){
        $validatedData = $request->validated();
        if(! $token = auth('api')->attempt([
            'email' => $validatedData['email'], 
            'password' => $validatedData['password']
        ])){
            return response()->json([
                'message' => 'invalid email or password'
            ],401);
        }
        return $this->respondWithToken($token);
    }
    /* 
    * Logs out a user.
    * Requires a JWT token in the Authorization header.
    */
    public function logout(Request $request){        
        auth('api')->logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }  
    /* 
    * Generates token for authentication, returns to the user. 
    */
    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
