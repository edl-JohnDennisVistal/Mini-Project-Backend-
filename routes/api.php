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
    Route::put('auth/update/user/details', [UserDetails::class,'updateUserDetails']);  
    Route::get('auth/user/details/{id}', [UserDetails::class,'fetchUserDetails']); 
    Route::get('auth/profile/self', [Users::class,'selfDetails']); 
    Route::post('auth/skill/add', [Users::class,'addSkill']);
    Route::get('auth/logout', [Users::class,'logout']);     
    /* Skills */
    Route::get('auth/skills', [Skills::class,'fetchSkills']);
    Route::get('auth/user/skills/{id}', [Skills::class,'getUserSkills']);
    /** 
     *  Admin rights
     **/
    /* Skills */
    Route::post('auth/add/skill', [Skills::class,'addSkill'])->middleware('role:ROLE_ADMIN');  
    Route::post('auth/update/skill', [Skills::class,'updateSkill'])->middleware('role:ROLE_ADMIN');   
    Route::post('auth/remove/skill', [Skills::class,'removeSkill'])->middleware('role:ROLE_ADMIN');  
    /* Projects */
    Route::get('auth/fetch/projects', [Projects::class,'fetchProjects'])->middleware('role:ROLE_ADMIN');  
    Route::post('auth/add/project', [Projects::class,'createProject'])->middleware('role:ROLE_ADMIN');    
    Route::get('auth/fetch/project/user/{id}', [Projects::class,'fetchProjectUsers'])->middleware('role:ROLE_ADMIN');  
    Route::put('auth/edit/project', [Projects::class,'editProject'])->middleware('role:ROLE_ADMIN');  
    Route::delete('/auth/project/delete/{id}', [Projects::class,'deleteProject'])->middleware('role:ROLE_ADMIN');  
    Route::get('/auth/project/members/{id}', [Projects::class,'projectMembers'])->middleware('role:ROLE_ADMIN');  
    Route::post('auth/project/members/add', [Projects::class,'addProjectMember'])->middleware('role:ROLE_ADMIN');  
    /* Users */
    Route::get('auth/admin/panel', [Users::class,'fetchAllUsersData'])->middleware('role:ROLE_ADMIN');  
    Route::get('auth/admin/panel/delete/{id}', [Users::class,'deleteUser'])->middleware('role:ROLE_ADMIN');  
});
    