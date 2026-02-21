<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SermonController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'authenicate']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('series', SeriesController::class);
    Route::apiResource('sermons', SermonController::class);
    Route::apiResource('events', EventController::class);

    Route::get('user', [AuthController::class, 'user']);

    Route::post('logout', [AuthController::class, 'logout']);
});
