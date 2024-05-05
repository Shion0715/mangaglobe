<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Episode;
use App\Models\User;
use App\Models\Like;
use App\Models\EpImage;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Aws\S3\S3Client;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;
use Google\Cloud\Storage\StorageClient;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $new_posts = Post::orderBy('created_at', 'desc')->take(10)->get();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $like_posts = Post::withCount('likes')
            ->whereHas('likes', function ($query) use ($startOfWeek, $endOfWeek) {
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            })
            ->orderBy('likes_count', 'desc')
            ->take(10)
            ->get();
        $user = auth()->user();
        return view('post.index', compact('like_posts', 'new_posts', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'title.required' => 'This field is required',
            'title.max' => 'This field is in 50 words or less',
            'body.required' => 'This field is required',
            'body.max' => 'This field is in 500 words or less',
            'cover_image.required' => 'Please select the image',
            'cover_image.image' => 'Please select the image',
            'type.required' => 'This field is required',
            'tags.*.max' => 'Each tag must be 15 characters or less',
            'target_age.required' => 'Please check the button',
            'recieve_comment.required' => 'Please check the button',
        ];

        $inputs = $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:500',
            'cover_image' => 'required|image',
            'type' => 'required',
            'tags.*' => 'max:15',
            'target_age' => 'required',
            'recieve_comment' => 'required',
        ], $messages);
        $post = new Post();
        $post->title = $inputs['title'];
        $post->body = $inputs['body'];

        if (preg_match('/^data:image\/(\w+);base64,/', request('cropped_image'), $type)) {
            $data = substr(request('cropped_image'), strpos(request('cropped_image'), ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }

            $data = base64_decode($data);

            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }

            $name = date('Ymd_His') . '.' . $type;

            // Create an Amazon S3 client
            $s3 = new S3Client([
                'version' => 'latest',
                'region'  => env('AWS_DEFAULT_REGION'),
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // Upload the file to the bucket
            $result = $s3->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => 'cover_images/' . $name,
                'Body'   => $data,
            ]);
            // Get the public URL of the uploaded file
            $post->cover_image = $result['ObjectURL'];
        } else {
            return back()->with('error', 'Invalid image format');
        }

        $post->type = $inputs['type'];
        $post->target_age = $inputs['target_age'];
        $post->recieve_comment = $inputs['recieve_comment'];
        $post->user_id = auth()->user()->id;
        $post->save();

        $tagNames = $request->input('tags', []); // タグ名の配列を取得

        // タグが選択されている場合
        if (!empty($tagNames)) {
            $tags = [];

            // タグが存在するか確認し、存在しない場合は新しく作成
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) { // タグ名が空でないことを確認
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $tags[] = $tag->id;
                }
            }

            // 投稿にタグを紐付ける
            if (!empty($tags)) { // タグが存在する場合のみ紐付け
                $post->tags()->sync($tags);
            }
        }

        return redirect()->route('episode.create', $post)->with('message', 'Manga created successfully. Let\'s post Chapter 1 next!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Episode $episode)
    {
        $posts = Post::all()->map(function ($post) {
            $post->isLiked = $post->likes->contains('user_id', auth()->id());
            return $post;
        });

        $totalEpisodes = $post->episodes->count();

        // 特定の投稿に対しても「いいね」の状態を設定
        $post->isLiked = $post->likes->contains('user_id', auth()->id());

        $user = $post->user;
        $tags = $post->tags;
        $epImage = EpImage::all();
        $episodes = Episode::where('post_id', $post->id)
            ->orderBy('number', 'asc')
            ->paginate(8);

        $comments = Comment::where('post_id', $post->id)->orderBy('created_at', 'desc')->take(5)->get();

        return view('post.show', compact('posts', 'post', 'episodes', 'epImage', 'user', 'tags', 'comments', 'totalEpisodes'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (auth()->user()->cannot('update', $post)) {
            abort(403);
        }

        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */

    //  ラジオボタンと表紙画像の項目を追加して
    public function update(Request $request, Post $post)
    {
        if ($request->user()->cannot('update', $post)) {
            abort(403);
        }

        $messages = [
            'title.required' => 'This field is required',
            'title.max' => 'This field is in 50 words or less',
            'body.required' => 'This field is required',
            'body.max' => 'This field is in 500 words or less',
            'cover_image.image' => 'Please select the image',
            'type.required' => 'This field is required',
            'target_age.required' => 'Please check the button',
            'recieve_comment.required' => 'Please check the button',
        ];


        $inputs = $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:500',
            'cover_image' => 'sometimes|image',
            'type' => 'required',
            'target_age' => 'required',
            'recieve_comment' => 'required',
        ], $messages);

        $post->title = $inputs['title'];
        $post->body = $inputs['body'];
        if (preg_match('/^data:image\/(\w+);base64,/', request('cropped_image'), $type)) {
            $data = substr(request('cropped_image'), strpos(request('cropped_image'), ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }

            $data = base64_decode($data);

            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }

            $name = date('Ymd_His') . '.' . $type;

            // Create a Google Cloud Storage client
            $storage = new StorageClient([
                'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
                'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE'),
            ]);

            // Get the bucket
            $bucket = $storage->bucket(env('GOOGLE_CLOUD_BUCKET_NAME'));

            // Upload the file to the bucket
            $bucket->upload(
                $data,
                ['name' => 'cover_images/' . $name]
            );

            // Get the public URL of the uploaded file
            $post->cover_image = 'https://storage.googleapis.com/' . env('GOOGLE_CLOUD_BUCKET_NAME') . '/cover_images/' . $name;
        } else {
            return back()->with('error', 'Invalid image format');
        }
        $post->type = $inputs['type'];
        $post->target_age = $inputs['target_age'];
        $post->recieve_comment = $inputs['recieve_comment'];
        $post->user_id = auth()->user()->id;
        $post->save();

        $tagNames = $request->input('tags', []); // タグ名の配列を取得

        // タグが選択されている場合
        if (!empty($tagNames)) {
            $tags = [];

            // タグが存在するか確認し、存在しない場合は新しく作成
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tags[] = $tag->id;
            }

            // 投稿にタグを紐付ける
            $post->tags()->sync($tags);
        }

        return redirect()->route('mymanga', $post)->with('message', 'edit successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);

        if ($request->user()->cannot('delete', $post)) {
            abort(403);
        }

        $user = auth()->user();

        // 投稿が存在し、現在のユーザーがその投稿の作者であることを確認
        if (!$post->exists || $post->user->id !== $user->id) {
            return redirect()->route('mymanga')->with('error', 'You are not authorized to delete this post.');
        }

        $storage = new StorageClient([
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
            'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE'),
        ]);
        $bucket = $storage->bucket(env('GOOGLE_CLOUD_BUCKET_NAME'));
        $objectName = 'cover_images/' . basename($post->cover_image);
        $object = $bucket->object($objectName);
        $object->delete();

        foreach ($post->episodes as $episode) {
            $episode->ep_images()->where('post_id', $post->id)->delete();
        }

        $post->episodes()->delete();
        $post->comments()->delete();
        $post->delete();

        return redirect()->route('mymanga')->with('message', 'deleted successfully');
    }

    public function mypost()
    {
        $user = auth()->user()->id;
        $posts = Post::where('user_id', $user)->orderBy('created_at', 'desc')->get();
        return view('post.mypost', compact('posts'));
    }

    public function mycomment()
    {
        $user = auth()->user()->id;
        $comments = Comment::where('user_id', $user)->orderBy('created_at', 'desc')->get();
        return view('post.mycomment', compact('comments'));
    }


    public function new_post()
    {
        $new_posts = Post::orderBy('created_at', 'desc')->take(50)->get();
        return view('post.new_post', compact('new_posts'));
    }
}
