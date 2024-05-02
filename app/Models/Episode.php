<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'image',
        'number',
        'cover_image',
        'user_id',
        'post_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ep_images()
    {
        return $this->hasMany(EpImage::class, 'episode_id', 'id');
    }

    public function getNumberAttribute($value)
    {
        if ($value >= 10) {
            return $value;
        }
        return '0' . $value;
    }
}