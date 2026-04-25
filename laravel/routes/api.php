<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SermonController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:5,1'])->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('public')->group(function () {
    Route::get('blogs', [BlogController::class, 'publicIndex']);
    Route::get('blogs/{blog:slug}', [BlogController::class, 'publicShow']);
    Route::get('sermons', [SermonController::class, 'publicIndex']);
    Route::get('sermons/{sermon:slug}', [SermonController::class, 'publicShow']);
    Route::get('events', [EventController::class, 'publicIndex']);
    Route::get('settings', [SettingController::class, 'publicIndex']);
    Route::get('search', [SearchController::class, 'index']);
    Route::middleware(['throttle:3,1'])->post('contact', [ContactController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
    Route::apiResource('series', SeriesController::class);
    Route::put('series/{series}/sermons', [SeriesController::class, 'syncSermons']);
    Route::apiResource('sermons', SermonController::class);
    Route::apiResource('events', EventController::class);
    Route::apiResource('blogs', BlogController::class);
    Route::apiResource('media', MediaController::class)->except(['destroy']);
    Route::get('overview', [ContactController::class, 'overview']);

    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource('users', UserController::class);
        Route::delete('media/{media}', [MediaController::class, 'destroy']);
        Route::put('settings', [SettingController::class, 'update']);
    });

    Route::post('blogs/upload-editor-image', [BlogController::class, 'uploadEditorImage']);

    Route::get('user', [AuthController::class, 'user']);
    Route::post('profile', [ProfileController::class, 'update']);

    Route::post('logout', [AuthController::class, 'logout']);
});
