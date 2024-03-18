<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserDetailsValidation;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**  
 *   Docu: This class is for userDetails related processes. (Such as first name, last name, age, gender etc.)
**/
class UserDetails extends Controller{
    /**  
     *   This method is used to update user details.
    **/
    public function updateUserDetails(UserDetailsValidation $request){
        $validatedData = $request->validated();
        $id = auth()->user()->id;
        $userData = [
            'username' => $validatedData['username'],
            'password' => $validatedData['password'],
        ];
        $userDetailsData = [
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'age' => $validatedData['age'],
            'gender' => $validatedData['gender'],
            'email' => $validatedData['email'],
        ];
        $user = User::find($id)->update($userData);
        $userDetails = UserDetail::where('user_id', $id)->update($userDetailsData);
        if($user && $userDetails){
            return response()->json(['userDetails' => true], 200);
        }
        return response()->json(['userDetails' => 'Something went wrong. Please try again.'], 200);
    } 
    public function fetchUserDetails($id){
        $role = User::with('roles')
            ->with('userDetails')
            ->with('projects')
            ->find($id);
        return response()->json(['userDetails' => $role], 200);
    }
}
