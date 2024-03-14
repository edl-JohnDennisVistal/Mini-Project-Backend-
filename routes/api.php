<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Users;
use App\Http\Controllers\UserDetails;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Projects;
use App\Http\Controllers\Skills;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

 
/** 
 *  Routes that does not require authentication
**/
Route::post('auth/login', [Users::class,'login']);
Route::post('auth/register', [Users::class,'register']);


/** 
 *  Protected by JWT Authentication
**/
Route::middleware(['auth:api'])->group(function () {
    /** 
     *  Users priveleges. Modefy their own details and skills
    **/
    Route::post('auth/update/registered/data', [Users::class,'updateRegistration']);    
    Route::post('auth/add/user/details', [UserDetails::class,'insertUserDetails']);               
    Route::post('auth/update/user/details', [UserDetails::class,'updateUserDetails']);  
    Route::get('auth/user/details/{id}', [UserDetails::class,'fetchUserDetails']); 
    Route::get('auth/logout', [Users::class,'logout']);     
    /** 
     *  Admin rights
     **/
    /* Skills */
    Route::post('auth/add/skill', [Skills::class,'addSkill'])->middleware('role:ROLE_ADMIN');  
    Route::post('auth/update/skill', [Skills::class,'updateSkill'])->middleware('role:ROLE_ADMIN');   
    Route::post('auth/remove/skill', [Skills::class,'removeSkill'])->middleware('role:ROLE_ADMIN');  
    /* Projects */
    Route::post('auth/add/project', [Projects::class,'createProject'])->middleware('role:ROLE_ADMIN');   
    Route::post('auth/update/project', [Projects::class,'updateProject'])->middleware('role:ROLE_ADMIN');  
    /* Users */
    Route::get('auth/admin-panel/{id}', [Users::class,'fetchUsers'])->middleware('role:ROLE_ADMIN');  
    Route::get('auth/admin-panel/delete/{id}', [Users::class,'deleteUser'])->middleware('role:ROLE_ADMIN');  
});
