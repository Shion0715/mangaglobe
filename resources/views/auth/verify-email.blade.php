<x-guest-layout>
    <div class="p-6 bg-white rounded shadow-md">
        <h2 class="text-2xl font-bold mb-5 text-gray-700">{{ __('Verify Your Email Address') }}</h2>

        <p class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ __('A new verification link has been sent to the email address you provided during registration.') }}</strong>
        </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-primary-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold rounded sm:py-2 sm:px-4 py-1 px-2">
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="text-blue-500 hover:text-blue-800 text-sm underline">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>