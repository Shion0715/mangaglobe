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
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $comment->user->name }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ $comment->body }}
                </p>
                <div class="mt-2 flex text-right">
                    <!-- Report button -->
                    <button class="text-xs">
                        <i class="fas fa-flag"></i> Report
                    </button>
                    <!-- Delete button (visible to the author of the comment or the post) -->
                    @if (Auth::id() == $comment->user_id || Auth::id() == $post->user_id)
                    <form action="{{ route('comment.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs ml-2">
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