<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
            <h2 class="mx-4">Workspace</h2>
            <div class="relative inline-block text-left sm:hidden">
                <div>
                    <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" aria-expanded="false">
                        My Manga
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <a href="{{ route('workspace') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Workspace</a>
                        <a href="{{ route('mymanga') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">My Manga</a>
                        <a href="{{ route('post.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Post Manga</a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-full mx-auto flex">

        <x-workspace-sidebar />

        <!-- メインコンテンツ -->
        <div class="w-full mb-10 sm:w-3/4">
            <div class="mx-2 sm:p-5 lg:p-8">
                @csrf
                <div class="h-100 flex flex-col justify-between py-4">
                    <div class="flex-grow">
                        @if (count($posts) == 0)
                        There are no posts yet.
                        @else
                        @foreach ($posts as $post)
                        <div class="mx-2 sm:p-">
                            <div class="flex">
                                <div class="flex-none"> <!-- Add this wrapper -->
                                    <a href="{{route('post.show', $post)}}">
                                        <img src="{{ $post->cover_image }}" class="mr-10 w-24 h-auto sm:w-40 object-contain mb-3">
                                    </a>
                                </div>
                                <div class="flex-grow flex flex-col"> <!-- Add items-start here -->

                                    <!-- スマホの場合 -->
                                    <div class="flex justify-between items-start"> <!-- Add this wrapper -->
                                        <!-- タイトル -->
                                        <a href="{{route('post.show', $post)}}">
                                            <p class="text-lg sm:text-3xl text-gray-700 font-semibold cursor-pointer sm:mb-3" style="word-break: break-all;">
                                                {{ $post->title }}
                                            </p>
                                        </a>
                                        <div class="flex sm:hidden">
                                            <div class="dropdown inline-block relative">
                                                <button class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded inline-flex items-center">
                                                    <!-- <span class="mr-1">Menu</span> -->
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0-6a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu absolute hidden right-0 text-gray-700 pt-1">
                                                    <li class=""><a class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="{{route('post.edit', $post)}}">Edit Manga</a></li>
                                                    <li class=""><a class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="{{route('episode.index_edit', $post)}}">Edit Chapter</a></li>
                                                    <li class=""><a class="bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="{{route('episode.create', $post)}}">Create</a></li>
                                                    @can('delete', $post)
                                                    <li class=""><a class="bg-red-200 hover:bg-red-400 py-2 px-4 block whitespace-no-wrap" href="{{route('post.destroy', $post->id)}}" onClick="return confirm('Are you sure you want to delete？');">Delete</a></li>
                                                    @endcan
                                                </ul>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('.dropdown button').click(function(event) {
                                                            event.stopPropagation();
                                                            $(this).next('.dropdown-menu').toggle();
                                                        });

                                                        $(document).click(function() {
                                                            $('.dropdown-menu').hide();
                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div> <!-- End of the wrapper -->

                                    <!-- Body -->
                                    <p class="text-sm sm:text-lg text-gray-800 mb-2 sm:mb-3" style="overflow-y: scroll; max-height: 100px; @media (min-width: 640px) {max-height: 200px;}">
                                        {{ $post->body }}
                                    </p>

                                    <!-- Tags -->
                                    @if($post->tags->isNotEmpty())
                                    <p class="text-sm sm:text-lg text-gray-600 mb-2 sm:mb-3">
                                        {{ implode(', ', $post->tags->pluck('name')->toArray()) }}
                                    </p>
                                    @endif

                                    <!-- Likes and Views -->
                                    <div class="flex items-center mb-2 sm:mb-3">
                                        <i class="fas fa-heart text-red-500"></i>
                                        <span class="ml-1">{{ count($post->likes) }}</span>
                                        <i class="fas fa-eye text-blue-500 ml-4"></i>
                                        <span class="ml-1">{{ $post->views }}</span>
                                    </div>

                                    <!-- PCの場合: -->
                                    <div class="hidden sm:flex">
                                        <a href="{{route('post.edit', $post)}}" class="float-right"><i class="fas fa-book"></i> Edit Manga</a>

                                        <a href="{{route('episode.index_edit', $post)}}" class="float-right ml-4"><i class="fas fa-file-alt"></i> Edit Chapter</a>

                                        <a href="{{route('episode.create', $post)}}" class="float-right ml-4"><i class="fas fa-plus-circle"></i> Post New Chapter</a>

                                        @can('delete', $post)
                                        <form id="deleteForm-{{ $post->id }}" method="post" action="{{route('post.destroy', $post->id)}}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <a href="#" class="bg-white-700 float-right ml-4 text-red-500" onClick="event.preventDefault(); if(confirm('Are you sure you want to delete？')) document.getElementById('deleteForm-{{ $post->id }}').submit();"><i class="fas fa-trash-alt"></i> Delete</a>
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