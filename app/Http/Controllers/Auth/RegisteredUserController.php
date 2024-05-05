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
use Illuminate\Support\Str;
use Aws\S3\S3Client;

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
        $attr = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile' => $request->profile,
            'notify' => $request->has('notify') ? 1 : 0,
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

            // Amazon S3に画像をアップロード
            $s3 = new S3Client([
                'version' => 'latest',
                'region'  => env('AWS_DEFAULT_REGION'),
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            $s3->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $name,
                'Body'   => $data,
                'ContentType' => 'image/' . $type // コンテンツタイプの設定
            ]);

            // 画像の公開URLを取得
            $attr['avatar'] = $s3->getObjectUrl(env('AWS_BUCKET'), $name);
        }

        $user = User::create($attr);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
