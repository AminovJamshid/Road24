<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\LicenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('cars', CarController::class);
Route::apiResource('license', LicenseController::class);
Route::apiResource('fine',FineController::class);
