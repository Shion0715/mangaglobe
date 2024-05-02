<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-blue-600 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl mb-5">{{ __("You're logged in!") }}</h3>
                    <p class="text-xl text-gray-500">Welcome back, we missed you!</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>