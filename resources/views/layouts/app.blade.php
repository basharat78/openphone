<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-200">
        <div class="min-h-screen bg-[#111827]">
            @if(request()->is('qc/*') || Auth::user()->user_type === 'qc')
                @include('layouts.qc-navigation')
            @else
                @include('layouts.navigation')
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-[#1f2937] shadow-lg border-b border-gray-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-[#111827] border-t border-gray-800 py-8 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-2">
                             <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black shadow-lg shadow-indigo-200/20">
                                OP
                            </div>
                            <span class="font-bold text-gray-400">OpenPhone <span class="text-gray-600 font-medium">QC Integration</span></span>
                        </div>
                        <div class="flex gap-6 text-sm text-gray-500 font-medium">
                            <a href="#" class="hover:text-indigo-400 transition-colors">Documentation</a>
                            <a href="#" class="hover:text-indigo-400 transition-colors">Support</a>
                            <a href="#" class="hover:text-indigo-400 transition-colors">Privacy</a>
                        </div>
                        <div class="text-sm text-gray-600">
                            &copy; {{ date('Y') }} TruckZap. All rights reserved.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
