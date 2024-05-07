<x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
        <x-validation-errors class="mb-4" :errors="$errors" />
        <x-message :message="session('message')" />
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        @csrf
        <div class="container">
            <div class="h-100 mb-10 border-solid border-gray-400 flex flex-col sm:flex-row items-center">
                <div class="flex w-full mt-4">
                    <div class="w-24 h-24 sm:w-48 sm:h-48 overflow-hidden mr-8 flex-shrink-0">
                        {{-- アバター表示 --}}
                        <img id="avatar_preview" src="{{ $user->avatar ? $user->avatar : 'https://mangaglobe-bucket.s3.amazonaws.com/avatar/user_default.jpg' }}" class="object-contain">
                    </div>
                    <div>
                        <div class="flex flex-col">
                            <h1 class="text-2x1 sm:text-3xl font-bold break-all">
                                {{$user->name}}
                            </h1>
                            <h2 class="my-3" style="word-break: break-all;"> {{-- 長いテキストの改行 --}}
                                {{$user->profile}}
                            </h2>
                            @if ($posts->count() > 0)

                            @else
                            <p>まだ投稿がありません。</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- post一覧 -->
        <div class="container">
            <div class="flex flex-col">
                <div class="text-3xl sm:mt-4 mb2 break-all">
                    {{ $user->name }} 's Manga
                </div>
                @foreach ($posts as $post)
                <div class="flex sm:flex-row mt-8">
                    <!-- カバー -->
                    <a class="" href="{{ route('post.show', $post) }}">
                        <div class="w-28 h-auto sm:w-48 h-auto overflow-hidden mr-8 flex-shrink-0">
                            <img src="{{ $post->cover_image }}" class="w-full h-full object-cover">
                        </div>
                    </a>
                    <div class="flex flex-col overflow-y-auto" style="max-height: 180px;">
                        <!-- タイトル -->
                        <a class="" href="{{ route('post.show', $post) }}">
                            <p class="text-2xl sm:text-3xl text-gray-700 font-bold break-all">
                                {{ $post->title }}
                            </p>
                        </a>
                        <div class="flex">
                            <!-- いいねボタン -->
                            <i class="like-btn fa-heart mt-1 {{ $post->isLikedBy(Auth::user()) ? 'text-red-500 fas' : 'text-gray-500 far' }}" data-postid="{{ $post->id }}"></i>
                            <span class="{{ $post->isLikedBy(Auth::user()) ? 'text-red-500' : 'text-gray-500' }}">{{ $post->likes()->count() }}</span>
                            <!-- ビュー数 -->
                            <i class="fa-eye ml-3 mt-1 text-gray-500 fas"></i>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="{{ asset('js/like.js') }}"></script>
                        </div>
                        <!-- type -->
                        <a class="" href="{{ route('post.show', $post) }}">
                            <p class="text-lg text-gray-700 mt-3 sm:mt-6 break-all">
                                {{ $post->type }}
                            </p>
                        </a>
                        <!-- genre -->
                        <a class="" href="{{ route('post.show', $post) }}">
                            <p class="text-lg text-gray-700 mt-3 sm:mt-6 break-all">
                                @foreach($post->tags as $tag)
                                {{ $tag->name }}
                                @endforeach
                            </p>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="my-10">
            {{ $posts->links() }}
        </div>
    </div>
    </div>
</x-app-layout>