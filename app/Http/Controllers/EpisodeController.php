<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Post;
use App\Models\TotalViewCount;
use Illuminate\Support\Facades\Cookie;
use App\Models\EpImage;
use Illuminate\Http\Request;
use Aws\S3\S3Client;
use App\Rules\UniqueEpisodeNumber;
use Illuminate\Validation\Rule;


class EpisodeController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort');

        $post = Post::find($request->post);

        $episodes = Episode::where('post_id', $post->id);

        if ($sort == 'new') {
            $episodes->orderByDesc('created_at');
        } elseif ($sort == 'old') {
            $episodes->orderBy('created_at');
        }

        $episodes = $episodes->get();

        $chapterPageViewCounts = TotalViewCount::where('page_path', 'LIKE', '%/post/' . $post->id . '/chapter/%')
            ->get()
            ->groupBy(function ($item) use ($post) {
                $pattern = '/\/post\/' . $post->id . '\/chapter\/(\d+)/';
                preg_match($pattern, $item->page_path, $matches);
                return $matches[1] ?? '';
            })
            ->map(function ($group) {
                return $group->sum('view_count');
            });

        return view('episode.index', compact('episodes', 'post', 'chapterPageViewCounts'));
    }

    public function create(Post $post)
    {
        $latestEpisodeNumber = Episode::where('post_id', $post->id)->max('number') ?? 0;
        $episode_number = $latestEpisodeNumber + 1;

        return view('episode.create', compact('post', 'episode_number'));
    }

    public function store(Post $post, Request $request)
    {
        if ($post->user_id !== auth()->user()->id) {
            return back()->with('error', 'You do not have permission to edit this post');
        }

        $messages = [
            'ep_title.required' => 'This field is required',
            'ep_title.max' => 'This field is in 50 words or less',
            'ep_cover_image.required' => 'Please select the image',
            'ep_cover_image.image' => 'Please select the image',
            'images.*.required' => 'Image upload is required',
            'images.*.image' => 'Uploaded file must be an image',
            'images.*.mimes' => 'Image must be of type png, jpg, or jpeg',
            'progress.required' => 'Please check the button',
            'episode_number.required' => 'Episode number is required',
            'episode_number.numeric' => 'Episode number must be an number',
            'episode_number.unique' => 'This episode already exists',
        ];

        $request->validate([
            'ep_title' => 'required|max:50',
            'ep_cover_image' => 'required|image',
            'images' => 'required',
            'images.*' => 'required|image|mimes:png,jpg,jpeg',
            'progress' => 'required',
            'episode_number' => [
                'required',
                'numeric',
                Rule::unique('episodes', 'number')->where(function ($query) use ($post) {
                    return $query->where('post_id', $post->id);
                }),
            ],
        ], $messages);

        // Episode レコードの保存
        $episode = new Episode();
        $episode->post_id = $post->id;
        $episode->title = $request->input('ep_title');
        $episode->user_id = auth()->user()->id;
        $episode->progress = $request->input('progress');
        $episode->number = $request->input('episode_number');

        // カバー画像の保存
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
        if (request('cropped_ep_cover_image')) {
            if (preg_match('/^data:image\/(\w+);base64,/', request('cropped_ep_cover_image'), $type)) {
                $data = substr(request('cropped_ep_cover_image'), strpos(request('cropped_ep_cover_image'), ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif
                if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                    throw new \Exception('invalid image type');
                }
                $data = base64_decode($data);
                if ($data === false) {
                    throw new \Exception('base64_decode failed');
                }
                $name = date('Ymd_His') . '.' . $type;
                // Amazon S3に画像をアップロード
                $result = $s3->putObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key'    => 'ep_cover_images/' . $name,
                    'Body'   => $data,
                ]);
                // Get the public URL of the uploaded file
                $episode->cover_image = $result['ObjectURL'];
            } else {
                return back()->with('error', 'Invalid image format');
            }
        } else {
            $episode->cover_image = request('old_ep_cover_image');
        }
        $episode->save();


        // Episode Imageの保存
        $epImages = [];
        $episodeNumber = $request->input('episode_number');
        // 画像の順序情報を取得
        $imageOrder = explode(',', $request->input('image_order'));
        // Create an Amazon S3 client
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageName = date('Ymd_His') . '_' . $image->getClientOriginalName();

                // Amazon S3に画像をアップロード
                $result = $s3->putObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key'    => 'ep_images/' . $imageName,
                    'Body'   => file_get_contents($image->getRealPath()),
                    'ContentType' => $image->getMimeType()
                ]);

                $imageURL = $result['ObjectURL'];

                $epImages[] = [
                    'image' => $imageURL,
                    'episode_id' => $episode->id, // Episode レコードの ID を関連付ける
                    'episode_number' => $episodeNumber,
                    'number' => array_search($image->getClientOriginalName(), $imageOrder), // 順序情報を追加
                ];
            }
        }
        foreach ($epImages as $epImage) {
            EpImage::create($epImage);
        }


        return redirect()->route('mymanga')->with('message', 'Chapter created successfully');
    }

    public function show(Post $post, $number)
    {
        // 新しい投稿IDを配列に追加
        $postIds = collect(json_decode(request()->cookie('post_ids', '[]')))->push($post->id)->toArray();

        // 配列をJSON文字列に変換してCookieに保存する
        $cookie = cookie('post_ids', json_encode($postIds), 20160);

        $episode = Episode::where('post_id', $post->id)
            ->where('number', $number)
            ->first();

        // 次のエピソードが存在するかどうかを判断
        $nextEpisodeExists = Episode::where('post_id', $post->id)
            ->where('number', '>', $number)
            ->exists();

        if (!$episode) {
            abort(404);
        }

        // EpImages テーブルから episode_number が一致するレコードを取得
        $ep_images = EpImage::where('episode_id', $episode->id)->get();

        return response()->view('post.episode', compact('ep_images', 'episode', 'post', 'nextEpisodeExists'))->cookie($cookie);
    }

    public function navigate(Post $post, $number, Request $request)
    {
        $direction = $request->input('direction');

        if ($direction === 'next') {
            // 次のエピソードを検索
            $newEpisode = Episode::where('post_id', $post->id)
                ->where('number', '>', $number)
                ->orderBy('number', 'asc')
                ->first();
        } else {
            // 前のエピソードを検索
            $newEpisode = Episode::where('post_id', $post->id)
                ->where('number', '<', $number)
                ->orderBy('number', 'desc')
                ->first();
        }

        if ($newEpisode) {
            return redirect()->route('episode.show', ['post' => $post->id, 'number' => $newEpisode->number]);
        } else {
            return back()->with('error', 'No more episodes.');
        }
    }

    public function index_edit(Post $post)
    {
        // Get episodes related to the specific post
        $episodes = $post->episodes()
            ->orderBy('number', 'asc')
            ->paginate(8);

        // Pass the episodes to the view
        return view('episode.index_edit', compact('episodes', 'post'));
    }

    public function edit(Post $post, Episode $episode, Request $request)
    {
        if ($request->user()->cannot('update', $episode)) {
            abort(403);
        }

        return view('episode.edit', compact('post', 'episode'));
    }

    public function update(Post $post, Episode $episode, Request $request)
    {
        if ($request->user()->cannot('update', $episode)) {
            abort(403);
        }

        if ($episode->user_id !== auth()->user()->id) {
            return back()->with('error', 'You do not have permission to edit this episode');
        }

        $messages = [
            'ep_title.required' => 'This field is required',
            'ep_title.max' => 'This field is in 50 words or less',
            'ep_cover_image.image' => 'Please select the image',
            'images.*.required' => 'Image upload is required',
            'images.*.image' => 'Uploaded file must be an image',
            'images.*.mimes' => 'Image must be of type png, jpg, or jpeg',
            'progress.required' => 'Please check the button',
            'episode_number.required' => 'Episode number is required',
            'episode_number.numeric' => 'Episode number must be an number',
        ];

        $request->validate([
            'ep_title' => 'required|max:50',
            'ep_cover_image' =>  'sometimes|image',
            'images' => 'required',
            'images.*' => 'required|image|mimes:png,jpg,jpeg',
            'progress' => 'required',
            'episode_number' =>  'required|numeric',
        ], $messages);

        // Episode レコードの更新
        $episode->title = $request->input('ep_title');
        $episode->progress = $request->input('progress');
        $episode->number = $request->input('episode_number');


        // カバー画像の保存
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
        if (preg_match('/^data:image\/(\w+);base64,/', request('cropped_ep_cover_image'), $type)) {
            $data = substr(request('cropped_ep_cover_image'), strpos(request('cropped_ep_cover_image'), ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }

            $data = base64_decode($data);

            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }

            $name = date('Ymd_His') . '.' . $type;

            // Amazon S3に画像をアップロード
            $result = $s3->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => 'ep_cover_images/' . $name,
                'Body'   => $data,
            ]);

            // Get the public URL of the uploaded file
            $episode->cover_image = $result['ObjectURL'];
        } else {
            $episode->cover_image = request('old_ep_cover_image');
        }

        $episode->save();


        // エピソードの画像を更新
        // 既存の画像を削除
        $epImages = $episode->ep_images;
        foreach ($epImages as $epImage) {
            // Amazon S3から画像を削除
            $s3->deleteObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $epImage->image
            ]);

            // データベースからEpImageレコードを削除
            $epImage->delete();
        }

        // 新しい画像のアップロードと保存
        $epImages = [];
        $episodeNumber = $request->input('episode_number');
        // 画像の順序情報を取得
        $imageOrder = explode(',', $request->input('image_order'));
        // 既存の画像のIDを取得
        $existing_images = $request->input('existing_images', []);
        // existing_images配列にない画像を削除
        $episode->ep_images()->whereNotIn('id', $existing_images)->delete();
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageName = date('Ymd_His') . '_' . $image->getClientOriginalName();

                // Amazon S3に画像をアップロード
                $result = $s3->putObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key'    => 'ep_images/' . $imageName,
                    'Body'   => file_get_contents($image->getRealPath()),
                    'ContentType' => $image->getMimeType()
                ]);

                $imageURL = $result['ObjectURL'];

                $epImages[] = [
                    'image' => $imageURL,
                    'episode_id' => $episode->id, // Episode レコードの ID を関連付ける
                    'episode_number' => $episodeNumber,
                    'number' => array_search($image->getClientOriginalName(), $imageOrder), // 順序情報を追加
                ];
            }
        }
        // 新しいEpImageレコードの作成
        foreach ($epImages as $epImage) {
            EpImage::create($epImage);
        }

        return redirect()->route('mymanga')->with('message', 'Chapter updated successfully');
    }

    public function destroy(Post $post, Episode $episode, Request $request)
    {
        if ($request->user()->cannot('delete', $episode)) {
            abort(403);
        }

        // Amazon S3の設定
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // エピソードのカバー画像を削除
        $coverImageName = str_replace($s3->getObjectUrl(env('AWS_BUCKET'), 'ep_cover_images/'), '', $episode->cover_image);
        $s3->deleteObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key'    => 'ep_cover_images/' . $coverImageName
        ]);

        // エピソードの画像を削除
        $epImages = $episode->epImages;
        if ($epImages) {
            foreach ($epImages as $epImage) {
                $imageName = str_replace($s3->getObjectUrl(env('AWS_BUCKET'), 'ep_images/'), '', $epImage->image);
                $s3->deleteObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key'    => 'ep_images/' . $imageName
                ]);
            }
        }

        // データベースからエピソードに関連する画像を削除
        $episode->ep_Images()->delete();

        // データベースからエピソードを削除
        $episode->delete();

        return redirect()->route('mymanga')->with('message', 'deleted successfully');
    }
}
