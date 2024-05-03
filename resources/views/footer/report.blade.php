<x-app-layout>
    <div class="container mx-auto my-6 px-4">
        <h1 class="text-2xl font-bold mb-4">Report an Issue</h1>

        <p class="mb-4">We want to ensure that all users can operate in a safe and positive environment. If you find inappropriate content or behavior, please report it using the form below.</p>

        <form method="POST" action="{{ route('report.store') }}" class="space-y-4">
            @csrf

            <div class="form-group my-7">
                <label for="report_type" class="block text-sm font-medium text-gray-700">Type of Report</label>
                <select class="form-control mt-1 block w-1/6 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="report_type" name="report_type" required>
                    <option value="">Please select</option>
                    <option value="manga">Manga</option>
                    <option value="chapter">Manga Chapter</option>
                    <option value="comment">Comment</option>
                </select>
            </div>

            <div class="form-group my-7" id="manga_name" style="display: none;">
                <label for="manga_name_input" class="block text-sm font-medium text-gray-700">Manga Name</label>
                <input type="text" class="form-control mt-1 block w-1/6 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="manga_name_input" name="manga_name">
            </div>

            <div class="form-group my-7" id="chapter_number" style="display: none;">
                <label for="chapter_number_input" class="block text-sm font-medium text-gray-700">Chapter Number</label>
                <input type="text" class="form-control mt-1 block w-1/6 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="chapter_number_input" name="chapter_number">
            </div>

            <div class="form-group my-7" id="comment_id_input" style="display: none;">
                <label for="comment_id" class="block text-sm font-medium text-gray-700">Comment ID <span class="text-xs text-gray-500">(This is the ID next to the user's name)</span></label>
                <input type="text" class="form-control mt-1 block w-1/6 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="comment_id" name="comment_id">
            </div>

            <div class="form-group my-7">
                <label for="report_scope" class="block text-sm font-medium text-gray-700">Scope</label>
                <select class="form-control mt-1 block w-1/6 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="report_scope" name="report_scope" required>
                    <option value="">Please select</option>
                    <option value="copyright" class="manga chapter">Copyright</option>
                    <option value="abuse" class="manga chapter comment">Abuse</option>
                    <option value="inappropriate" class="manga chapter">Inappropriate Content</option>
                    <option value="misinformation" class="manga chapter">Misinformation</option>
                    <option value="spam" class="comment">Spam</option>
                    <option value="sexual" class="comment">Sexual</option>
                    <option value="terrorism" class="comment">Terrorism</option>
                    <option value="bullying" class="comment">Bullying</option>
                    <option value="suicide" class="comment">Suicide</option>
                    <option value="misinformation" class="comment">Misinformation</option>
                </select>
            </div>

            <div class="form-group my-7">
                <label for="content" class="block text-sm font-medium text-gray-700">Details</label>
                <textarea class="form-control mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="content" name="content" rows="3" required></textarea>
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit Report</button>
        </form>

    </div>

    <script>
        document.getElementById('report_type').addEventListener('change', function() {
            var reportType = this.value;
            var scopeSelect = document.getElementById('report_scope');
            var scopeOptions = scopeSelect.options;
            var mangaName = document.getElementById('manga_name');
            var chapterName = document.getElementById('chapter_number');
            var commentIdInput = document.getElementById('comment_id_input');

            // Reset the scope selection
            scopeSelect.selectedIndex = 0;

            // Show or hide the manga name and chapter name input fields based on the report type
            mangaName.style.display = (reportType === 'manga' || reportType === 'chapter' || reportType === 'comment') ? 'block' : 'none';
            chapterName.style.display = (reportType === 'chapter') ? 'block' : 'none';

            // Show or hide the comment id input field based on the report type
            commentIdInput.style.display = (reportType === 'comment') ? 'block' : 'none';

            for (var i = 0; i < scopeOptions.length; i++) {
                var option = scopeOptions[i];
                if (option.className.indexOf(reportType) === -1) {
                    option.style.display = 'none';
                } else {
                    option.style.display = 'block';
                }
            }
        });
    </script>

</x-app-layout>