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

            <p class="text-sm text-gray-500 mt-1">
                Admin Panel
            </p>
        </div>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600 text-center">
                Invalid email or password
            </div>
        @endif

        <form method="POST" action="/admin/login" class="space-y-5">
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
                    placeholder="admin@everydhay.com"
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
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <!-- Login Button -->
            <x-primary-button
                class="w-full justify-center bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500 rounded-lg py-3 text-base">
                Admin Login
            </x-primary-button>
        </form>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-400 mt-6">
            © {{ date('Y') }} EveryDhay. Admin Access Only.
        </p>

    </div>

</x-guest-layout>
