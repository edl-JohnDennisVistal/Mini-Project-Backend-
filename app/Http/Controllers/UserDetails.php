<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserDetailsValidation;
use App\Models\UserDetail;

/**  
 *   Docu: This class is for userDetails related processes. (Such as first name, last name, age, gender etc.)
**/
class UserDetails extends Controller{
    /**  
     *   This method is used to insert user details.
     *   Validation is done thru UserDetailsValidation.php.
     *   Return: UserDetail object.
    **/
    public function insertUserDetails(UserDetailsValidation $request){
        $validatedData = $request->validated();
        $userDetail = UserDetail::create($validatedData);
        return $userDetail;
    }
    /**  
     *   This method is used to update user details.
    **/
    public function updateUserDetails(UserDetailsValidation $request){
        $validatedData = $request->validated();
        $validatedData['updated_at'] = date('Y-m-d H:i:s');
        $userDetail = UserDetail::where('users_id', $validatedData['users_id'])->update($validatedData);
        if($userDetail){
            return "Details updated successfully";
        }
        return "User not found";
    }
}
