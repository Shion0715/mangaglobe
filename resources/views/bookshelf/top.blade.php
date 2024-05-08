<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
            <h2 class="mx-4">Bookshelf</h2>
            <div class="relative inline-block text-left sm:hidden">
                <div>
                    <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" aria-expanded="false">
                        Top
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="origin-top-right absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <a href="{{ route('bookshelf.top') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Top</a>
                        <a href="{{ route('bookshelf.favorite') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Favorite</a>
                        <a href="{{ route('bookshelf.history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">History</a>
                    </div>
                </div>
            </div>
            <x-message :message="session('message')" />
        </div>
    </x-slot>

    <div class="max-w-full mx-auto flex">

        <x-bookshelf-sidebar />

        <!-- メインコンテンツ -->
        <div class="w-full mb-10">
            <div class="mx-0 sm:p-8">
                <div class="mt-4">
                    <!-- History -->
                    <div class="container">
                        <div class="flex items-center justify-between p-1 pl-3 pr-1 mb-1">
                            <div class="col-span-12 m-0 p-0 px-1 py-0 inline-block text-2xl">
                                History
                            </div>
                        </div>
                        <div class="scroll-container">
                            <div class="multiple">
                                <div class="flex">
                                    <!-- 画像のスライド -->
                                    @foreach($posts as $post)
                                    @if($post)
                                    <div class="flex flex-col mt-1 m-3 mx-auto">
                                        <a href="{{route('post.show', $post)}}" class="mr-5">
                                            <img src="{{ $post->cover_image }}">
                                        </a>
                                        <!-- タイトル -->
                                        <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer float-left index-post-title">
                                            <a href="{{route('post.show', $post)}}">{{$post->title}}</a>
                                        </h1>
                                        <div class="flex mt-5">
                                            <div class="w-8 h-8">
                                                {{-- アバター表示 --}}
                                                <img id="avatar_preview" src="{{ $post->user->avatar ? $post->user->avatar : 'https://mangaglobe-bucket.s3.amazonaws.com/avatar/user_default.jpg' }}" class="object-contain">
                                            </div>
                                            <!-- 名前 -->
                                            <h1 class="text-lg text-gray-700 font-nomal hover:underline m-1 cursor-pointer float-left index-user-name">
                                                <a href="{{route('auther.index',  ['user' => $post->user->id])}}">{{ $post->user->name }}</a>
                                            </h1>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="float-right mr-5 mt-3 subpixel-antialiased text-xl">
                            <a href="{{route('bookshelf.history')}}">more</a>
                        </div>
                    </div>

                    <!-- Favorite -->
                    <div class="container">
                        <div class="flex items-center justify-between p-1 pl-3 pr-1 mb-1">
                            <div class="col-span-12 mt-20 px-1 inline-block text-2xl">
                                Favorite
                            </div>
                        </div>
                        <div class="scroll-container">
                            <div class="multiple">
                                <div class="flex">
                                    <!-- 画像のスライド -->
                                    @foreach($likes as $like)
                                    @if($like->post)
                                    <div class="flex flex-col mt-1 m-3 mx-auto">
                                        <a href="{{route('post.show', $like->post_id)}}" class="mr-5">
                                            <img src="{{ $like->post->cover_image }}">
                                        </a>
                                        <!-- タイトル -->
                                        <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer float-left index-post-title">
                                            <a href="{{route('post.show', $like->post_id)}}">{{$like->post->title}}</a>
                                        </h1>
                                        <div class="flex mt-5">
                                            <div class=" w-8 h-18">
                                                {{-- アバター表示 --}}
                                                <img id="avatar_preview" src="{{ $like->post->user->avatar ? $like->post->user->avatar : 'https://mangaglobe-bucket.s3.amazonaws.com/avatar/user_default.jpg' }}" class="object-contain">
                                            </div>
                                            <!-- 名前 -->
                                            <h1 class="text-lg text-gray-700 font-nomal hover:underline m-1 ml-1 sm:ml-2 cursor-pointer float-left index-user-name">
                                                <a href="{{route('auther.index',  ['user' => $like->user->id])}}">{{ \Illuminate\Support\Str::limit($like->user->name, 9) }}</a>
                                            </h1>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="float-right mr-5 mt-3 subpixel-antialiased text-xl">
                            <a href="{{route('bookshelf.favorite')}}">more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>