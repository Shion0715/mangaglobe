<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Post;
use Illuminate\Support\Facades\Cookie;
use App\Models\EpImage;
use Illuminate\Http\Request;
use Google\Cloud\Storage\StorageClient;

class EpisodeController extends Controller
{
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

        $request->validate([
            'ep_title' => 'required|max:255',
            'ep_cover_image' => 'required|image',
            'images' => 'required',
            'images.*' => 'required|image|mimes:png,jpg,jpeg',
            'progress' => 'required',
            'episode_number' => 'required|integer|unique:episodes,number',
        ]);

        // Episode レコードの保存
        $episode = new Episode();
        $episode->post_id = $post->id;
        $episode->title = $request->input('ep_title');
        $episode->user_id = auth()->user()->id;
        $episode->progress = $request->input('progress');
        $episode->number = $request->input('episode_number');

        // カバー画像の保存
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

            // Save the file to local storage
            $path = storage_path('app/public/ep_cover_images/' . $name);
            file_put_contents($path, $data);

            // Get the public URL of the saved file
            $episode->cover_image = asset('storage/ep_cover_images/' . $name);
        } else {
            return back()->with('error', 'Invalid image format');
        }
        $episode->save();

        // Episode Imageの保存
        $epImages = [];
        $episodeNumber = $episode->number;

        // 画像の順序情報を取得
        $imageOrder = explode(',', $request->input('image_order'));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageName = date('Ymd_His') . '_' . $image->getClientOriginalName();

                // Save the file to local storage
                $path = storage_path('app/public/ep_images/' . $imageName);
                file_put_contents($path, file_get_contents($image->getRealPath()));

                $imageURL = asset('storage/ep_images/' . $imageName);

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
        $ep_images = EpImage::where('episode_number', $number)->get();

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

    public function edit(Post $post, Episode $episode)
    {
        $this->authorize('update', $post);

        return view('episode.edit', compact('post', 'episode'));
    }

    public function update(Post $post, Episode $episode, Request $request)
    {
        $this->authorize('update', $episode);

        if ($episode->user_id !== auth()->user()->id) {
            return back()->with('error', 'You do not have permission to edit this episode');
        }

        $request->validate([
            'ep_title' => 'required|max:255',
            'ep_cover_image' => 'required|image',
            'images' => 'required',
            'images.*' => 'required|image|mimes:png,jpg,jpeg',
            'progress' => 'required',
        ]);

        // Episode レコードの更新
        $episode->title = $request->input('ep_title');
        $episode->progress = $request->input('progress');

        // カバー画像の保存
        $storage = new StorageClient([
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
            'keyFilePath' => '/home/xs209264/xs209264.xsrv.jp/public_html/laravel_manga/storage/json/nice-beanbag-420411-68c05e2519d2.json',
        ]);

        $bucket = $storage->bucket('laravel-project');

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

            // Google Cloud Storageに画像をアップロード
            $bucket->upload(
                $data,
                [
                    'name' => 'ep_cover_images/' . $name,
                    'uniformBucketLevelAccess' => true
                ]
            );

            // Get the public URL of the uploaded file
            $episode->cover_image = 'https://storage.googleapis.com/' . env('GOOGLE_CLOUD_BUCKET_NAME') . '/ep_cover_images/' . $name;
        }

        $episode->number = $request->input('episode_number');

        $episode->save();

        $storage = new StorageClient([
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
            'keyFilePath' => '/home/xs209264/xs209264.xsrv.jp/public_html/laravel_manga/storage/json/nice-beanbag-420411-68c05e2519d2.json',
        ]);

        $bucket = $storage->bucket('laravel-project');

        $newEpImages = []; // 新しい配列を作成
        $episodeNumber = $episode->number;

        // 画像の順序情報を取得
        $imageOrder = explode(',', $request->input('image_order'));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageName = date('Ymd_His') . '_' . $image->getClientOriginalName();

                // Google Cloud Storageに画像をアップロード
                try {
                    $bucket->upload(
                        file_get_contents($image->getRealPath()),
                        [
                            'name' => 'ep_images/' . $imageName,
                            'uniformBucketLevelAccess' => true
                        ]
                    );
                } catch (\Exception $e) {
                    return back()->with('error', 'Failed to upload image.');
                }

                $imageURL = 'https://storage.googleapis.com/' . env('GOOGLE_CLOUD_BUCKET_NAME') . '/ep_images/' . $imageName;

                $newEpImages[] = [
                    'image' => $imageURL,
                    'episode_id' => $episode->id, // Episode レコードの ID を関連付ける
                    'episode_number' => $episodeNumber,
                    'number' => array_search($image->getClientOriginalName(), $imageOrder), // 順序情報を追加
                ];
            }
        }

        $epImages = $episode->ep_images;
        foreach ($epImages as $epImage) {
            // Google Cloud Storageから画像を削除
            $imagePath = str_replace('https://storage.googleapis.com/' . env('GOOGLE_CLOUD_BUCKET_NAME') . '/', '', $epImage->image);
            $bucket->object($imagePath)->delete();

            // データベースからEpImageレコードを削除
            $epImage->delete();
        }

        // 新しいEpImageレコードの作成
        foreach ($newEpImages as $epImage) {
            EpImage::create($epImage);
        }

        return redirect()->route('mymanga')->with('message', 'Chapter updated successfully');
    }

    public function destroy(Post $post, Episode $episode)
    {
        $this->authorize('delete', $episode);

        // Google Cloud Storageの設定
        $storage = new StorageClient([
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
            'keyFilePath' => '/home/xs209264/xs209264.xsrv.jp/public_html/laravel_manga/storage/json/nice-beanbag-420411-68c05e2519d2.json',
        ]);

        $bucket = $storage->bucket(env('GOOGLE_CLOUD_BUCKET_NAME'));

        // エピソードのカバー画像を削除
        $coverImageName = str_replace('https://storage.googleapis.com/' . env('GOOGLE_CLOUD_BUCKET_NAME') . '/ep_cover_images/', '', $episode->cover_image);
        $coverImageObject = $bucket->object('ep_cover_images/' . $coverImageName);
        if ($coverImageObject->exists()) {
            $coverImageObject->delete();
        }

        // エピソードの画像を削除
        $epImages = $episode->epImages;
        if ($epImages) {
            foreach ($epImages as $epImage) {
                $imageName = str_replace('https://storage.googleapis.com/' . env('GOOGLE_CLOUD_BUCKET_NAME') . '/ep_images/', '', $epImage->image);
                $imageObject = $bucket->object('ep_images/' . $imageName);
                if ($imageObject->exists()) {
                    $imageObject->delete();
                }
            }
        }

        // データベースからエピソードに関連する画像を削除
        $episode->ep_Images()->delete();

        // データベースからエピソードを削除
        $episode->delete();

        return redirect()->route('mymanga')->with('message', 'deleted successfully');
    }
}
