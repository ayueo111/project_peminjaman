<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Top - Tools Illustration -->
           
            <!-- Bottom - Form -->
            <div class="px-6 py-8 sm:px-12 sm:py-10">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900"> LOGIN</h1>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Email" class="w-full pl-14 pr-4 py-3 rounded-full bg-teal-500 text-white placeholder-white placeholder-opacity-80 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-0 text-base" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" class="w-full pl-14 pr-4 py-3 rounded-full bg-teal-500 text-white placeholder-white placeholder-opacity-80 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-0 text-base" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center pt-2">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500" name="remember">
                            <span class="ms-2 text-sm text-gray-700">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="w-full bg-gray-900 text-white font-bold py-2 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition mt-6 text-lg">
                        LOGIN
                    </button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-700">
                        New User? 
                        <a href="{{ route('register') }}" class="text-teal-600 hover:text-teal-700 font-bold">Create a account</a>
                    </p>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a class="text-sm text-gray-600 hover:text-gray-900 transition" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
