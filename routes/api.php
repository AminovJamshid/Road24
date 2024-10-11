<?php

use App\Http\Controllers\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('cars', CarController::class);
Route::apiResource('license', CarController::class);
Route::apiResource('fine', CarController::class);
