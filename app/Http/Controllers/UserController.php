<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Registreren
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'Account aangemaakt', 'user' => $user]);
    }

    // Inloggen
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Ongeldige credentials'], 401);
        }

        // Je kunt Laravel Sanctum of Passport gebruiken voor token auth
        // Voor demo:
        Auth::login($user);
        return response()->json(['message' => 'Ingelogd', 'user' => $user]);
    }

    // Mijn video’s
    public function myVideos(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Niet ingelogd'], 401);

        $videos = $user->videos()->with('tags')->get();
        return response()->json($videos);
    }

    // Favorieten
    public function myFavorites(Request $request)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Niet ingelogd'], 401);

        $favorites = $user->videos()->wherePivot('is_favorite', true)->with('tags')->get();
        return response()->json($favorites);
    }

    // Toggle favorite
    public function toggleFavorite(Request $request, $videoId)
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(['error' => 'Niet ingelogd'], 401);

        $video = Video::findOrFail($videoId);

        $current = $user->videos()->where('video_id', $video->id)->first();
        if ($current) {
            $user->videos()->updateExistingPivot($video->id, [
                'is_favorite' => !$current->pivot->is_favorite
            ]);
        } else {
            $user->videos()->attach($video->id, ['is_favorite' => true]);
        }

        return response()->json(['message' => 'Favoriet status gewijzigd']);
    }
}
