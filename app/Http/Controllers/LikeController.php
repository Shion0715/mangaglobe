<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, Post $post)
    {
        $existingLike = Like::where('user_id', $request->user()->id)
            ->where('post_id', $post->id)
            ->first();

        if (!$existingLike) {
            $post->likes()->create([
                'user_id' => $request->user()->id,
            ]);
        }

        return response()->json([
            'message' => 'Liked successfully',
            'likes_count' => $post->likes()->count(),
        ]);
    }

    public function unlike(Request $request, Post $post)
    {
        $like = Like::where('user_id', $request->user()->id)
            ->where('post_id', $post->id)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            return response()->json([
                'message' => 'Like not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Unliked successfully',
            'likes_count' => $post->likes()->count(),
        ]);
    }
}