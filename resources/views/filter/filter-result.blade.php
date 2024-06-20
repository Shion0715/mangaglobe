<x-app-layout>
    <x-slot name="header">
        <x-slot name="header">
            <h2 class="font-semibold text-xl ml-2">
                @if($type)
                <span class="mr-4 text-black">Type: <span class="text-gray-500 font-light">{{ $type }}</span></span>
                @endif
                @if($progress)
                <span class="mr-4 text-black">Progress: <span class="text-gray-500 font-light">{{ $progress }}</span></span>
                @endif
                @if($selectedGenres)
                <span class="mr-4 text-black">Genre:
                    @foreach($selectedGenres as $index => $genre)
                    <span class="text-gray-500 font-light">{{ $tags->firstWhere('id', $genre)->name }}@if($index < count($selectedGenres) - 1)・@endif</span>
                            @endforeach
                    </span>
                    @endif
            </h2>
            <x-validation-errors class="mb-4" :errors="$errors" />

            <x-message :message="session('message')" />
        </x-slot>

        <div class="mx-0 mb-10 sm:p-8">
            <div class="mt-4">
                <!-- タイトルで検索結果 -->
                <div id="titleResults">
                    <div class="max-w-full px-2 sm:px-6 lg:px-8">
                        <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($posts as $post)
                            <div class="flex flex-col item-center mt-1 m-3 mx-auto">
                                <a href="{{ route('post.show', $post) }}">
                                    <img src="{{ $post->cover_image }}" class="" style="height:auto; width:200px">
                                </a>
                                <!-- タイトル -->
                                <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer float-left ranking-post-title">
                                    <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
                                </h1>
                                <div class="flex mt-3">
                                    <!-- アバター -->
                                    <div class="w-7 h-7 sm:w-9 h-9 overflow-hidden">
                                    <img id="avatar_preview" src="{{ $post->user->avatar ? asset('storage/'.$post->user->avatar) : asset('storage/avatar/user_default.jpg') }}" class="object-contain">
                                    </div>
                                    <!-- 名前 -->
                                    <h1 class="text-lg text-gray-700 font-normal hover:underline ml-2 sm:mt-2 ranking-user-name">
                                        <a href="{{ route('auther.index', ['user' => $post->user->id]) }}">{{ $post->user->name }}</a>
                                    </h1>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>