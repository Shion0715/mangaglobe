<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\TotalViewCount;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request, User $user)
    {
        $posts = $user->posts()->paginate(5);

        $postId = $request->get('post_id'); // リクエストからpost_idを取得
        $post = Post::find($postId); // post_idを使用してPostオブジェクトを取得

        if ($post) {
            $postTotalPageViewCount = TotalViewCount::where('post_id', $post->id)
                ->sum('view_count');
        } else {
            $postTotalPageViewCount = 0; // postが見つからない場合は0を設定
        }

        return view('author.author', compact('user', 'posts', 'postTotalPageViewCount'));
    }
}
