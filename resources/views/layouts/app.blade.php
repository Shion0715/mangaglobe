<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ranking.css') }}">
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ep_create.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/show.js') }}"></script>
    <script src="{{ asset('js/responsive_dropdown.js') }}"></script>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="h-auto">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="sm:block bg-white shadow">
            <div class="max-w-full mx-auto py-5 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="">
            {{ $slot }}
        </main>

        <script>
            @if(session('message'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: `{!! session('message') !!}`,
            })
            @endif
        </script>
    </div>
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">About</h3>
                    <p class="text-gray-400">Brief description of the manga submission site and its purpose.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Terms</h3>
                    <ul class="text-gray-400">
                        <li><a href="#" class="hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white">Copyright Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Guidelines</h3>
                    <ul class="text-gray-400">
                        <li><a href="#" class="hover:text-white">Content Guidelines</a></li>
                        <li><a href="#" class="hover:text-white">Community Rules</a></li>
                        <li><a href="#" class="hover:text-white">Advertising Policy</a></li>
                    </ul>
                </div>
                <div class="md:col-span-2 lg:col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="text-gray-400">
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">Report Abuse</a></li>
                    </ul>
                </div>
                <div class="md:col-span-2 lg:col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                    <ul class="text-gray-400">
                        <li><a href="#" class="hover:text-white">Twitter</a></li>
                        <li><a href="#" class="hover:text-white">Facebook</a></li>
                        <li><a href="#" class="hover:text-white">Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-8 text-center text-gray-400">
                &copy; {{ date('Y') }} Manga Submission Site. All rights reserved.
            </div>
        </div>
    </footer>
</body>

</html>