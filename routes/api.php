<?php

use App\Http\Controllers\Attendancecontroller;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\Employeecontroller;
use App\Http\Controllers\productcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// public Routes

Route::POST('/register', [Authcontroller::class,'register']);
Route::POST('/login', [Authcontroller::class,'login']);

// Privet Routes
Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::resource('/employee', Employeecontroller::class);
    Route::resource('/attendance', Attendancecontroller::class);
    Route::get('/attendance-Leave/{id}', [Attendancecontroller::class,'attendanceLeave']);
    Route::POST('/attendance-show', [Attendancecontroller::class,'show']);
    Route::POST('/attendance-Best-employee', [Attendancecontroller::class,'Best_employee']);
    Route::get('/employee/search/{name}', [Employeecontroller::class,'search']);
    Route::POST('/logout', [Authcontroller::class,'logout']);
});


