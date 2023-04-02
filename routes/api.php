<?php

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

Route::resource('/task', \App\Http\Controllers\TaskController::class);
Route::resource('/developer', \App\Http\Controllers\DeveloperController::class);
Route::get('/plan',[\App\Http\Controllers\PlanController::class,'index']);

