<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeImageController;
use App\Http\Controllers\WeddingCardController;

Route::get('/countries', [CountryController::class, 'index']);
Route::get('/home-images', [HomeImageController::class, 'index']);
Route::get('/features', [FeatureController::class, 'index']);
Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/settings', [GeneralController::class, 'getSettings']);
Route::get('/home-data', [GeneralController::class, 'getHomeData']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/events/preview', [EventController::class, 'preview']);
    Route::patch('/events/{event}/start', [EventController::class, 'start']);
    Route::patch('/events/{event}/end', [EventController::class, 'end']);
    Route::post('/events/{event}/attend', [EventController::class, 'attend']);
    Route::post('/events/{event}/send-more-invites', [EventController::class, 'sendMoreInvites']);
    Route::apiResource('events', EventController::class);
    Route::get('/wedding-cards', [WeddingCardController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/user', [ProfileController::class, 'user']);
});

Route::get('/info', function() {
    return phpinfo();
});

require __DIR__.'/auth.php';