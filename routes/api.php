<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourierController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/couriers', [CourierController::class, 'index']);
Route::post('/couriers', [CourierController::class, 'store']);
Route::get('/couriers/{id}', [CourierController::class, 'show']);
Route::put('/couriers/{id}', [CourierController::class, 'update']);
Route::delete('/couriers/{id}', [CourierController::class, 'destroy']);
