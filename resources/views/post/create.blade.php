<x-app-layout>
    <x-slot name="header">
        <h2 class="ml-2 font-semibold text-xl text-gray-800 leading-tight">
            Post New Manga
        </h2>

        <!-- validation追加 -->

        <x-message :message="session('message')" />
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-4 sm:p-8">
            <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
                @csrf

                <div class="md:flex items-center mt-10">
                    <div class="w-full flex flex-col mt-4">
                        <div class="flex">
                            <label for="title" class="font-semibold leading-none">Manga Title</label>
                            @error('title')
                            <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex mt-4">
                            <input type="text" name="title" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" value="{{old('title')}}" placeholder="Enter Title">
                        </div>
                    </div>
                </div>

                <div class="w-full flex flex-col mt-10">
                    <div class="flex">
                        <label for="body" class="font-semibold leading-none">Story</label>
                        @error('body')
                        <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                        @enderror
                    </div>
                    <textarea name="body" class="mt-4 w-auto py-2 border border-gray-300 rounded-md" id="body" cols="30" rows="5">{{old('body')}}</textarea>
                </div>

                <div class="w-full flex flex-col mt-10">
                    <div class="flex">
                        <label for="cover_image" class="font-semibold leading-none">Cover Image</label>
                        @error('cover_image')
                        <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                        @enderror
                    </div>
                    <span class="mt-2 text-sm text-gray-500">File: png,jpg,jpeg | 2MB or less </span>
                    <div>
                        <input class="mt-4" id="cover_image" type="file" name="cover_image" value="{{ old('cover_image') }}">
                        <input type="hidden" id="cropped_image" name="cropped_image">
                    </div>
                    <div class="mt-4 max-w-[200px] max-h-auto overflow-hidden">
                        <img id="cover_image_preview" src="" class="object-contain">
                    </div>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js"></script>
                <script src="{{ asset('js/cover_image_cropper.js') }}"></script>

                <div class="w-full flex flex-col mt-10">
                    <div class="flex">
                        <div class="font-semibold leading-none">Type</div>
                        @error('type')
                        <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex mt-4">
                        <div class="flex items-center mr-4">
                            <input id="type1" type="radio" value="shonen" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('type') == 'shonen' ? 'checked' : '' }}>
                            <label for="type1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Shonen</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="type2" type="radio" value="shojo" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('type') == 'shojo' ? 'checked' : '' }}>
                            <label for="type2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Shojo</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="type3" type="radio" value="seinen" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('type') == 'seinen' ? 'checked' : '' }}>
                            <label for="type3" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Seinen</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="type4" type="radio" value="josei" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('type') == 'josei' ? 'checked' : '' }}>
                            <label for="type4" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Josei</label>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="mt-10 font-semibold leading-none">Genre (action,fantasy,sports, etc)</div>
                    <div class="flex mt-4 flex-wrap">
                        @for ($i = 0; $i < 5; $i++) 
                        <input type="text" name="tags[]" id="tags{{ $i }}" class="w-32 h-8 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300 mr-4 mb-3 sm:mb-0">
                        @endfor
                    </div>
                </div>

                <div class="w-full flex flex-col mt-10">
                    <div class="flex">
                        <div class="font-semibold leading-none">Target age</div>
                        @error('Target_age')
                        <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex mt-4">
                        <div class="flex items-center mr-4">
                            <input id="target_age1" type="radio" value="Available for all ages" name="target_age" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('target_age') == '連載中' ? 'checked' : '' }}>
                            <label for="target_age1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Available for all ages</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="target_age2" type="radio" value="18+" name="target_age" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('target_age') == '完結' ? 'checked' : '' }}>
                            <label for="target_age2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">18+</label>
                        </div>
                    </div>
                </div>

                <div class="w-full flex flex-col mt-10">
                    <div class="flex">
                        <div class="font-semibold leading-none">Do you recieve comments?</div>
                        @error('recieve_comment')
                        <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex mt-4">
                        <div class="flex items-center mr-4">
                            <input id="recieve_comment1" type="radio" value="yes" name="recieve_comment" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('recieve_comment') == '受け付ける' ? 'checked' : '' }}>
                            <label for="recieve_comment1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                        </div>
                        <div class="flex items-center mr-4">
                            <input id="recieve_comment2" type="radio" value="no" name="recieve_comment" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('recieve_comment') == '受け付けない' ? 'checked' : '' }}>
                            <label for="recieve_comment2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                        </div>
                    </div>
                </div>

                <x-primary-button class="my-10">
                    Create Chapter 1
                </x-primary-button>

            </form>
        </div>
    </div>

</x-app-layout>