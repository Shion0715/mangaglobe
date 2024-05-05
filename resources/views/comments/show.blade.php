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
                <div class="flex items-center">
                    <!-- Replace with user avatar -->
                    <img class="h-7 w-7 sm:h-9 sm:w-9" src="{{ $comment->user->avatar != 'user_default.jpg' ? $comment->user->avatar : asset('storage/avatar/user_default.jpg') }}">
                    <h3 class="text-md sm:text-base ml-2 sm:ml-3 leading-6 font-medium text-gray-900">{{ $comment->user->name }}</h3>
                    <p class="text-xs sm:text-sm ml-2 sm:ml-3 mt-1 leading-6 font-medium text-gray-500">{{ $comment->id }}</p>
                </div>
                <p class="mt-2 text-sm sm:text-base text-gray-800 break-words">{{ $comment->body }}</p>
                <div class="mt-2 flex justify-end">
                    <!-- Report button -->
                    <a href="{{ route('report_create') }}" class="text-xs mt-1 sm:text-sm text-blue-500 hover:text-blue-700">
                        <i class="fas fa-flag"></i> Report
                    </a>
                    <!-- Delete button (visible to the author of the comment or the post) -->
                    @if (Auth::id() == $comment->user_id || Auth::id() == $post->user_id)
                    <form action="{{ route('comment.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs sm:text-sm ml-2 text-red-500 hover:text-red-700">
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