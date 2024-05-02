<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl ml-2 text-gray-800 leading-tight">
            Search Result : {{ $query }}
        </h2>
        <x-validation-errors class="mb-4" :errors="$errors" />

        <x-message :message="session('message')" />
    </x-slot>

    <div class="mx-0 mb-10 sm:p-8">
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <div class="col-span-12 mb-4 m-0 p-0 px-1 py-0 inline-block text-2xl w-full flex justify-center sm:justify-start sm:mb-10">
                    <!-- タイトル検索ボタン -->
                    <button id="titleButton" class="font-bold mx-2 sm:mx-4">Manga Title</button>
                    <!-- 著者検索ボタン -->
                    <button id="authorButton">Author</button>
                </div>
            </div>


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
                            <!-- 名前 -->
                            <h1 class="text-lg text-gray-700 font-nomal hover:underline cursor-pointer float-left ranking-user-name">
                                <a href="{{ route('auther.index', ['user' => $post->user->id]) }}">{{ $post->user->name }}</a>
                            </h1>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- 著者で検索結果 -->
            <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8">
                @csrf
                <div id="authorResults" style="display: none;">
                    @foreach ($authors as $author)
                    <div class="container">
                        <a href="{{route('auther.index',  ['user' => $author->id])}}" class="block mb-10 border-solid border-gray-400 flex flex-col sm:flex-row items-center">
                            <div class="flex w-full mt-4">
                                <div class="w-24 h-24 sm:w-48 sm:h-48 overflow-hidden mr-5 flex-shrink-0">
                                    {{-- アバター表示 --}}
                                    <img src="{{$author->avatar ?? 'user_default.jpg' }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="flex flex-col">
                                        <h1 class="text-2x1 sm:text-3xl font-bold break-all">
                                            {{$author->name}}
                                        </h1>
                                        <h2 class="mt-1 sm:mt-3" style="word-break: break-all;"> {{-- 長いテキストの改行 --}}
                                            {{$author->profile}}
                                        </h2>
                                        <!-- <h3>
                                twitter
                            </h3> -->
                                        @if ($posts->count() > 0)

                                        @else
                                        <p>まだ投稿がありません。</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>


            <script>
                // ページが読み込まれたときに実行
                window.addEventListener('DOMContentLoaded', function() {
                    // 初めはマンガタイトルボタンが選択されているとして、著者ボタンをグレーにする
                    document.getElementById('authorButton').style.fontWeight = 'normal';
                    document.getElementById('authorButton').style.color = '#888';
                });

                // タイトルボタンがクリックされた場合の処理
                document.getElementById('titleButton').addEventListener('click', function() {
                    document.getElementById('titleResults').style.display = 'block';
                    document.getElementById('authorResults').style.display = 'none';
                    document.getElementById('titleButton').style.fontWeight = 'bold'; // タイトルボタンを太字にする
                    document.getElementById('titleButton').style.color = '#000'; // タイトルボタンの色を黒にする
                    document.getElementById('authorButton').style.fontWeight = 'normal'; // 著者ボタンの太字を解除する
                    document.getElementById('authorButton').style.color = '#888'; // 著者ボタンの色をグレーにする
                });

                // 著者ボタンがクリックされた場合の処理
                document.getElementById('authorButton').addEventListener('click', function() {
                    document.getElementById('titleResults').style.display = 'none';
                    document.getElementById('authorResults').style.display = 'block';
                    document.getElementById('titleButton').style.fontWeight = 'normal'; // タイトルボタンの太字を解除する
                    document.getElementById('titleButton').style.color = '#888'; // タイトルボタンの色をグレーにする
                    document.getElementById('authorButton').style.fontWeight = 'bold'; // 著者ボタンを太字にする
                    document.getElementById('authorButton').style.color = '#000'; // 著者ボタンの色を黒にする
                });
            </script>

        </div>

</x-app-layout>