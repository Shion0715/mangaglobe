<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\TotalViewCount;

class WorksController extends Controller
{
    public function workspace()
    {
        $user = auth()->user();
        $userId = $user->id;
        $likesTotal = $user->likes->count();
        $likesToday = $user->likes()->whereDate('created_at', today())->count();
        $likesThisWeek = $user->likes()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $likesThisMonth = $user->likes()->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $posts = Post::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        $comments = Comment::whereHas('post', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orderBy('created_at', 'desc')->take(7)->get();

        return view('workspace.workspace', compact('posts', 'user', 'comments', 'likesTotal', 'likesToday', 'likesThisWeek', 'likesThisMonth'));
    }

    public function mymanga()
    {
        $user = auth()->user();
        $userId = $user->id;

        // Get all posts for the authenticated user
        $posts = Post::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        // Initialize an array to hold post-wise total page view counts
        $postTotalPageViewCounts = [];

        // Iterate over each post to calculate and store the total page view count
        foreach ($posts as $post) {
            $postId = $post->id;

            $postTotalPageViewCount = TotalViewCount::where('page_path', 'LIKE', '/post/' . $postId . '/chapter/%')
                ->sum('view_count');

            // Store the total page view count in the array using the post ID as the key
            $postTotalPageViewCounts[$postId] = $postTotalPageViewCount;
        }

        return view('workspace.mymanga', compact('posts', 'postTotalPageViewCounts'));
    }
}
