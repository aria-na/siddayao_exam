<x-main-layout>
    
    <!-- Mobile Header -->
    <div class="md:hidden flex justify-between items-center p-4 sticky top-0 bg-white/80 dark:bg-black/80 backdrop-blur z-40 border-b border-gray-200 dark:border-gray-800">
        <h1 class="text-xl font-bold text-purple-600 font-sans">@</h1>
        <div class="flex gap-4">
             @auth
                <a href="{{ route('dashboard') }}" class="text-sm font-bold">Profile</a>
             @else
                <a href="{{ route('login') }}" class="text-sm font-bold">Log in</a>
             @endauth
        </div>
    </div>

    <!-- Main Feed Area -->
    <div class="max-w-2xl mx-auto w-full pb-20">
        
        <!-- Desktop Page Title -->
        <div class="hidden md:block p-6 border-b border-gray-200 dark:border-gray-800">
            <h2 class="text-xl font-bold">Home</h2>
        </div>

        <!-- Tweet Loop -->
        @foreach($tweets as $tweet)
            <div class="p-6 border-b border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900/40 transition cursor-pointer">
                <div class="flex gap-4">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 overflow-hidden border border-gray-100 dark:border-gray-800">
                             @if($tweet->user->profile_photo_path)
                                <img src="{{ Storage::url($tweet->user->profile_photo_path) }}" class="w-full h-full object-cover">
                             @else
                                <div class="w-full h-full bg-purple-600 flex items-center justify-center text-white font-bold">
                                    {{ substr($tweet->user->name, 0, 1) }}
                                </div>
                             @endif
                        </div>
                    </div>

                    <!-- Tweet Content -->
                    <div class="flex-1 min-w-0"> <!-- min-w-0 is crucial for truncation in flex containers -->
                        <!-- Header -->
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-black dark:text-white text-[15px]">{{ $tweet->user->display_name ?? $tweet->user->name }}</span>
                                <span class="text-gray-400 text-sm">{{ $tweet->created_at->diffForHumans(null, true, true) }}</span>
                            </div>
                            
                            <!-- Delete Dropdown -->
                            @if(Auth::id() === $tweet->user_id)
                                <div class="relative" x-data="{ open: false }">
                                    <button @click.stop="open = !open" class="text-gray-400 hover:text-black dark:hover:text-white p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-900 rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.1)] border border-gray-100 dark:border-gray-800 z-10 py-1" x-cloak>
                                        <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" onsubmit="return confirm('Delete thought? This cannot be undone.');">
                                            @csrf @method('DELETE')
                                            <button class="w-full text-left px-4 py-2 text-red-500 font-medium hover:bg-gray-50 dark:hover:bg-gray-800 text-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- SMART TEXT AREA (Fixes the overflow) -->
                        <div x-data="{ expanded: false }">
                            <p class="mt-1 text-black dark:text-gray-100 text-[15px] leading-relaxed" 
                               :class="expanded ? 'whitespace-pre-wrap break-words' : 'truncate'">
                               {{ $tweet->content }}
                            </p>
                            
                            @if(Str::length($tweet->content) > 60)
                                <button @click.stop="expanded = !expanded" 
                                        x-show="!expanded"
                                        class="text-sm text-gray-500 hover:text-purple-600 font-medium mt-1">
                                    More
                                </button>
                            @endif
                        </div>
                        
                        @if($tweet->is_edited)
                            <span class="text-xs text-gray-400 mt-2 block">Edited</span>
                        @endif

                        <!-- Like Button -->
                        <div class="mt-3 flex items-center gap-4">
                            @auth
                                <div x-data="{ liked: {{ $tweet->isLikedBy(Auth::user()) ? 'true' : 'false' }}, count: {{ $tweet->likes_count }} }">
                                    <button @click="liked = !liked; count = liked ? count + 1 : count - 1; fetch('{{ route('tweets.like', $tweet) }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });" 
                                        class="group flex items-center gap-1.5 transition" :class="liked ? 'text-purple-600' : 'text-black dark:text-white'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" :fill="liked ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:scale-110 transition-transform"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                                        <span class="text-sm font-medium" x-text="count > 0 ? count : ''"></span>
                                    </button>
                                </div>
                            @else
                                <button @click="$dispatch('open-guest-modal')" class="group flex items-center gap-1.5 text-black dark:text-white hover:text-purple-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                                    <span class="text-sm font-medium">{{ $tweet->likes_count > 0 ? $tweet->likes_count : '' }}</span>
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-main-layout>