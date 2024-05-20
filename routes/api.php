<?php

use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
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

Route::apiResource('user', UserController::class);
Route::post("/login/{email}/{password}", [App\Http\Controllers\UserController::class, 'login']);
Route::put("/update/{email}", [App\Http\Controllers\UserController::class, 'update']);
Route::apiResource('book', BookingController::class);
Route::get("/search/{nama}", [BookingController::class, 'search']);
Route::apiResource('belanja', BelanjaController::class);
Route::get("/search/{nama}", [BelanjaController::class, 'search']);
