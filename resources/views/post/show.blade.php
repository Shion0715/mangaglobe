<x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
    </x-slot>

    <div class="max-w-full mb-10 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-7">
            <div class="flex flex-col sm:flex-row">
                <!-- カバー -->
                <div class="mb-4 mx-10 sm:mb-0 flex justify-center sm:flex-none">
                    <div class="flex justify-center">
                        <img src="{{ $post->cover_image }}" class="show-cover-image">
                    </div>
                </div>
                <div class="flex flex-col space-y-5">
                    <!-- タイトル -->
                    <p class="text-2xl md:text-3xl text-gray-700 font-bold break-words">
                        <span class="text-sm text-gray-500 mr-2">Title:</span>{{ $post->title }}
                    </p>
                    <div class="flex">
                        <!-- いいねボタン -->
                        <i class="like-btn fa-heart ml-3 {{ $post->isLikedBy(Auth::user()) ? 'text-red-500 fas' : 'text-gray-500 far' }}" data-postid="{{ $post->id }}"></i>
                        <span class="{{ $post->isLikedBy(Auth::user()) ? 'text-red-500' : 'text-gray-500' }}">{{ $post->likes()->count() }}</span>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="{{ asset('js/like.js') }}"></script>
                    </div>
                    <!-- 作者 -->
                    <div class="flex mt-4">
                        <p class="mt-1">
                            <span class="text-sm text-gray-500 mr-2">Author:</span>
                        </p>
                        <div class="rounded-full w-8 h-8 sm:w-10 h-10">
                            {{-- アバター表示 --}}
                            <img src="{{ $post->user->avatar != 'user_default.jpg' ? $post->user->avatar : asset('storage/avatar/user_default.jpg') }}">
                        </div>
                        <!-- 名前 -->
                        <p class="mt-1 ml-3 break-words">
                            {{$user->name}}
                        </p>
                    </div>
                    <!-- タグ -->
                    <p class="mr-4 mt-4 break-words">
                        <span class="text-sm text-gray-500 mr-2">Genre:</span>
                        @foreach ($tags as $tag)
                        {{ $tag->name }}
                        @endforeach
                    </p>
                    <!-- ボディ -->

                    <p class="mr-4 mt-4 break-words">
                        <span class="text-sm text-gray-500 mr-2">Story:</span>
                        <span id="moreText" class="md:inline lg:inline">{{ $post->body }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="container mx-auto">
            <div class="my-5">
                <h2 class="text-2xl font-bold">Chapter <span class="text-sm">(Total Chapters: {{ $totalEpisodes }})</span></h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @forelse ($episodes as $index => $episode)
                <div class="flex sm:flex-col episode-container">
                    <div class="flex">
                        <!-- カバー -->
                        <a href="{{ route('episode.show', ['post' => $post->id, 'number' => $episode->number ]) }}">
                            <img src="{{$episode->cover_image}}" class="w-32 h-40 sm:w-auto object-contain mb-3">
                        </a>
                        <div class="flex-col ml-6">
                            <!-- 話数 -->
                            <p class="text-sm text-gray-500 mt-1">chapter{{ $episode->number }}</p>
                            <!-- タイトル -->
                            <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer" style="word-wrap: break-word; max-width: 190px;">
                                <a href="{{ route('episode.show', ['post' => $post->id, 'number' => $episode->number ]) }}">{{ $episode->title }}</a>
                            </h1>
                            <h2 class="text-sm text-gray-800 mt-3">
                                {{ $episode->created_at->format('Y-m-d')}}
                            </h2>
                            <!-- アクセス数 -->
                        </div>
                    </div>
                </div>
                @empty
                <p>
                    No chapter found
                </p>
                @endforelse
            </div>
            <!-- ページネーションリンクを追加 -->
            <div class="mt-10">
                {{ $episodes->links() }}
            </div>
        </div>

        <div class="container mx-auto">
            <div class="mt-8">
                <h2 class="text-2xl font-bold">Comments</h2>
                @forelse ($comments as $comment)
                <div class="mt-4 border-t border-gray-200 pt-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <!-- Replace with user avatar -->
                            <img class="h-10 w-10" src="{{ $user->avatar != 'user_default.jpg' ? $user->avatar : asset('storage/avatar/user_default.jpg') }}" alt="{{ $comment->user->name }}">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $comment->user->name }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 break-words">
                            {{ $comment->body }}
                        </p>
                    </div>
                </div>
                @empty
                <p class="mt-4">No comments yet.</p>
                @endforelse
                <div class="mt-4 flex justify-end">
                    <a href="{{ route('comment.show', $post) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        View All Comments
                    </a>
                </div>

                <style>
                    @media (max-width: 640px) {
                        .break-words {
                            word-break: break-word;
                        }
                    }
                </style>

                @auth
                <div class="mt-6">
                    <h2 class="text-2xl font-bold">Leave a Comment</h2>
                    @if (session('message'))
                    <div class="alert alert-success animate__animated animate__bounce">
                        {{ session('message') }}
                    </div>
                    @endif
                    @if ($post->recieve_comment == 'yes')
                    <form method="POST" action="{{ route('comment.store') }}">
                        @csrf
                        <div class="mt-4">
                            <textarea name="body" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Please comment responsibly and help maintain a positive community for all creators and fans. Report any violations to us."></textarea>
                            <input type="hidden" name='post_id' value="{{$post->id}}">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Post Comment
                            </button>
                        </div>
                    </form>
                    @else
                    <p>Comments are not allowed for this post.</p>
                    @endif
                </div>
                @else
                <div class="mt-6">
                    <h2 class="text-2xl font-bold">Leave a Comment</h2>
                    <p>You need to <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">log in</a> to post comments.</p>
                </div>
                @endauth
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $("form").on("submit", function(event) {
                            event.preventDefault();

                            var formData = $(this).serialize();
                            var form = this;
                            form.reset(); // フォームのリセット

                            $.ajax({
                                url: "{{ route('comment.store') }}",
                                type: "POST",
                                data: formData,
                                success: function(response) {
                                    alert(response.message);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>