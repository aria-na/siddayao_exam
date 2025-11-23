<x-guest-layout>
    <form method="POST" action="{{ route('profile.setup.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-black dark:text-white tracking-tight">Finish Profile</h2>
            <p class="text-gray-500 text-sm mt-2">Step 2 of 2: Customize your look</p>
        </div>

        <div class="flex flex-col items-center mb-8" x-data="{ photoName: null, photoPreview: null }">
            
            <input type="file" id="photo" class="hidden" 
                   x-ref="photo"
                   name="profile_photo"
                   accept="image/*"
                   x-on:change="
                        const file = $refs.photo.files[0];
                        if (file) {
                            photoName = file.name;
                            const reader = new FileReader();
                            reader.onload = (e) => { photoPreview = e.target.result; };
                            reader.readAsDataURL(file);
                        }
                   " />

            <div style="width: 140px; height: 140px;" class="shrink-0 relative">
                
                <label for="photo" class="block w-full h-full rounded-full cursor-pointer overflow-hidden border-2 border-dashed border-gray-400 hover:border-purple-500 dark:border-gray-600 transition group bg-gray-100 dark:bg-gray-800">
                    
                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 group-hover:text-purple-500 transition"
                         x-show="!photoPreview">
                        <span class="text-6xl font-thin select-none leading-none pb-2">+</span>
                    </div>

                    <div class="w-full h-full relative"
                         x-show="photoPreview"
                         style="display: none;">
                        
                        <img :src="photoPreview" class="w-full h-full object-cover">
                        
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <span class="text-white text-xs font-bold uppercase tracking-wider select-none">Change</span>
                        </div>
                    </div>

                </label>

            </div>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-500" x-show="!photoName">Tap circle to select photo</p>
                <p class="text-sm text-green-600 font-bold" x-show="photoName" style="display: none;">
                    Photo Selected!
                </p>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <input id="display_name" class="block w-full rounded-2xl bg-gray-100 dark:bg-[#181818] border-transparent focus:border-purple-600 focus:bg-white dark:focus:bg-black focus:ring-0 text-black dark:text-white h-14 px-5 transition-all font-medium placeholder-gray-500" 
                type="text" name="display_name" :value="old('display_name')" required autofocus placeholder="Display Name (e.g. @username)" />
                <x-input-error :messages="$errors->get('display_name')" class="mt-2 text-xs" />
            </div>
        </div>

        <div class="mt-8 flex gap-4">
            <a href="{{ route('dashboard') }}" class="flex-1 flex items-center justify-center bg-transparent border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 text-black dark:text-white font-bold py-4 rounded-2xl transition text-base">
                Cancel
            </a>

            <button type="submit" class="flex-1 bg-black dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-200 text-white dark:text-black font-bold py-4 rounded-2xl transition text-base shadow-lg shadow-purple-500/10">
                Finish
            </button>
        </div>
    </form>
</x-guest-layout>