<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;

class FilterController extends Controller
{
    public function filter()
    {
        $tags = Tag::whereNotNull('name')
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        return view('filter.filter', compact('tags'));
    }

    public function filter_result(Request $request)
    {
        $validated = $request->validate([
            'type' => 'nullable|string',
            'genres' => 'nullable|array',
            'genres.*' => 'integer|exists:tags,id',
            'progress' => 'nullable|string',
        ]);

        // クエリパラメータからtypeを取得
        $type = $request->input('type');

        // クエリパラメータから選択されたtagのIDを取得
        $selectedGenres = $request->input('genres');

        // クエリパラメータからprogressを取得
        $progress = $request->input('progress');

        // typeに基づいて投稿をフィルタリング
        $postsQuery = Post::query();

        if ($type) {
            $postsQuery->where('type', $type);
        }

        // selectedGenresに基づいて投稿をフィルタリング
        if ($selectedGenres) {
            foreach ($selectedGenres as $genre) {
                $postsQuery->whereHas('tags', function ($query) use ($genre) {
                    $query->where('tags.id', $genre);
                });
            }
        }

        // progressに基づいて投稿をフィルタリング
        if ($progress) {
            $postsQuery->whereHas('episodes', function ($query) use ($progress) {
                $query->where('progress', $progress);
            });
        }

        // フィルタリングされた投稿を取得
        $posts = $postsQuery->get();

        // タグを全て取得
        $tags = Tag::all();

        // ビューにデータを渡して表示
        return view('filter.filter-result', compact('posts', 'tags', 'progress', 'type', 'selectedGenres'));
    }
}