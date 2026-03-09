<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SermonController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('signup', [AuthController::class, 'signup']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('series', SeriesController::class);
    Route::apiResource('sermons', SermonController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('blogs', BlogController::class);
    Route::apiResource('media', MediaController::class)->only(['index', 'store', 'destroy']);

    Route::post('blogs/upload-editor-image', [BlogController::class, 'uploadEditorImage']);

    Route::get('user', [AuthController::class, 'user']);

    Route::post('logout', [AuthController::class, 'logout']);
});
