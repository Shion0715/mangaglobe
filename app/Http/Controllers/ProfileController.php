<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('mypage.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's account form.
     */
    public function show(Request $request): View
    {
        return view('mypage.account', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['cropped_avatar']); // cropped_avatarを除外
        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // アバター画像の保存
        if ($request->has('cropped_avatar')) {
            if (preg_match('/^data:image\/(\w+);base64,/', $request->input('cropped_avatar'), $type)) {
                $data = substr($request->input('cropped_avatar'), strpos($request->input('cropped_avatar'), ',') + 1);
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

                $bucket = $storage->bucket(env('GOOGLE_CLOUD_BUCKET_NAME'));
                $bucket->upload(
                    $data,
                    [
                        'name' => $name,
                        'uniformBucketLevelAccess' => true
                    ]
                );

                // 画像の公開URLを取得
                $request->user()->avatar = "https://storage.googleapis.com/" . env('GOOGLE_CLOUD_BUCKET_NAME') . "/" . $name;
            }
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'Profile updated!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('post');
    }

    public function index()
    {
        $users = User::select('id', 'name', 'email')->get(); // Only get necessary data
        return view('profile.index', compact('users'));
    }

    // public function deleteAvatar(): RedirectResponse
    // {
    //     $user = auth()->user();

    //     // アバターがデフォルトの画像ではない場合、削除します
    //     if ($user->avatar !== 'default.jpeg') {
    //         Storage::delete('public/avatar/' . $user->avatar);
    //         $user->avatar = 'default.jpeg';
    //         $user->save();
    //     }

    //     return redirect()->route('profile.edit')->with('status', 'Avatar deleted successfully');
    // }
}