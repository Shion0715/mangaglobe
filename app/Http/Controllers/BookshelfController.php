<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Post $post, User $user)
    {
           
            $posts = $user->posts()->paginate(5);

            return view('author.author', compact('user', 'posts',));
    }
}