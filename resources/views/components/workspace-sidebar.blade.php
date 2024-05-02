<div class="w-1/7 bg-gray-200 p-4 mr-4 min-h-screen sm:w-1/6 bg-gray-200 p-4 mr-4 min-h-screen hidden sm:block">
    <ul class="text-center mt-4 text-xl">
        <li class="mb-4">
            <a href="{{ route('workspace') }}" class="hover:text-black {{ request()->routeIs('workspace') ? 'text-black' : 'text-gray-500' }}">Dashboard</a>
        </li>
        <li class="mb-4">
            <a href="{{ route('mymanga') }}" class="hover:text-black {{ request()->routeIs('mymanga') ? 'text-black' : 'text-gray-500' }}">My Manga</a>
        </li>
        <li class="mb-4">
            <a href="{{ route('post.create') }}" class="hover:text-black {{ request()->routeIs('post.create') ? 'text-black' : 'text-gray-500' }}">Post Manga</a>
        </li>
    </ul>
</div>