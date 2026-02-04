<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_id',
        'url',
        'title',
        'channel_name',
        'thumbnail_url',
        'description',
        'transcript',
        'summary_short',
        'summary_long',
        'category',
    ];

    // Relatie met tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'video_tags');
    }

    // Relatie met users (favorieten / geschiedenis)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_videos')
            ->withPivot('is_favorite')
            ->withTimestamps();
    }
}
