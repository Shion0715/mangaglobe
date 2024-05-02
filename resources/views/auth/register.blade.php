<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Avatar -->
        <div class="mt-6">
            <x-input-label for="avatar" :value="__('Profile image (Up to 1MB : optional)')" />
            <div class="avatar-upload">
                <div class="avatar-edit">
                    <input type='file' id="avatar" name="avatar" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" id="cropped_image" name="cropped_avatar">
                    <label for="avatar"></label>
                </div>
                <div class="mt-4 max-w-[200px] max-h-auto overflow-hidden">
                    <img id="avatar_preview" src="{{ asset('storage/avatar/user_default.jpg') }}" class="object-contain">
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js"></script>
        <script src="{{ asset('js/avatar_cropper.js') }}"></script>

        <!-- Profile -->
        <div class="mt-6">
            <x-input-label for="profile" :value="__('Profile (Please fill out only if you are posting mangas : optional)')" />
            <textarea id="profile" rows="4" name="profile" class="block p-2.5 w-full border-gray-300 rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" :value="old('profile')"></textarea>
        </div>

        <!-- Notify -->
        <div class="mt-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="notify" name="notify">
                <label class="form-check-label" for="notify">
                    Receive email notifications for new chapters and other important updates
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>