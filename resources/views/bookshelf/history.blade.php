<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
            <h2 class="mx-4">Bookshelf</h2>
            <div class="relative inline-block text-left sm:hidden">
                <div>
                    <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" aria-expanded="false">
                        History
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
        <!-- サイドバー -->
        <x-bookshelf-sidebar />

        <!-- メインコンテンツ -->
        <div class="w-full mb-10 px-4 sm:px-6 lg:px-8">
            <div class="mx-0 sm:p-8">
                <div class="mt-4">
                    <div class="container">
                        <div class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($posts as $post)
                            <div class="flex flex-col item-center mt-1 m-3 mx-auto">
                                <!-- cover image -->
                                <a href="{{route('post.show', $post)}}">
                                    <img src="{{$post->cover_image}}" style="height:auto; width: 200px;">
                                </a>
                                <!-- タイトル -->
                                <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer float-left ranking-post-title">
                                    <a href="{{route('post.show', $post)}}">{{$post->title}}</a>
                                </h1>
                                <!-- 名前 -->
                                <h1 class="text-lg text-gray-700 font-nomal hover:underline cursor-pointer float-left ranking-post-name user-name">
                                    <a href="{{route('auther.index',  ['user' => $post->user->id])}}">{{ $post->user->name }}</a>
                                </h1>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>