<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // クエリを取得
        $query = $request->input('query');

        // 入力の検証
        if (empty($query)) {
            throw ValidationException::withMessages([
                'query' => 'Search query is required.',
            ]);
        }

        // タイトルと本文で検索した投稿を取得
        $posts = Post::where('title', 'like', '%' . $query . '%')
            ->orWhere('body', 'like', '%' . $query . '%')
            ->paginate(10);

        // 漫画を少なくとも1つ投稿したユーザーのみを取得
        $authors = User::whereHas('posts')
            ->where('name', 'like', '%' . $query . '%')
            ->paginate(10);

        return view('search.search', compact('posts', 'authors', 'query'));
    }
}