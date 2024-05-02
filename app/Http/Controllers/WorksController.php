<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

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
        $posts = Post::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return view('workspace.mymanga', compact('posts'));
    }
}