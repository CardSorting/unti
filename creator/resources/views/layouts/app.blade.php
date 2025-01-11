<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Pokemon Card Creator</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" x-data="sessionHandler">
        <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
            <nav class="bg-black/30 backdrop-blur-sm border-b border-white/10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <a href="{{ route('cards.index') }}" class="text-xl font-bold text-white">
                                Pokemon Card Creator
                            </a>
                        </div>
                        <div class="flex items-center">
                            <a href="{{ route('cards.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create New Card
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Success Message -->
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-lg" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Session Expired Alert -->
            <div x-show="showExpiredAlert" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg" role="alert">
                    <span class="block sm:inline">Your session has expired. The page will refresh automatically.</span>
                </div>
            </div>

            <!-- Main Content -->
            <main class="py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
