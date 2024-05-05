<div class="w-1/7 bg-gray-200 p-4 mr-4 min-h-screen sm:w-1/6 bg-gray-200 p-4 mr-4 min-h-screen hidden sm:block">
    <ul class="text-center mt-4 text-xl">
        <li class="mb-4">
            <a href="{{ route('profile.edit') }}" class="hover:text-black {{ request()->routeIs('profile.edit') ? 'text-black' : 'text-gray-500' }}">Profile</a>
        </li>
        <li class="mb-4">
            <a href="{{ route('profile.show') }}" class="hover:text-black {{ request()->routeIs('profile.show') ? 'text-black' : 'text-gray-500' }}">Account</a>
        </li>    
        <li class="mb-4">
            <a href="{{ route('cash.index') }}" class="hover:text-black {{ request()->routeIs('cash.index') ? 'text-black' : 'text-gray-500' }}">Cash</a>
        </li>  
    </ul>
</div>