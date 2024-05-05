<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
        <div>
            <h3 class="text-lg font-semibold mb-4">Terms</h3>
            <ul class="text-gray-400">
                <li><a href="{{route('terms')}}" class="hover:text-white">Terms of Service</a></li>
                <li><a href="{{route('privacy')}}" class="hover:text-white">Privacy Policy</a></li>
                <li><a href="{{route('copyright')}}" class="hover:text-white">Copyright Policy</a></li>
                <li><a href="{{route('cookie')}}" class="hover:text-white">Cookie Policy</a></li>
            </ul>
        </div>
        <div>
            <h3 class="text-lg font-semibold mb-4">Guidelines</h3>
            <ul class="text-gray-400">
                <li><a href="{{route('content')}}" class="hover:text-white">Content Guidelines</a></li>
                <li><a href="{{route('community')}}" class="hover:text-white">Community Rules</a></li>
            </ul>
        </div>
        <div class="md:col-span-2 lg:col-span-1">
            <h3 class="text-lg font-semibold mb-4">Support</h3>
            <ul class="text-gray-400">
                <!-- <li><a href="#" class="hover:text-white">FAQ</a></li> -->
                <li><a href="{{route('contact.create')}}" class="hover:text-white">Contact Us</a></li>
                <li><a href="{{route('report_create')}}" class="hover:text-white">Report an Issue</a></li>
            </ul>
        </div>
        
    </div>
    <div class="mt-8 border-t border-gray-700 pt-8 text-center text-gray-400">
        &copy; {{ date('Y') }} MangaGlobe. All rights reserved.
    </div>
</div>