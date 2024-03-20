<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrationValidation;
use App\Http\Requests\UserDetailsValidation;
use App\Http\Requests\LoginValidation;
use App\Models\User;
use App\Models\Role;
use App\Models\UserDetail;

/** 
 *   Docu: This class is for user related processes.
**/
class Users extends Controller{
    /**  
     *   Registers a new user.
     *   Validates the form data using RegistrationValidation class.
     *   Returns the user object.
     *   Sets Role for the user.
    **/
    public function register(RegistrationValidation $request){
        $validatedData = $request->validated();
        $user = User::create([
            'username' => $validatedData['username'], 
            'password' => bcrypt($validatedData['password']),
        ]);
        $userDetails = UserDetail::create([
            'user_id' => $user->id,
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'date_of_birth' => date("F d, Y", strtotime($validatedData['date_of_birth'])),
            'gender' => ucfirst($validatedData['gender']),
            'email' => $validatedData['email'],
            'age' => $validatedData['age'],   
        ]);
        $role = Role::where('role', $request->input('role'))->first();
        if ($user && $role) {
            $user->roles()->attach($role);
            return response()->json(['message' => 'User created successfully'], 201); 
        }
        return response()->json(['message' => 'Something went wrong. Please try again. Role or User not found.'], 500); 
    }
    /**  
     *   Update the regestration data.
     *   This is separate table from the user details table.
     *   Returns the user object.
    **/
    public function updateRegistration(RegistrationValidation $request){
        $validatedData = $request->validated();
        $validatedData['updated_at'] = date('Y-m-d H:i:s');
        $user = User::where('email', $validatedData['email'])->update($validatedData);
        return $user;
    }
    /**  
     *   Logs in a user.
     *   Validates the form data using LoginValidation class.
     *   Returns the token.
     *   Returns an error message if the credentials are invalid.
    **/
    public function login(LoginValidation $request){
        $validatedData = $request->validated();
        if(! $token = auth('api')->attempt([
            'username' => $validatedData['username'], 
            'password' => $validatedData['password']
        ])){
            return response()->json([
                'message' => 'Invalid username or password'
            ],401);
        }
        $user = auth('api')->user()->roles;
        $data = [
            'id' => auth('api')->user()->id,
            'role' => $user[0]->role,
            'username' => auth('api')->user()->username
        ];
        return $this->respondWithToken([
            'token' => $token,
            'user' => $data
        ]);
    }
    /**  
     *   Logs out a user.
     *   Requires a JWT token in the Authorization header.
    **/
    public function logout(Request $request){        
        auth('api')->logout();
        return response()->json(['response' => true]);
    }  
    /** 
     *   For admin users only.
    **/
    public function fetchAllUsersData(){
        $id = auth()->user()->id;
        $users = User::where('id', '!=', $id)->with('userDetails', 'roles', 'projects')->get()->toArray();
        $data = [];
        if( isset($users) && !empty($users) ){
            foreach ($users as $key => $value) {
                $data[] = [
                    'id' => $value['id'],
                    'name' => $value['user_details'][0]['first_name'] . ' ' . $value['user_details'][0]['last_name'],
                    'projects' => count($value['projects']),
                    'role' => $value['roles'][0]['role']
                ];
            }
        }
        return response()->json(['data' => $data], 201);
    }
    /** 
     *   For admin users only. Delete other users.
    **/
    public function deleteUser($id){
        $user = User::findOrFail($id); 
        $user->userDetails()->delete();
        $user->roles()->detach(); 
        $user->projects()->detach();
        $user->skills()->detach();
        $user->delete(); 
        return response()->json(201);
    }
    /** 
     *   For self update. No need to pass id for security.
    **/
    public function selfDetails(){
        $id = auth()->user()->id;
        $users = User::with(['userDetails', 'roles' => function ($query) use ($id) {
            $query->where('user_id', $id);
        }, 'projects'])->find($id);        
        return response()->json(['data' => $users], 201);
    }
    /** 
     *  Add skill to users. Can be access all users.
    **/
    public function addSkill(Request $request){
        $user = auth()->user(); 
        $skill_id = intval($request->skill);;
        $user->skills()->attach($skill_id);
        if(!$user){
            return response()->json(['response' => false], 201);
        }
        return response()->json(['response' => true], 201);
    }
    /** 
     *  Delete skill to users. Can be access all users.
    **/
    public function deleteSkill($id){
        $user = auth()->user(); 
        $skill_id = intval($id);
        $user->skills()->detach($skill_id);
        if(!$user){
            return response()->json(['response' => false], 201);
        }
        return response()->json(['response' => true], 201);
    }
    /** 
     *   For home component displays name
    **/
    public function getMyName(){
        $user = auth()->user();
        $userDetails = $user->userDetails; 
        if ($userDetails) {
            $firstName = $userDetails[0]->first_name;
            $lastName = $userDetails[0]->last_name;
            $id = $userDetails[0]->id;
            return response()->json([ 'id' => $id, 'name' => $firstName . ' ' . $lastName], 201);
        }
        return null;
    }
    /** 
     *   When app is restarted, this will check for user authentication.
    **/
    public function checkAuth(){
        $user = auth('api')->user()->roles;
        $data = [
            'id' => auth('api')->user()->id,
            'role' => $user[0]->role,
            'username' => auth('api')->user()->username
        ];


        $user = auth('api')->user()->roles;
        $data = [
            'id' => auth('api')->user()->id,
            'role' => $user[0]->role,
            'username' => auth('api')->user()->username
        ];
        return response()->json(['access_token' => ['user' => $data]], 201);
    }
    /** 
     *   Generates token for authentication, returns to the user. 
    **/
    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
