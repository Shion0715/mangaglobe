<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|integer|exists:posts,id',
            'body' => 'required|string',
        ]);

        $inputs = request()->validate([
            'body' => 'required|max:1000',
        ]);

        $comment = Comment::create([
            'body' => $inputs['body'],
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Thank you for your comment!'], 200);
        }

        return back()->with('message', 'Thank you for your comment!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Request $request)
    {
        $order = $request->get('order', 'desc');

        $comments = $post->comments()->orderBy('created_at', $order)->paginate(15);

        return view('comments.show', compact('comments', 'post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // コメントの作者または投稿の作者である場合にのみ削除を許可
        if (Auth::id() == $comment->user_id || Auth::id() == $comment->post->user_id) {
            $comment->delete();
            return back()->with('success', 'Comment deleted successfully');
        } else {
            return back()->with('error', 'You are not authorized to delete this comment');
        }
    }
}
