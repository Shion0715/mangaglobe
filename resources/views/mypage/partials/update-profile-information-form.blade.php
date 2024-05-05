<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <!-- Avatar -->
        <div class="mt-4">
            <x-input-label for="avatar" :value="__('Profile image (Up to 1MB, optional)')" />
            <div class="avatar-upload">
                <div class="avatar">
                    <input class="mt-1 block w-full" type='file' id="avatar" name="avatar" accept=".png, .jpg, .jpeg" :value="old('avatar')" />
                    <input type="hidden" id="cropped_image" name="cropped_avatar">
                    <label for="avatar"></label>
                </div>
                <div class="mt-4 max-w-[200px] max-h-auto overflow-hidden">
                    <img id="avatar_preview" src="{{ $user->avatar != 'user_default.jpg' ? $user->avatar : asset('storage/avatar/user_default.jpg') }}" class="object-contain">
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js"></script>
        <script src="{{ asset('js/avatar_cropper.js') }}"></script>

        <!-- Profile編集 -->
        <div>
            <x-input-label for="profile" :value="__('Profile (Please fill out only if you are posting mangas : optional)')" />
            <textarea id="profile" rows="4" name="profile" class="block p-2.5 w-full border-gray-300 rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">{{ old('profile', $user->profile) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('profile')" />
        </div>



        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>