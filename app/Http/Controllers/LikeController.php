<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, Post $post)
    {
        // ユーザーがログインしているかを確認
        if (Auth::check()) {
            $user = Auth::user();

            // メール認証が完了しているかを確認
            if ($user->email_verified_at) {
                $existingLike = Like::where('user_id', $user->id)
                    ->where('post_id', $post->id)
                    ->first();

                if (!$existingLike) {
                    $post->likes()->create([
                        'user_id' => $user->id,
                    ]);
                }

                return response()->json([
                    'message' => 'Liked successfully',
                    'likes_count' => $post->likes()->count(),
                ]);
            } else {
                return response()->json([
                    'error' => 'Email not verified',
                ], 403); // メール認証が完了していない場合はエラーを返す
            }
        } else {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401); // ログインしていない場合はエラーを返す
        }
    }

    public function unlike(Request $request, Post $post)
    {
        // ユーザーがログインしているかを確認
        if (Auth::check()) {
            $user = Auth::user();

            // メール認証が完了しているかを確認
            if ($user->email_verified_at) {
                $like = Like::where('user_id', $user->id)
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
            } else {
                return response()->json([
                    'error' => 'Email not verified',
                ], 403); // メール認証が完了していない場合はエラーを返す
            }
        } else {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401); // ログインしていない場合はエラーを返す
        }
    }
}
