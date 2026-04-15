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
    /*
    * another way to bind model from 3rd party package using this
    * Route::model('media', \Spatie\MediaLibrary\MediaCollections\Models\Media::class);
    */

    Route::apiResource('series', SeriesController::class);
    Route::put('series/{series}/sermons', [SeriesController::class, 'syncSermons']);
    Route::apiResource('sermons', SermonController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('blogs', BlogController::class);
    Route::apiResource('media', MediaController::class);

    Route::post('blogs/upload-editor-image', [BlogController::class, 'uploadEditorImage']);

    Route::get('user', [AuthController::class, 'user']);

    Route::post('logout', [AuthController::class, 'logout']);
});
