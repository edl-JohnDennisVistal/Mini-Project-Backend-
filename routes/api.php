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

Route::post('auth/register', [Users::class,'register']);
Route::post('auth/update/registered/data', [Users::class,'updateRegistration']);
Route::post('auth/login', [Users::class,'login']);

Route::post('auth/add/user/details', [UserDetails::class,'insertUserDetails']);             
Route::post('auth/update/user/details', [UserDetails::class,'updateUserDetails']);  

Route::post('auth/add/project', [Projects::class,'createProject']);   
Route::post('auth/update/project', [Projects::class,'updateProject']);   

Route::post('auth/add/skill', [Skills::class,'addSkill']);   
Route::post('auth/update/skill', [Skills::class,'updateSkill']);   
Route::post('auth/remove/skill', [Skills::class,'removeSkill']);   

Route::get('auth/logout', [Users::class,'logout'])->middleware('auth:api');

Route::get('hello', [TestController::class,'hello']);
Route::get('privatehello', [TestController::class,'privatehello'])->middleware('auth:api');
