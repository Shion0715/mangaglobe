<x-app-layout>
    <x-slot name="header">
        @include('layouts.header')
    </x-slot>

    <form id="filterForm" action="{{ route('filter.result') }}" method="GET">
        @csrf
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-4 sm:p-8">
                <div class="mt-4">
                    <div class="container">
                        <div class="flex mb-4 p-1 pl-3 pr-1 mb-1">
                            <div class="col-span-12 m-0 p-0 px-1 py-0 inline-block text-2xl">
                                Type
                            </div>
                        </div>
                        <div class="type-buttons">
                            <input type="radio" name="type" id="type-shonen" value="Shonen" onclick="toggleRadio(this)">
                            <label for="type-shonen">Shonen</label>

                            <input type="radio" name="type" id="type-seinen" value="Seinen" onclick="toggleRadio(this)">
                            <label for="type-seinen">Seinen</label>

                            <input type="radio" name="type" id="type-shojo" value="Shojo" onclick="toggleRadio(this)">
                            <label for="type-shojo">Shojo</label>

                            <input type="radio" name="type" id="type-josei" value="Josei" onclick="toggleRadio(this)">
                            <label for="type-josei">Josei</label>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="container">
                            <div class="flex mb-4 p-1 pl-3 pr-1 mb-1">
                                <div class="col-span-12 m-0 p-0 px-1 py-0 inline-block text-2xl">
                                    Progress
                                </div>
                            </div>
                            <div class="type-buttons">
                                <input type="radio" name="progress" id="continued" value="continued" onclick="toggleRadio(this)">
                                <label for="continued">Continued</label>

                                <input type="radio" name="progress" id="completed" value="completed" onclick="toggleRadio(this)">
                                <label for="completed">Completed</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="container">
                            <div class="flex mb-4 p-1 pl-3 pr-1 mb-1">
                                <div class="col-span-12 m-0 p-0 px-1 py-0 inline-block text-2xl">
                                    Genre
                                </div>
                            </div>
                            <div class="genre-buttons flex flex-wrap">
                                @foreach($tags as $tag)
                                <div class="mr-4 mb-4">
                                    <input type="checkbox" name="genres[]" id="genre-{{ $tag->id }}" value="{{ $tag->id }}">
                                    <label for="genre-{{ $tag->id }}">{{ $tag->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex mb-8">
                        <x-primary-button>
                            Submit
                        </x-primary-button>

                        <button type="button" id="clearAll" class="inline-flex items-center ml-7 px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Clear All
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    <script>
        let prevRadio = null;

        function toggleRadio(radio) {
            if (prevRadio == radio) {
                radio.checked = false;
                radio.blur();
                prevRadio = null;
            } else {
                prevRadio = radio;
            }
        }

        document.getElementById('clearAll').addEventListener('click', function() {
            const inputs = document.querySelectorAll('#filterForm input[type="radio"], #filterForm input[type="checkbox"]');
            inputs.forEach(input => input.checked = false);
            prevRadio = null;
        });
    </script>
</x-app-layout>