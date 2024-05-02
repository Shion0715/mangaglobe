<div>
    <div class="md:flex items-center mt-10">
        <div class="w-full flex flex-col mt-4">
            <div class="flex">
                <label for="title" class="font-semibold leading-none">Manga Title</label>
                @error('title')
                <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                @enderror
            </div>
            <div class="flex mt-4">
                <input type="text" name="title" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" value="{{ old('title', $post->title ?? '') }}" placeholder="Enter Title">
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
        <textarea name="body" class="mt-4 w-auto py-2 border border-gray-300 rounded-md" id="body" cols="30" rows="5">{{ old('body', $post->body ?? '') }}</textarea>
    </div>

    <div class="w-full flex flex-col mt-10">
        <div class="flex">
            @if(isset($post) && $post->cover_image)
            <img src="{{ asset('storage/cover_images/' . $post->cover_image) }}" alt="Cover Image">
            @endif
            @error('cover_image')
            <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
            @enderror
        </div>
        <div>
            <input class="mt-4" id="cover_image" type="file" name="cover_image" value="{{ old('cover_image', $post->cover_image ?? '') }}">
            <input type="hidden" id="cropped_image" name="cropped_image">
        </div>
        <img id="cover_image_preview" src="">
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
                <input id="type1" type="radio" value="shonen" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('type', $post->type ?? '') == 'shonen' ? 'checked' : '' }}>
                <label for="type1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Shonen</label>
            </div>
            <!-- 省略 -->
        </div>
    </div>

    <div>
        <div class="mt-10 font-semibold leading-none">Genre (action,fantasy,sports, etc)</div>
        <div class="flex mt-4">
            @php
            $oldTags = old('tags', isset($post) ? $post->tags->pluck('name')->toArray() : []);
            @endphp
            @for ($i = 0; $i < 5; $i++) <input type="text" name="tags[]" id="tags{{ $i }}" class="w-32 h-8 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-300 mr-4" value="{{ $oldTags[$i] ?? '' }}">
                @endfor
        </div>
    </div>

    <div class="w-full flex flex-col mt-10">
        <div class="flex">
            <div class="font-semibold leading-none">Progress</div>
            @error('progress')
            <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
            @enderror
        </div>
        <div class="flex mt-4">
            <div class="flex items-center mr-4">
                <input id="progress1" type="radio" value="continued" name="progress" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('progress', $post->progress ?? '') == 'continued' ? 'checked' : '' }}>
                <label for="progress1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Continued</label>
            </div>
            <!-- 省略 -->
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
                <input id="recieve_comment1" type="radio" value="yes" name="recieve_comment" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('recieve_comment', $post->recieve_comment ?? '') == 'yes' ? 'checked' : '' }}>
                <label for="recieve_comment1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
            </div>
            <!-- 省略 -->
        </div>
    </div>
</div>