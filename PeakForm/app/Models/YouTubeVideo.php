<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YouTubeVideo extends Model
{
    protected $fillable = [
        'title', 'description', 'youtube_url', 'muscle_group', 'duration', 'thumbnail_url',
    ];
}
