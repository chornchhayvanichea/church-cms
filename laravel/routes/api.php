<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SeriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('logintoken', [AuthController::class, 'login']);
Route::post('registertoken', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('series', SeriesController::class);
});
