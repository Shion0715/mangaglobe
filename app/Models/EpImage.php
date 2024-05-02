<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'image',
        'episode_id',
        'number',
        'episode_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
