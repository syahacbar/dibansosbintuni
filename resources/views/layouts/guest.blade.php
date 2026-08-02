<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DIBANSOS BINTUNI') }} — Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans antialiased text-slate-900 bg-slate-950 selection:bg-emerald-500 selection:text-white relative overflow-x-hidden">
        <!-- Ambient Glowing Orbs -->
        <div class="fixed top-0 left-1/4 h-96 w-96 rounded-full bg-emerald-500/10 blur-[120px] pointer-events-none"></div>
        <div class="fixed bottom-0 right-1/4 h-96 w-96 rounded-full bg-teal-500/10 blur-[120px] pointer-events-none"></div>

        <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative z-10">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
