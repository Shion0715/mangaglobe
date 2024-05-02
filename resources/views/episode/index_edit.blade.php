<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
            <h2 class="mx-4">Edit Chapter</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($episodes as $episode)
                        <div class="border rounded-lg p-3 flex flex-col justify-between">
                            <img src="{{ $episode->cover_image }}" alt="Episode Cover Image" class="w-28 h-auto object-cover mb-4 mx-auto">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $episode->title }}</h3>
                                <p class="text-gray-500">Chapter: {{ $episode->number }}</p>
                                <p>{{ $episode->description }}</p>
                            </div>
                            <div class="flex">
                                <a href="{{ route('episode.edit', ['post' => $post->id, 'episode' => $episode->id]) }}" class="text-blue-500 mr-4"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('episode.destroy', ['post' => $post->id, 'episode' => $episode->id]) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="flex justify-center my-4">
                        {{ $episodes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>