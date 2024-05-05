<x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
    </x-slot>

    {{-- 投稿一覧表示用のコード --}}

    <x-ranking-header />

    <div class="max-w-full mx-auto mb-10 px-4 sm:px-6 lg:px-8">
        <div class="mx-0">
            <div class="mt-4">
                <div class="container">
                    <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($all_ranking as $index => $post)
                        <div class="flex flex-col item-center mt-1 m-3 mx-auto">
                            <!-- 番号 -->
                            <span class="text-sm text-gray-500 text-xl font-bold mb-1">{{ $index + 1 }}</span>
                            <!-- cover image -->
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
                                    <img id="avatar_preview" src="{{ $post->user->avatar != 'user_default.jpg' ? $post->user->avatar : asset('storage/avatar/user_default.jpg') }}" class="object-contain">
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