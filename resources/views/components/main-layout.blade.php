<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thoughts</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        textarea:focus, input:focus { outline: none !important; box-shadow: none !important; border-color: transparent !important; }
    </style>
</head>
<body class="bg-white dark:bg-black text-black dark:text-white antialiased transition-colors duration-200" 
      x-data="{ 
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          postModalOpen: false,
          guestModalOpen: false,
          logoutModalOpen: false,
          toggleTheme() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
      @open-guest-modal.window="guestModalOpen = true">

    <div class="min-h-screen flex flex-col md:flex-row max-w-7xl mx-auto">
        
        <aside class="hidden md:flex flex-col w-20 lg:w-64 h-screen sticky top-0 px-4 py-6 justify-between z-20 border-r border-gray-100 dark:border-gray-800">
            <div class="space-y-8">
                <div class="px-2 py-2">
                   <h1 class="text-2xl font-bold text-purple-600 tracking-tighter">Thoughts</h1>
                </div>
                <nav class="flex flex-col space-y-2">
                    <a href="{{ route('home') }}" class="flex items-center p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-900 transition group {{ request()->routeIs('home') ? 'text-black dark:text-white' : 'text-gray-400' }}">
                        <svg aria-label="Home" class="w-7 h-7 transition-transform group-hover:scale-105" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ request()->routeIs('home') ? '0' : '2' }}" viewBox="0 0 24 24"><path d="M22 10.5V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-8.5c0-.6.2-1.2.6-1.6l7.8-6.9c.8-.7 2-.7 2.8 0l7.8 6.9c.4.4.6 1 .6 1.6Z"/></svg>
                        <span class="ml-4 font-semibold text-lg hidden lg:block {{ request()->routeIs('home') ? 'font-bold' : 'font-medium' }}">Home</span>
                    </a>
                    <button @click="postModalOpen = true" class="flex items-center p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-900 transition group text-gray-400 hover:text-black dark:hover:text-white">
                        <svg aria-label="Create" class="w-7 h-7 transition-transform group-hover:scale-105" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16M4 12h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span class="ml-4 font-medium text-lg hidden lg:block">Create</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-900 transition group {{ request()->routeIs('dashboard') ? 'text-black dark:text-white' : 'text-gray-400' }}">
                        <svg aria-label="Profile" class="w-7 h-7 transition-transform group-hover:scale-105" fill="{{ request()->routeIs('dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ request()->routeIs('dashboard') ? '0' : '2' }}" viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10ZM20.6 21c-.9-4-4.7-7-8.6-7s-7.7 3-8.6 7"/></svg>
                        <span class="ml-4 font-semibold text-lg hidden lg:block {{ request()->routeIs('dashboard') ? 'font-bold' : 'font-medium' }}">Profile</span>
                    </a>
                </nav>
            </div>

            <div class="relative" x-data="{ menuOpen: false }">
                <button @click="menuOpen = !menuOpen" class="flex items-center p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-900 text-gray-400 hover:text-black dark:hover:text-white transition w-full">
                    <svg aria-label="Settings" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line></svg>
                    <span class="ml-4 font-medium text-lg hidden lg:block">More</span>
                </button>
                <div x-show="menuOpen" @click.away="menuOpen = false" class="absolute bottom-full left-0 w-60 mb-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-xl p-2 z-50" x-cloak>
                    <button @click="toggleTheme()" class="w-full flex items-center justify-between gap-4 p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-left transition">
                        <span class="font-medium">Appearance</span>
                        <div class="text-gray-500 dark:text-gray-400">
                            <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                            <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                        </div>
                    </button>
                    <div class="h-px bg-gray-200 dark:bg-gray-800 my-1"></div>
                    @auth
                        <button @click="logoutModalOpen = true" class="w-full text-left p-3 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500 font-medium transition">Log out</button>
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-left p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 font-medium transition">Log in</a>
                    @endauth
                </div>
            </div>
        </aside>

        <main class="flex-1 min-h-screen relative pb-20 md:pb-0">
            
            <div class="md:hidden flex justify-between items-center p-4 sticky top-0 bg-white/90 dark:bg-black/90 backdrop-blur z-40 border-b border-gray-100 dark:border-gray-800">
                <h1 class="text-xl font-bold text-purple-600 tracking-tight">Thoughts</h1>
                
                <div class="relative" x-data="{ mobileMenuOpen: false }">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-black dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line></svg>
                    </button>

                    <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-xl p-2 z-50" x-cloak>
                        <button @click="toggleTheme()" class="w-full flex items-center justify-between gap-4 p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 text-left transition">
                            <span class="font-medium">Appearance</span>
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                                <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                            </div>
                        </button>
                        <div class="h-px bg-gray-200 dark:bg-gray-800 my-1"></div>
                        @auth
                            <button @click="logoutModalOpen = true; mobileMenuOpen = false" class="w-full text-left p-3 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500 font-medium transition">Log out</button>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-left p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 font-medium transition">Log in</a>
                        @endauth
                    </div>
                </div>
            </div>

            {{ $slot }}

            <div class="md:hidden fixed bottom-0 w-full bg-white dark:bg-black border-t border-gray-100 dark:border-gray-800 flex justify-evenly items-center py-4 pb-6 z-40">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-black dark:text-white' : 'text-gray-400' }}">
                    <svg class="w-7 h-7" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ request()->routeIs('home') ? '0' : '2' }}" viewBox="0 0 24 24"><path d="M22 10.5V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-8.5c0-.6.2-1.2.6-1.6l7.8-6.9c.8-.7 2-.7 2.8 0l7.8 6.9c.4.4.6 1 .6 1.6Z"/></svg>
                </a>
                
                <button @click="postModalOpen = true" class="text-gray-400 hover:text-black dark:hover:text-white">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16M4 12h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-black dark:text-white' : 'text-gray-400' }}">
                    <svg class="w-7 h-7" fill="{{ request()->routeIs('dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ request()->routeIs('dashboard') ? '0' : '2' }}" viewBox="0 0 24 24"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10ZM20.6 21c-.9-4-4.7-7-8.6-7s-7.7 3-8.6 7"/></svg>
                </a>
            </div>

        </main>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

    <div x-show="postModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4">
        <div @click.away="postModalOpen = false" class="w-full max-w-md">
            @auth
                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl p-6 border border-gray-200 dark:border-gray-800 transform transition-all">
                    <form action="{{ route('tweets.store') }}" method="POST" x-data="{ content: '' }">
                        @csrf
                        <div class="flex justify-between items-center mb-6">
                            <button type="button" @click="postModalOpen = false" class="text-black dark:text-white font-medium">Cancel</button>
                            <h3 class="font-bold text-lg">New Thought</h3>
                            <div></div>
                        </div>
                        <div class="flex gap-4 mb-2">
                            <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden flex-shrink-0">
                                 @if(Auth::user()->profile_photo_path)
                                    <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                                 @else
                                    <div class="w-full h-full bg-purple-600 flex items-center justify-center text-white font-bold">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                 @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-bold mb-1 text-sm">{{ Auth::user()->display_name ?? Auth::user()->name }}</p>
                                <textarea name="content" rows="4" class="w-full bg-transparent text-lg placeholder-gray-400 text-black dark:text-white p-0 resize-none border-0 focus:border-0 focus:ring-0 shadow-none outline-none ring-0" placeholder="Share your thoughts..." x-model="content" maxlength="280"></textarea>
                                <div class="text-right text-xs text-gray-500 mt-2" :class="content.length >= 280 ? 'text-red-500' : ''" x-text="content.length + '/280'">0/280</div>
                            </div>
                        </div>
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-black dark:bg-white text-white dark:text-black font-bold py-2 px-6 rounded-full transition opacity-90 hover:opacity-100">Post</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-white dark:bg-[#181818] rounded-3xl shadow-2xl p-10 text-center transform transition-all border border-transparent">
                    <h2 class="text-2xl font-bold mb-2 text-black dark:text-white tracking-tight">Want to share? Join <span class="text-purple-600">Thoughts</span>.</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 text-sm font-medium">Sign up to share, like, and more.</p>
                    <div class="flex flex-col gap-3 max-w-xs mx-auto">
                        <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-full font-bold w-full transition shadow-lg shadow-purple-500/20">Sign up</a>
                        <a href="{{ route('login') }}" class="bg-transparent border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 text-black dark:text-white py-3 rounded-full font-bold w-full transition">Log in</a>
                    </div>
                    <button @click="postModalOpen = false" class="mt-8 text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition font-medium">Close</button>
                </div>
            @endauth
        </div>
    </div>

    <div x-show="guestModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4">
        <div @click.away="guestModalOpen = false" class="bg-white dark:bg-[#181818] w-full max-w-md rounded-3xl overflow-hidden shadow-2xl p-10 text-center border border-transparent relative transform transition-all">
            <h2 class="text-2xl font-bold mb-2 text-black dark:text-white tracking-tight leading-snug">Like this? Join <span class="text-purple-600">Thoughts</span>.<br><span class="text-black dark:text-white">You'll love it!</span></h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8 text-sm font-medium">Sign up to like, share, and more.</p>
            <div class="flex flex-col gap-3 max-w-xs mx-auto">
                <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-full font-bold w-full transition shadow-lg shadow-purple-500/20">Sign up</a>
                <a href="{{ route('login') }}" class="bg-transparent border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 text-black dark:text-white py-3 rounded-full font-bold w-full transition">Log in</a>
            </div>
            <button @click="guestModalOpen = false" class="mt-8 text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition font-medium">Close</button>
        </div>
    </div>

    <div x-show="logoutModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4">
        <div @click.away="logoutModalOpen = false" class="bg-white dark:bg-[#181818] w-full max-w-md rounded-3xl shadow-2xl p-10 text-center transform transition-all border border-transparent">
            <h2 class="text-2xl font-bold mb-8 text-black dark:text-white tracking-tight">Want to exit <span class="text-purple-600">Thoughts</span>?</h2>
            <div class="flex flex-col gap-3">
                <button @click="document.getElementById('logout-form').submit()" class="bg-red-600 hover:bg-red-700 text-white py-3 rounded-full font-bold w-full transition shadow-lg shadow-red-500/20">Log out</button>
                <button @click="logoutModalOpen = false" class="bg-transparent border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 text-black dark:text-white py-3 rounded-full font-bold w-full transition">Cancel</button>
            </div>
        </div>
    </div>

</body>
</html>