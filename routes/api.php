<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Api Health Check
Route::get('/health', function (){
   return response()->json([
       "message" => "All is awesome"
   ]);
});


// Login Register
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
// Logout Auth
Route::post('logout',[AuthController::class,'logout'])
    ->middleware('auth:sanctum');
