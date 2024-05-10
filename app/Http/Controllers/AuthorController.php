<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\PostRanking;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Post $post, User $user)
    {
            $posts = $user->posts()->paginate(5);

            $postTotalPageViewCount = PostRanking::where('page', 'LIKE', '/post/' . $post->id . '/chapter/%')
            ->sum('page_view_count');

            return view('author.author', compact('user', 'posts', 'postTotalPageViewCount'));
    }
}