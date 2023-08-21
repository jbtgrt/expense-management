<?php

use App\Http\Controllers\AuthController; 
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\RoleController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\ExpenseCategoryController; 
use App\Http\Controllers\ExpenseController; 


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function(){

	Route::get('/my-expenses', [DashboardController::class, 'index']); 
	 
	Route::get('/expense-category-types', [ExpenseCategoryController::class, 'expCategoryTypes']); 
	Route::resource('/expense-category', ExpenseCategoryController::class); 
	Route::resource('/expense', ExpenseController::class); 

	
	Route::resource('/role', RoleController::class); 

	Route::post('/user/{id}', [UserController::class, 'updateInfo']); 
	Route::resource('/user', UserController::class); 

});

Route::get('/role-types', [RoleController::class, 'roleTypes']); 
// Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login', [AuthController::class, 'login']); 
Route::post('/logout', [AuthController::class, 'logout']); 



