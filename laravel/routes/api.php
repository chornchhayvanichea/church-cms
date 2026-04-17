<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SermonController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('signup', [AuthController::class, 'signup']);

Route::prefix('public')->group(function () {
    Route::get('blogs', [BlogController::class, 'publicIndex']);
    Route::get('blogs/{blog:slug}', [BlogController::class, 'publicShow']);
    Route::get('sermons', [SermonController::class, 'publicIndex']);
    Route::get('sermons/{sermon:slug}', [SermonController::class, 'publicShow']);
    Route::get('events', [EventController::class, 'publicIndex']);
    Route::get('settings', [SettingController::class, 'publicIndex']);
    Route::post('contact', [ContactController::class, 'store']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    /*
    * another way to bind model from 3rd party package using this
    * Route::model('media', \Spatie\MediaLibrary\MediaCollections\Models\Media::class);
    */

    Route::apiResource('users', UserController::class);
    Route::apiResource('series', SeriesController::class);
    Route::put('series/{series}/sermons', [SeriesController::class, 'syncSermons']);
    Route::apiResource('sermons', SermonController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('blogs', BlogController::class);
    Route::apiResource('media', MediaController::class);
    Route::put('settings', [SettingController::class, 'update']);
    Route::get('overview', [ContactController::class, 'overview']);

    Route::post('blogs/upload-editor-image', [BlogController::class, 'uploadEditorImage']);

    Route::get('user', [AuthController::class, 'user']);

    Route::post('logout', [AuthController::class, 'logout']);
});
