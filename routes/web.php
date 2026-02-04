<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\VideoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes die je via de browser bezoekt.
|
*/

// Home / Video form
Route::get('/', [VideoController::class, 'showForm']);
Route::post('/', [VideoController::class, 'fetchVideo'])->name('video.fetch');

// Test YouTube API key (optioneel)
Route::get('/test-youtube', function () {
    $videoId = 'dQw4w9WgXcQ'; // voorbeeld video ID
    $apiKey = env('YOUTUBE_API_KEY');

    $response = Http::get("https://www.googleapis.com/youtube/v3/videos", [
        'id' => $videoId,
        'key' => $apiKey,
        'part' => 'snippet,contentDetails,statistics'
    ]);

    return $response->ok() ? $response->json() : response()->json(['error' => 'API request mislukt'], 400);
});

// Alle videos tonen (optioneel)
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');

// Video detailpagina (optioneel)
Route::get('/videos/{id}', [VideoController::class, 'show'])->name('videos.show');
