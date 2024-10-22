<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AttendanceController;
/*
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/create_attendance',[AttendanceController::class,'create_attendance'])->name('create_attendance');
//Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/login',[AuthController::class,'login'])->name('login');

Route::middleware('auth:sanctum')->group( function () {
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
    Route::post('/update_password',[AuthController::class,'update_password'])->name('update_password');
    Route::get('/profile',[AuthController::class,'profile'])->name('profile');
    Route::get('/home',[AttendanceController::class,'home'])->name('home');
    Route::post('/check_in_out',[AttendanceController::class,'check_in_out'])->name('check_in_out');
    
});


