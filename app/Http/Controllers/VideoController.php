<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\AiService;
use App\Http\models\Video;


class VideoController extends Controller
{
    public function showForm()
    {
        return view('video');
    }

    public function fetchVideo(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        // Video ID ophalen uit URL
        preg_match('/v=([a-zA-Z0-9_-]+)/', $request->url, $matches);
        $videoId = $matches[1] ?? null;

        if (!$videoId) {
            return back()->withErrors(['url' => 'Geen geldige YouTube URL.']);
        }

        $apiKey = env('YOUTUBE_API_KEY');

        // YouTube API request
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos", [
            'id' => $videoId,
            'key' => $apiKey,
            'part' => 'snippet,contentDetails,statistics'
        ]);

        $video = $response->json()['items'][0] ?? null;

        if (!$video) {
            return back()->withErrors(['url' => 'Video niet gevonden of verwijderd.']);
        }

        // Simpele “AI” korte samenvatting placeholder
       $summary_long = substr($video['transcript'] ?? $video['description'], 0, 1000) . '...';

        return view('video', compact('video', 'summary_short'));
    }
    public function generateSummary($id, AiService $ai)
    {
        $video = Video::findOrFail($id);

        $video->summary_short = $ai->summarize($video->transcript);
        $video->category = $ai->sentiment($video->transcript);
        $tags = $ai->keywords($video->transcript);

        $video->save();

        foreach ($tags as $tagName) {
            $tag = \App\Models\Tag::firstOrCreate(['name' => $tagName]);
            $video->tags()->syncWithoutDetaching([$tag->id]);
        }

        return response()->json([
            'video' => $video,
            'tags' => $tags
        ]);
    }

}
