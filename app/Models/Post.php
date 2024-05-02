<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'body',
        'user_id',
        'image',
        'cover_image',
        'type',
        'recieve_comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($user = null)
    {
        if (!$user) {
            return false;
        }

        return Like::where('user_id', $user->id)
            ->where('post_id', $this->id)
            ->exists();
    }

    public function ep_images()
    {
        return $this->hasMany(EpImage::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}