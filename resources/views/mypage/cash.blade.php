<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
            <h2 class="mx-4">My Page</h2>
            <div class="relative inline-block text-left sm:hidden">
                <div>
                    <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" aria-expanded="false">
                        Account
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="origin-top-right absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Profile</a>
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Account</a>
                    </div>
                </div>
            </div>
            <x-message :message="session('message')" />
        </div>
    </x-slot>

    <div class="max-w-full mx-auto flex">
        <x-mypage-sidebar class="w-64 bg-gray-800 text-gray-300 min-h-screen" />

        <div class="p-6">
            <div class="text-2xl font-bold mb-4">Your Points: </div>
            <div> class="text-blue-500 underline">Apply for Points</div>

            <div class="mt-8">
                <h3 class="text-xl font-bold mb-2">View Statistics</h3>
                <p>This Month: </p>
                <p>Last Month: </p>

            </div>
        </div>
    </div>

</x-app-layout>