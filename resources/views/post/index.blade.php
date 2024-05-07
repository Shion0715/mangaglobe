<x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
    </x-slot>

    {{-- 投稿一覧表示用のコード --}}
    <div class="max-w-full mx-auto mb-10">
        <div class="mx-0 sm:p-8">
            <div class="mt-4">
                {{-- ランキング投稿一覧 --}}
                <div class="container">
                    <div class="flex items-center justify-between mt-10">
                        <div class="text-2xl">Top Favorite This Week</div>
                    </div>
                    <div class="w-full">
                        <div class="scroll-container">
                            <div class="multiple">
                                <div class="flex">
                                    <!-- 画像のスライド -->
                                    @if(isset($like_posts))
                                    @foreach ($like_posts as $index => $post)
                                    <div class="slide">
                                        <div class="flex flex-col">
                                            <!-- ランキング番号 -->
                                            <div class="text-lg text-gray-700 font-semibold">{{$index+1}}</div>
                                            <a href="{{route('post.show', $post)}}">
                                                <img src="{{ $post->cover_image }}">
                                            </a>
                                            <!-- タイトル -->
                                            <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer  index-post-title">
                                                <a href="{{route('post.show', $post)}}">{{$post->title}}</a>
                                            </h1>
                                            <div class="flex mt-3">
                                                <!-- アバター -->
                                                <div class="w-7 h-7 sm:w-9 h-9 overflow-hidden">
                                                    <img id="avatar_preview" src="{{ $post->user->avatar ? $post->user->avatar : 'https://mangaglobe-bucket.s3.amazonaws.com/avatar/user_default.jpg' }}" class="object-contain">
                                                </div>
                                                <!-- 名前 -->
                                                <h1 class="text-lg text-gray-700 font-normal hover:underline ml-2 sm:mt-2 index-user-name">
                                                    <a href="{{route('auther.index',  ['user' => $post->user->id])}}">{{ $post->user->name }}</a>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- moreリンク --}}
                    <div class="float-right mr-5 mt-3 subpixel-antialiased text-xl">
                        <a href="{{route('ranking.daily')}}">more</a>
                    </div>
                </div>

                {{-- 新着投稿一覧 --}}
                <div class="container">
                    <div class="flex items-center justify-between mt-20">
                        <div class="text-2xl">New</div>
                    </div>
                    <div class="w-full">
                        <div class="scroll-container">
                            <div class="multiple">
                                <div class="flex">
                                    <!-- 画像のスライド -->
                                    @if(isset($new_posts))
                                    @foreach ($new_posts as $post)
                                    <div class="slide">
                                        <div class="flex flex-col">
                                            <a href="{{route('post.show', $post)}}">
                                                <img src="{{ $post->cover_image }}">
                                            </a>
                                            <!-- タイトル -->
                                            <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer  index-post-title">
                                                <a href="{{route('post.show', $post)}}">{{$post->title}}</a>
                                            </h1>
                                            <div class="flex mt-3">
                                                <!-- アバター -->
                                                <div class="w-7 h-7 sm:w-9 h-9 overflow-hidden">
                                                    <img id="avatar_preview" src="{{ $post->user->avatar ? $post->user->avatar : 'https://mangaglobe-bucket.s3.amazonaws.com/avatar/user_default.jpg' }}" class="object-contain">
                                                </div>
                                                <!-- 名前 -->
                                                <h1 class="text-lg text-gray-700 font-normal hover:underline ml-2 sm:mt-2 index-user-name">
                                                    <a href="{{route('auther.index',  ['user' => $post->user->id])}}">{{ $post->user->name }}</a>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- moreリンク --}}
                    <div class="float-right mr-5 mt-3 mb-10 subpixel-antialiased text-xl">
                        <a href="{{route('post.new_post')}}">more</a>
                    </div>
                </div>
                <!-- タイプ検索 -->
                <div class="container">

                </div>
            </div>
        </div>
    </div>
</x-app-layout>