<x-app-layout>
    <x-slot name="header">
        <h2 class="ml-2 font-semibold text-xl text-gray-800 leading-tight">
            All Chapters
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-2 sm:py-16 sm:px-4 lg:max-w-6xl lg:px-6">

        <div class="mx-2 mt-4 grid grid-cols-2 gap-y-6 gap-x-8 md:grid-cols-3 lg:grid-cols-5 xl:gap-x-10">
            @forelse ($episodes as $episode)
            <div class="group relative">
                <div class="w-full min-h-48 bg-gray-200 overflow-hidden group-hover:opacity-75 lg:aspect-w-7 lg:aspect-h-5">
                    <img src="{{ $episode->cover_image }}" alt="{{ $episode->title }}" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                </div>
                <div class="mt-2">
                    <div class="flex justify-between items-center">
                        <div class="bg-gray-100 rounded-full py-1 text-xs text-gray-600">Chapter {{ $episode->number }}</div>
                        <p class="text-xs text-gray-500">{{ $episode->created_at->format('M d, Y') }}</p>
                    </div>
                    <h3 class="text-sm font-medium text-gray-900 mt-1 break-words">
                        <a href="{{ route('episode.show', ['post' => $post->id, 'number' => $episode->number ]) }}">
                            <span aria-hidden="true" class="absolute inset-0"></span>
                            {{ $episode->title }}
                        </a>
                    </h3>
                </div>
            </div>
            @empty
            <p>No chapters found.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>