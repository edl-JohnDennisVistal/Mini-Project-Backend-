<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Users;
use App\Http\Controllers\TestController;

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
Route::post('auth/login', [Users::class,'login']);
Route::get('auth/logout', [Users::class,'logout'])->middleware('auth:api');

Route::get('hello', [TestController::class,'hello']);
Route::get('privatehello', [TestController::class,'privatehello'])->middleware('auth:api');
