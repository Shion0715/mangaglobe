<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
            <h2 class="mx-4">Workspace</h2>
            <div class="relative inline-block text-left sm:hidden">
                <div>
                    <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" aria-expanded="false">
                        Dashboard
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <a href="{{ route('workspace') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Dashboard</a>
                        <a href="{{ route('mymanga') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">My Manga</a>
                        <a href="{{ route('post.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Post Manga</a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="flex min-h-screen">
        <x-workspace-sidebar class="w-64 bg-gray-800 text-gray-300 min-h-screen" />
        <div class="flex-1 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Today's section -->
                <div>
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">Today</h2>
                    <div class="bg-primary rounded p-4 mb-3">
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-thumbs-up mr-2"></i>
                            <span class="text-xl">Likes: {{ $likesToday }}</span>
                        </div>
                    </div>
                    <div class="bg-success rounded p-4 mb-3">
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-eye mr-2"></i>
                            <span class="text-xl">Views: {{ $user->posts->where('created_at', '>=', now()->startOfDay())->sum('views_count') }}</span>
                        </div>
                    </div>
                </div>

                <!-- This Week's section -->
                <div>
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">This Week</h2>
                    <div class="bg-primary rounded p-4 mb-3">
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-thumbs-up mr-2"></i>
                            <span class="text-xl">Likes: {{ $likesThisWeek }}</span>
                        </div>
                    </div>
                    <div class="bg-success rounded p-4 mb-3">
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-eye mr-2"></i>
                            <span class="text-xl">Views: {{ $user->posts->where('created_at', '>=', now()->startOfWeek())->sum('views_count') }}</span>
                        </div>
                    </div>
                </div>

                <!-- This Month's section -->
                <div>
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">This Month</h2>
                    <div class="bg-primary rounded p-4 mb-3">
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-thumbs-up mr-2"></i>
                            <span class="text-xl">Likes: {{ $likesThisMonth }}</span>
                        </div>
                    </div>
                    <div class="bg-success rounded p-4 mb-3">
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-eye mr-2"></i>
                            <span class="text-xl">Views: {{ $user->posts->where('created_at', '>=', now()->startOfMonth())->sum('views_count') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Total section -->
                <div>
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">Total</h2>
                    <div class="bg-primary rounded p-4 mb-3">
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-thumbs-up mr-2"></i>
                            <span class="text-xl">Likes: {{ $likesTotal }}</span>
                        </div>
                    </div>
                    <div class="bg-success rounded p-4 mb-3">
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-eye mr-2"></i>
                            <span class="text-xl">Views: {{ $user->posts->sum('views_count') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Comments section -->
            <div class="mt-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-800 inline-block">Recent Comments</h2>
                <!-- Toggle button -->
                <button id="toggle-comments" class="ml-4 text-gray-500">Hide Comments</button>
                <div id="comments-section" class="bg-white sm:mr-4 rounded-lg shadow-md overflow-hidden">
                    @forelse ($comments as $comment)
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <img class="h-10 w-10 mr-3" src="{{ $comment->user->avatar != 'user_default.jpg' ? $comment->user->avatar : asset('storage/avatar/user_default.jpg') }}" alt="{{ $comment->user->name }}">
                            <div>
                                <p class="text-gray-800 font-bold">{{ $comment->user->name }}</p>
                                <p class="text-gray-600 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-gray-800 mt-2 overflow-ellipsis overflow-hidden break-words">{{ $comment->body }}</p>
                    </div>
                    @empty
                    <div class="p-4 text-gray-600">No recent comments.</div>
                    @endforelse
                </div>
            </div>

            <!-- JavaScript -->
            <script>
                document.getElementById('toggle-comments').addEventListener('click', function() {
                    var commentsSection = document.getElementById('comments-section');
                    var toggleButton = document.getElementById('toggle-comments');
                    if (commentsSection.style.display === 'none') {
                        commentsSection.style.display = 'block';
                        toggleButton.textContent = 'Hide Comments';
                    } else {
                        commentsSection.style.display = 'none';
                        toggleButton.textContent = 'Show Comments';
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>