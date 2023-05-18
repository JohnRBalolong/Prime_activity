<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserCredentialsController;
use App\Http\Controllers\fav_product_controller;

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

// Route::get('userdata', [UserCredentialsController::class, 'index']);
Route::get('fav_product', [fav_product_controller::class, 'index']);
Route::post('fav_product', [fav_product_controller::class, 'store']);
Route::post('fav_product/{id}/update', [fav_product_controller::class, 'update']);
Route::delete('fav_product/{id}/delete', [fav_product_controller::class, 'destroy']);

Route::post('userdata', [UserCredentialsController::class, 'store']);
Route::post('login', [UserCredentialsController::class, 'login']);




