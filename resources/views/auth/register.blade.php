<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-black dark:text-white tracking-tight">Sign up</h2>
            <p class="text-gray-500 text-sm mt-2">Join the conversation.</p>
        </div>

        <div class="space-y-4">
            <div>
                <input id="name" class="block w-full rounded-2xl bg-gray-100 dark:bg-[#181818] border-transparent focus:border-purple-600 focus:bg-white dark:focus:bg-black focus:ring-0 text-black dark:text-white h-14 px-5 transition-all font-medium placeholder-gray-500" 
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Real Name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs" />
            </div>

            <div>
                <input id="email" class="block w-full rounded-2xl bg-gray-100 dark:bg-[#181818] border-transparent focus:border-purple-600 focus:bg-white dark:focus:bg-black focus:ring-0 text-black dark:text-white h-14 px-5 transition-all font-medium placeholder-gray-500" 
                type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
            </div>

            <div>
                <input id="password" class="block w-full rounded-2xl bg-gray-100 dark:bg-[#181818] border-transparent focus:border-purple-600 focus:bg-white dark:focus:bg-black focus:ring-0 text-black dark:text-white h-14 px-5 transition-all font-medium placeholder-gray-500" 
                type="password" name="password" required autocomplete="new-password" placeholder="Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
            </div>

            <div>
                <input id="password_confirmation" class="block w-full rounded-2xl bg-gray-100 dark:bg-[#181818] border-transparent focus:border-purple-600 focus:bg-white dark:focus:bg-black focus:ring-0 text-black dark:text-white h-14 px-5 transition-all font-medium placeholder-gray-500" 
                type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs" />
            </div>
        </div>

        <div class="mt-8">
            <button class="w-full bg-black dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-200 text-white dark:text-black font-bold py-4 rounded-2xl transition text-base shadow-lg shadow-purple-500/10">
                Next
            </button>

            <div class="text-center mt-6">
                <a class="text-sm text-gray-500 hover:text-black dark:hover:text-white transition font-medium" href="{{ route('login') }}">
                    Already have an account? <span class="text-purple-600">Log in</span>
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>