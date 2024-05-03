<x-app-layout>
    <x-slot name="header">
        <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">
            Works <span class="ml-4"></span>
            <x-message :message="session('message')" />
        </h2>
    </x-slot>

    <div class="max-w-full mx-auto flex">

        <x-works-sidebar />

        <!-- メインコンテンツ -->
        <div class="w-3/4">
            <div class="mx-4 sm:p-8">
                @csrf
                <div class="h-100 border border-solid border-gray-400 flex flex-col justify-between p-4">
                    <div class="flex-grow">
                        @if (count($posts) == 0)
                        There are no posts yet.
                        @else
                        @foreach ($posts as $post)
                        <div class="mx-4 sm:p-8">
                            <div class="flex">
                                <img src="{{ $post->cover_image }}" class="mr-10 row-span-3" style="height:200px; width:200px;">
                                <div class="flex flex-col">
                                    <!-- タイトル -->
                                    <p class="text-3xl text-gray-700 font-semibold cursor-pointer">
                                        {{ $post->title }}
                                    </p>
                                    <p class="my-12">
                                        何か入る
                                    </p>
                                    <div class="flex">
                                        <form method="get" action="{{route('post.edit', $post)}}">
                                            @csrf
                                            <x-primary-button class="float-right ml-4">edit</x-primary-button>
                                        </form>

                                        <form method="get" action="{{route('episode.create', $post)}}">
                                            @csrf
                                            <x-primary-button class="float-right ml-4">create</x-primary-button>
                                        </form>

                                        <form method="get" action="{{route('post.show', $post)}}">
                                            @csrf
                                            <x-primary-button class="bg-white-700 float-right ml-4">watch</x-primary-button>
                                        </form>

                                        @can('delete', $post)
                                        <form method="post" action="{{route('post.destroy', $post)}}">
                                            @csrf
                                            @method('delete')
                                            <x-primary-button class="bg-red-700 float-right ml-4" onClick="return confirm('Are you sure you want to delete？');">delete</x-primary-button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="border-gray-300 my-4">
                        @endforeach
                        @endif
                        <div class="text-center bg-gray-200 mt-20 p-4">
                            <x-nav-link :href="route('post.create')" :active="request()->routeIs('post.create')">
                                Post Manga
                            </x-nav-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>