<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'avatar' => ['image', 'max:1024'],
            'profile' => ['nullable', 'string', 'max:200'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'notify' => ['nullable'], 
        ]);

        // userテーブルのデータ
        $attr = [
            'name' => $request->name,
            'email' => $request->email,
            'profile' => $request->profile,
            'password' => Hash::make($request->password),
            'notify' => $request->has('notify'), 
        ];

        // avatarの保存
        if (preg_match('/^data:image\/(\w+);base64,/', request('cropped_avatar'), $type)) {
            $data = substr(request('cropped_avatar'), strpos(request('cropped_avatar'), ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }

            $data = base64_decode($data);

            if ($data === false) {
                throw new \Exception('base64_decode failed');
            }

            // ユーザーIDを使用して画像を一意に命名
            $name = 'avatar/' . Str::random(10) . '_' . date('Ymd_His') . '.' . $type;

            // Google Cloud Storageに画像をアップロード
            $storage = new StorageClient([
                'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
                'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE'),
            ]);

            $bucket = $storage->bucket('mangaglobe');
            $bucket->upload(
                $data,
                [
                    'name' => $name,
                    'uniformBucketLevelAccess' => true
                ]
            );

            // 画像の公開URLを取得
            $attr['avatar'] = "https://storage.googleapis.com/laravel-project/" . $name;
        }

        $user = User::create($attr);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}