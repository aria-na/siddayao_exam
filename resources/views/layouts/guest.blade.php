<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white dark:bg-black transition-colors duration-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8 scale-110">
                <a href="/" class="flex flex-col items-center gap-2">
                    <h1 class="text-6xl font-bold text-purple-600 tracking-tighter font-sans">Thoughts</h1>
                </a>
            </div>

            <div class="w-full sm:max-w-[420px] px-8 py-10 bg-white dark:bg-[#0a0a0a] shadow-none sm:shadow-2xl sm:rounded-[2rem] border border-transparent dark:border-gray-800/50">
                {{ $slot }}
            </div>
            
            <div class="mt-10 text-sm text-gray-400 dark:text-gray-600">
                &copy; {{ date('Y') }} Thoughts.
            </div>
        </div>
    </body>
</html>