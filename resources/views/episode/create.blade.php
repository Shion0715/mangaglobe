<x-app-layout>
    <x-slot name="header">
        <form method="post" action="{{ route('episode.store', $post) }}" enctype="multipart/form-data">
            @csrf
            <div style="display: flex; align-items: center;">
                <h2 class="mx-2 font-semibold text-xl text-gray-800 leading-tight">
                    Post Chapter
                </h2>
                <input type="number" id="episode_number" name="episode_number" value="{{ $episode_number }}" min="1" onchange="showWarning()" style="width: 75px;">
                @error('episode_number')
                <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                @enderror
            </div>
            <script>
                function showWarning() {
                    var episodeNumber = document.getElementById('episode_number').value;
                    if (episodeNumber != {
                            {
                                $episode_number
                            }
                        }) {
                        alert('Please be careful when changing the episode number. It can affect the order of the episodes.');
                    }
                }
            </script>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="overflow-x: hidden;">
        <div class="mx-4 sm:p-8">
            <div class="md:flex items-center mt-10">
                <div class="w-full flex flex-col mt-4">
                    <label for="ep_title" class="font-semibold leading-none">Chapter Title</label>
                    @error('ep_title')
                    <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                    @enderror
                    <div class="flex mt-4">
                        <input type="text" name="ep_title" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" value="{{old('title')}}" placeholder="Enter Title">
                    </div>
                </div>
            </div>

            <div class="w-full flex flex-col mt-10">
                <div class="flex">
                    <label for="ep_cover_image" class="font-semibold leading-none">Cover Image</label>
                    @error('ep_cover_image')
                    <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                    @enderror
                </div>
                <span class="mt-2 text-sm text-gray-500">File: png,jpg,jpeg | 2MB or less &nbsp;&nbsp;&nbsp; Please choose your favorite frame/scene from the chapter. </span>
                <div class="relative">
                    <input class="mt-4" id="ep_cover_image" type="file" name="ep_cover_image" value="{{ old('ep_cover_image') }}">
                    <input type="hidden" id="cropped_ep_cover_image" name="cropped_ep_cover_image">
                    <div class="mt-4 max-w-[200px] max-h-auto overflow-hidden">
                        <img id="ep_cover_image_preview" src="" class="object-contain">
                    </div>
                    <script src="{{ asset('js/ep_cover_image_cropper.js') }}"></script>
                </div>
            </div>

            <div class="w-full flex flex-col mt-10">
                <div class="flex">
                    <label for="images" class="font-semibold leading-none">Chapter Images</label>
                    @error('images')
                    <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                    @enderror
                </div>
                <span class="mt-2 text-sm text-gray-500">File: png,jpg,jpeg | Recommend Long side 1500px | Within 50 pages | 2MB or less per 1 page | 80MB or less in total</span>
                <input type="file" name="images[]" id="images" multiple class="mt-4 form-control" required>
                <input type="hidden" id="image_order" name="image_order">
                <div class="form-group">
                    <div id="image_preview" style="width:100%;"></div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
            <script src="{{ asset('js/ep_image.js') }}"></script>

            <div class="w-full flex flex-col mt-10">
                <div class="flex">
                    <div class="font-semibold leading-none">Progress</div>
                    @error('progress')
                    <p class="text-red-500 font-semibold leading-none">&nbsp;{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex mt-4">
                    <div class="flex items-center mr-4">
                        <input id="progress1" type="radio" value="continued" name="progress" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('progress') == '連載中' ? 'checked' : '' }}>
                        <label for="progress1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Continued</label>
                    </div>
                    <div class="flex items-center mr-4">
                        <input id="progress2" type="radio" value="completed" name="progress" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('progress') == '完結' ? 'checked' : '' }}>
                        <label for="progress2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Completed</label>
                    </div>
                </div>
            </div>

            <x-primary-button class="my-10">
                Post
            </x-primary-button>
            </form>
        </div>
    </div>

</x-app-layout>