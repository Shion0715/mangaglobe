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

        // Initialize variables to hold the total, this week, this month, and today's page view counts for all posts
        $totalPageViewCount = 0;
        $thisWeekPageViewCount = 0;
        $thisMonthPageViewCount = 0;
        $todayPageViewCount = 0;

        // Iterate over each post to calculate and store the total page view count
        foreach ($posts as $post) {
            $totalPageViewCount += TotalViewCount::where('post_id', $post->id)->sum('view_count');
            $thisWeekPageViewCount += TotalViewCount::where('post_id', $post->id)->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('view_count');
            $thisMonthPageViewCount += TotalViewCount::where('post_id', $post->id)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('view_count');
            $todayPageViewCount += TotalViewCount::where('post_id', $post->id)->whereDate('created_at', today())->sum('view_count');
        }

        return view('workspace.workspace', compact('posts', 'user', 'comments', 'likesTotal', 'likesToday', 'likesThisWeek', 'likesThisMonth', 'totalPageViewCount', 'thisWeekPageViewCount', 'thisMonthPageViewCount', 'todayPageViewCount'));
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
            $postTotalPageViewCount = TotalViewCount::where('post_id', $post->id)
                ->sum('view_count');

            // Store the total page view count in the array using the post ID as the key
            $postTotalPageViewCounts[$post->id] = $postTotalPageViewCount;
        }

        return view('workspace.mymanga', compact('posts', 'postTotalPageViewCounts'));
    }
}
