<x-main-layout>
    
    <div class="max-w-3xl mx-auto w-full pb-20" 
         x-data="{ 
            tab: 'thoughts', 
            deleteModalOpen: false, 
            deleteRoute: '', 
            editModalOpen: false, 
            editRoute: '', 
            editContent: '' 
         }">
        
        <div class="px-6 pt-6 pb-2 sm:px-8">
            <div class="flex justify-between items-start mb-4">
                <div class="mt-1">
                    <h1 class="text-3xl sm:text-4xl font-bold text-black dark:text-white tracking-tight leading-tight">
                        {{ $user->display_name ?? $user->name }}
                    </h1>
                    
                    <div class="flex items-center gap-2 mt-1">
                        <p class="text-black dark:text-white font-medium text-lg">{{ $user->name }}</p>
                    </div>

                    <div class="text-gray-500 text-sm mt-1">
                        Joined {{ $user->created_at->format('F Y') }}
                    </div>
                </div>

                <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full bg-gray-200 dark:bg-gray-800 overflow-hidden border-4 border-white dark:border-black shadow-sm flex-shrink-0">
                    @if($user->profile_photo_path)
                        <img src="{{ Storage::url($user->profile_photo_path) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-purple-600 flex items-center justify-center text-white text-5xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                <span class="hover:underline cursor-pointer text-black dark:text-gray-300">{{ $tweets->count() }} thoughts</span>
                <span>•</span>
                <span class="hover:underline cursor-pointer text-black dark:text-gray-300"
                      x-data="{ count: {{ $totalLikesReceived }} }"
                      @update-likes.window="count += $event.detail.amount"
                      x-text="count + ' likes received'">
                </span>
            </div>

            <a href="{{ route('profile.setup') }}" class="block w-full border border-gray-300 dark:border-gray-700 rounded-xl py-2 text-center font-bold text-black dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 transition text-sm">
                Edit Profile
            </a>
        </div>

        <div class="flex w-full border-b border-gray-200 dark:border-gray-800 mt-4">
            <button @click="tab = 'thoughts'" 
                class="flex-1 pb-4 text-center font-bold text-sm sm:text-base transition relative"
                :class="tab === 'thoughts' ? 'text-black dark:text-white' : 'text-gray-500 hover:text-gray-800 dark:hover:text-gray-300'">
                Thoughts
                <div x-show="tab === 'thoughts'" class="absolute bottom-0 left-0 w-full h-0.5 bg-black dark:bg-white"></div>
            </button>
            
            <button @click="tab = 'liked'" 
                class="flex-1 pb-4 text-center font-bold text-sm sm:text-base transition relative"
                :class="tab === 'liked' ? 'text-black dark:text-white' : 'text-gray-500 hover:text-gray-800 dark:hover:text-gray-300'">
                Thoughts Liked
                <div x-show="tab === 'liked'" class="absolute bottom-0 left-0 w-full h-0.5 bg-black dark:bg-white"></div>
            </button>
        </div>

        <div x-show="tab === 'thoughts'" class="mt-2">
            @if($tweets->count() > 0)
                @foreach($tweets as $tweet)
                    <div class="p-6 border-b border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900/40 transition cursor-pointer">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 overflow-hidden border border-gray-100 dark:border-gray-800">
                                     @if($tweet->user->profile_photo_path)
                                        <img src="{{ Storage::url($tweet->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                     @else
                                        <div class="w-full h-full bg-purple-600 flex items-center justify-center text-white font-bold">{{ substr($tweet->user->name, 0, 1) }}</div>
                                     @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-black dark:text-white text-[15px]">{{ $tweet->user->display_name ?? $tweet->user->name }}</span>
                                        <span class="text-gray-400 text-sm">{{ $tweet->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click.stop="open = !open" class="text-gray-400 hover:text-black dark:hover:text-white p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-900 rounded-xl shadow-[0_0_15px_rgba(0,0,0,0.1)] border border-gray-100 dark:border-gray-800 z-10 overflow-hidden" x-cloak>
                                            <button @click="editModalOpen = true; editRoute = '{{ route('tweets.update', $tweet) }}'; editContent = '{{ addslashes($tweet->content) }}'; open = false" 
                                                    class="w-full text-left px-4 py-3 text-black dark:text-white font-bold hover:bg-gray-50 dark:hover:bg-gray-800 text-sm border-b border-gray-100 dark:border-gray-800">
                                                Edit
                                            </button>
                                            <button @click="deleteModalOpen = true; deleteRoute = '{{ route('tweets.destroy', $tweet) }}'; open = false" 
                                                    class="w-full text-left px-4 py-3 text-red-600 font-bold hover:bg-gray-50 dark:hover:bg-gray-800 text-sm">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-1 text-black dark:text-gray-100 text-[15px] whitespace-pre-wrap leading-relaxed">{{ $tweet->content }}</p>
                                @if($tweet->is_edited) <span class="text-xs text-gray-400 mt-2 block">Edited</span> @endif
                                
                                <div class="mt-3 flex items-center gap-4">
                                    <div x-data="{ 
                                            liked: {{ $tweet->isLikedBy(Auth::user()) ? 'true' : 'false' }}, 
                                            count: {{ $tweet->likes_count }} 
                                         }">
                                        <button @click="
                                                liked = !liked;
                                                count = liked ? count + 1 : count - 1;
                                                @if(Auth::id() === $tweet->user_id)
                                                    $dispatch('update-likes', { amount: liked ? 1 : -1 });
                                                @endif
                                                fetch('{{ route('tweets.like', $tweet) }}', {
                                                    method: 'POST',
                                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                                });
                                            " 
                                            class="group flex items-center gap-1.5 transition"
                                            :class="liked ? 'text-purple-600' : 'text-black dark:text-white'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" 
                                                 :fill="liked ? 'currentColor' : 'none'" 
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                 class="group-hover:scale-110 transition-transform">
                                                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                            </svg>
                                            <span class="text-sm font-medium" x-text="count > 0 ? count : ''"></span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-16 text-gray-500 text-sm">No thoughts yet.</div>
            @endif
        </div>

        <div x-show="tab === 'liked'" class="mt-2" style="display: none;">
            @if($likedTweets->count() > 0)
                @foreach($likedTweets as $tweet)
                    @if($tweet)
                    <div x-data="{ liked: true, count: {{ $tweet->likes_count ?? 0 }} }" 
                         x-show="liked"
                         x-transition.duration.300ms
                         class="p-6 border-b border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900/40 transition">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 overflow-hidden border border-gray-100 dark:border-gray-800">
                                     @if($tweet->user->profile_photo_path)
                                        <img src="{{ Storage::url($tweet->user->profile_photo_path) }}" class="w-full h-full object-cover">
                                     @else
                                        <div class="w-full h-full bg-purple-600 flex items-center justify-center text-white font-bold">{{ substr($tweet->user->name, 0, 1) }}</div>
                                     @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-black dark:text-white text-[15px]">{{ $tweet->user->display_name ?? $tweet->user->name }}</span>
                                        <span class="text-gray-400 text-sm">{{ $tweet->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <p class="mt-1 text-black dark:text-gray-100 text-[15px] whitespace-pre-wrap leading-relaxed">{{ $tweet->content }}</p>
                                
                                <div class="mt-3 flex items-center gap-4">
                                    <button @click="
                                            liked = !liked;
                                            count = liked ? count + 1 : count - 1;
                                            @if(Auth::id() === $tweet->user_id)
                                                $dispatch('update-likes', { amount: liked ? 1 : -1 });
                                            @endif
                                            fetch('{{ route('tweets.like', $tweet) }}', {
                                                method: 'POST',
                                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                            });
                                        " 
                                        class="group flex items-center gap-1.5 transition"
                                        :class="liked ? 'text-purple-600' : 'text-black dark:text-white'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" 
                                             :fill="liked ? 'currentColor' : 'none'" 
                                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                             class="group-hover:scale-110 transition-transform">
                                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                        </svg>
                                        <span class="text-sm font-medium" x-text="count > 0 ? count : ''"></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @else
                <div class="text-center py-16 text-gray-500 text-sm">No liked thoughts yet.</div>
            @endif
        </div>

        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4" x-cloak>
            <div @click.away="deleteModalOpen = false" style="max-width: 400px; width: 100%;" class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-6 border border-gray-200 dark:border-gray-800 text-center transform transition-all">
                <h3 class="text-lg font-bold text-black dark:text-white mb-2">Delete thought?</h3>
                <p class="text-sm text-gray-500 mb-6 leading-relaxed">If you delete this thought, you won't be able to restore it.</p>
                <div class="flex gap-3">
                    <button @click="deleteModalOpen = false" class="flex-1 py-3 rounded-xl border border-gray-300 dark:border-gray-700 font-bold text-black dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 transition">Cancel</button>
                    <form :action="deleteRoute" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold transition">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-4" x-cloak>
            <div @click.away="editModalOpen = false" style="max-width: 600px; width: 100%;" class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-6 border border-gray-200 dark:border-gray-800 transform transition-all">
                <form :action="editRoute" method="POST">
                    @csrf @method('PATCH')
                    <div class="flex justify-between items-center mb-4">
                        <button type="button" @click="editModalOpen = false" class="text-black dark:text-white font-medium">Cancel</button>
                        <h3 class="font-bold text-lg text-black dark:text-white">Edit Thought</h3>
                        <div></div>
                    </div>
                    
                    <div class="flex gap-4 mb-2">
                        <div class="w-10 h-10 rounded-full bg-gray-300 overflow-hidden flex-shrink-0">
                             @if($user->profile_photo_path)
                                <img src="{{ Storage::url($user->profile_photo_path) }}" class="w-full h-full object-cover">
                             @else
                                <div class="w-full h-full bg-purple-600 flex items-center justify-center text-white font-bold">{{ substr($user->name, 0, 1) }}</div>
                             @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-bold mb-1 text-sm text-black dark:text-white">{{ $user->display_name ?? $user->name }}</p>
                            <textarea name="content" rows="4" 
                                class="w-full bg-transparent text-lg placeholder-gray-400 text-black dark:text-white p-0 resize-none border-0 focus:border-0 focus:ring-0 shadow-none outline-none ring-0"
                                x-model="editContent"
                                maxlength="280"></textarea>
                            <div class="text-right text-xs text-gray-500 mt-2" x-text="editContent.length + '/280'"></div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-black dark:bg-white text-white dark:text-black font-bold py-2 px-6 rounded-full transition opacity-90 hover:opacity-100">Done</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-main-layout>