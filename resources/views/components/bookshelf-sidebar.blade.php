<div class="w-1/7 bg-gray-200 p-4 mr-4 min-h-screen sm:w-1/6 bg-gray-200 p-4 mr-4 min-h-screen hidden sm:block">
    <ul class="text-center mt-4 text-xl">
        <li class="mb-4">
            <a href="{{ route('bookshelf.top') }}" class="hover:text-black {{ request()->routeIs('bookshelf.top') ? 'text-black' : 'text-gray-500' }}">Top</a>
        </li>
        <li class="mb-4">
            <a href="{{ route('bookshelf.favorite') }}" class="hover:text-black {{ request()->routeIs('bookshelf.favorite') ? 'text-black' : 'text-gray-500' }}">Favorites</a>
        </li>
        <li class="mb-4">
            <a href="{{ route('bookshelf.history') }}" class="hover:text-black {{ request()->routeIs('bookshelf.history') ? 'text-black' : 'text-gray-500' }}">History</a>
        </li>
    </ul>
</div>