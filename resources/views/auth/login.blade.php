<x-guest-layout>

    <div class="w-full max-w-md p-4">

            <!-- Branding -->
            <div class="text-center mb-6">
                <div class="flex items-center justify-center">
                     <a href="/">
                        <img 
                            src="{{ asset('images/logo.png') }}" 
                            alt="EveryDhay Logo" 
                            class="h-20 w-auto"
                        >
                    </a>
                   
                </div>

            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Email Address" class="text-gray-700"/>
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-emerald-400 focus:ring-emerald-400"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="you@flowershop.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="Password" class="text-gray-700"/>
                    <x-text-input
                        id="password"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-emerald-400 focus:ring-emerald-400"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                        >
                        <span class="ml-2 text-gray-600">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-emerald-600 hover:text-emerald-800">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <x-primary-button
                    class="w-full justify-center bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500 rounded-lg py-3 text-base">
                    Log in
                </x-primary-button>

                <!-- Divider -->
                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="mx-3 text-xs text-gray-400">OR</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <!-- Google Login -->
                <a href="{{ route('google.login') }}"
                   class="w-full flex items-center justify-center gap-3 border border-gray-300 rounded-lg py-3 hover:bg-gray-50 transition">
                    <img src="https://developers.google.com/identity/images/g-logo.png" class="w-5 h-5">
                    <span class="text-gray-700 font-medium">Continue with Google</span>
                </a>
            </form>

            <!-- Footer -->
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} EveryDhay. All rights reserved.
            </p>
        </div>
</x-guest-layout>
