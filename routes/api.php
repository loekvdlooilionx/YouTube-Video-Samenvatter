<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes voor JSON / API calls voor de YouTube Samenvatter.
|
*/

// Video toevoegen via URL
Route::post('/videos', [VideoController::class, 'addVideo']);

// Video detail ophalen
Route::get('/videos/{id}', [VideoController::class, 'show']);

// Samenvatting of transcript ophalen
Route::post('/videos/{id}/summary', [VideoController::class, 'generateSummary']);
Route::get('/videos/{id}/transcript', [VideoController::class, 'getTranscript']);

// Video zoeken via keyword (optioneel)
Route::get('/videos/search', [VideoController::class, 'searchYouTube']);

// Tags beheren
Route::get('/videos/{id}/tags', [VideoController::class, 'getTags']);
Route::post('/videos/{id}/tags', [VideoController::class, 'addTags']);

// Categorie instellen
Route::post('/videos/{id}/category', [VideoController::class, 'setCategory']);

// User routes (optioneel, als je login wilt)
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/user/videos', [UserController::class, 'myVideos']);
Route::get('/user/videos/favorites', [UserController::class, 'myFavorites']);
Route::post('/user/videos/{id}/favorite', [UserController::class, 'toggleFavorite']);
