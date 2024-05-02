<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Post;
use App\Models\Like;


class BookshelfController extends Controller
{
    public function top(Request $request)
    {
        // Cookieから保存されている投稿IDの配列を取得
        $postIds = json_decode(Cookie::get('post_ids', '[]'), true);

        // 投稿IDに対応する投稿を取得
        if (!empty($postIds)) {
            $posts = Post::whereIn('id', $postIds)
                ->orderByRaw('FIELD(id, ' . implode(',', $postIds) . ')')
                ->take(10)
                ->get();
        } else {
            $posts = collect();  // or any other default value
        }

        $user = auth()->user()->id;
        $likes = Like::where('user_id', auth()->user()->id)
            ->with('post')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return view('bookshelf.top', compact('user', 'likes', 'posts'));
    }

    public function favorite()
    {
        $user = auth()->user();
        if ($user) {

            $user = auth()->user()->id;
            $likes = Like::where('user_id', auth()->user()->id)->with('post')->orderBy('created_at', 'desc')->get();
            return view('bookshelf.favorite', compact('user', 'likes'));
        } else {
            // ユーザーがログインしていない場合の処理
            return view('auth.register'); // 例えば、ログインが必要なページへのリダイレクトやメッセージを表示するなど
        }
    }

    public function history()
    {
        $user = auth()->user();
        if ($user) {

            $postIds = json_decode(Cookie::get('post_ids', '[]'), true);
            $posts = Post::whereIn('id', $postIds)->get()->reverse();
            return view('bookshelf.history', compact('posts'));
        } else {
            // ユーザーがログインしていない場合の処理
            return view('auth.register'); // 例えば、ログインが必要なページへのリダイレクトやメッセージを表示するなど
        }
    }
}