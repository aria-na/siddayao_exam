<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-black dark:text-white tracking-tight">Log in</h2>
            <p class="text-gray-500 text-sm mt-2">Welcome back.</p>
        </div>

        <div class="space-y-4">
            <div>
                <input id="email" class="block w-full rounded-2xl bg-gray-100 dark:bg-[#181818] border-transparent focus:border-purple-600 focus:bg-white dark:focus:bg-black focus:ring-0 text-black dark:text-white h-14 px-5 transition-all font-medium placeholder-gray-500" 
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
            </div>

            <div>
                <input id="password" class="block w-full rounded-2xl bg-gray-100 dark:bg-[#181818] border-transparent focus:border-purple-600 focus:bg-white dark:focus:bg-black focus:ring-0 text-black dark:text-white h-14 px-5 transition-all font-medium placeholder-gray-500" 
                type="password" name="password" required autocomplete="current-password" placeholder="Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-purple-600 shadow-sm focus:ring-purple-500 bg-gray-100 dark:bg-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400 font-medium">{{ __('Remember me') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-500 hover:text-black dark:hover:text-white transition" href="{{ route('password.request') }}">
                    {{ __('Forgot?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">
            <button class="w-full bg-black dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-200 text-white dark:text-black font-bold py-4 rounded-2xl transition text-base shadow-lg shadow-purple-500/10">
                Log in
            </button>
            
            <div class="text-center mt-6 flex flex-col gap-3">
                <a class="text-sm text-gray-500 hover:text-black dark:hover:text-white transition font-medium" href="{{ route('register') }}">
                    Don't have an account? <span class="text-purple-600">Sign up</span>
                </a>

                <a class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition" href="{{ route('home') }}">
                    ← Back to Home
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>