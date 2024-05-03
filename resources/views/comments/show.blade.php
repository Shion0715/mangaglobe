<x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
    </x-slot>

    <div class="px-4 py-5 sm:px-6 lg:px-8">
        <div class="flex items-center">
            <h2 class="text-2xl font-bold">Comments</h2>
            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ $comments->count() }}
            </span>
        </div>

        @forelse ($comments as $comment)
        <div class="mt-4 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <div class="flex">
                    <!-- Replace with user avatar -->
                    <img class="h-7 w-7 sm:h-9 sm:w-9" src="{{ $comment->user->avatar != 'user_default.jpg' ? $comment->user->avatar : asset('storage/avatar/user_default.jpg') }}">
                    <h3 class="mt-1 ml-2 sm:mt-2 text-lg leading-6 font-medium text-gray-900">
                        {{ $comment->user->name }}
                    </h3>
                    <h3 class="mt-1 ml-5 sm:mt-2 text-sm leading-6 font-medium text-gray-500">
                        {{ $comment->id}}
                    </h3>
                </div>
                <p class="mt-1 text-md text-gray-800">
                    {{ $comment->body }}
                </p>
                <div class="mt-2 flex text-right">
                    <!-- Report button -->
                    <a href="{{route('report_create')}}">
                        <button class="text-xs text-blue-500 h-7">
                            <i class="fas fa-flag"></i> Report
                        </button>
                    </a>
                    <!-- Delete button (visible to the author of the comment or the post) -->
                    @if (Auth::id() == $comment->user_id || Auth::id() == $post->user_id)
                    <form action="{{ route('comment.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs ml-2 text-red-500 h-7">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="mt-4">No comments yet.</p>
        @endforelse

        <!-- ページネーションリンクを追加 -->
        <div class="mt-4">
            {{ $comments->links() }}
        </div>
    </div>
</x-app-layout>