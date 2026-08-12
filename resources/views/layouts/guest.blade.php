<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gradient-to-br from-slate-50 via-teal-50/40 to-emerald-50/60">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DIBANSOS BINTUNI') }} — Pelayanan Publik</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans antialiased text-slate-900 bg-gradient-to-br from-slate-50 via-teal-50/30 to-emerald-50/40 selection:bg-emerald-600 selection:text-white relative overflow-x-hidden">
        <!-- Ambient Soft Glowing Accents -->
        <div class="fixed -top-24 left-1/4 h-96 w-96 rounded-full bg-emerald-400/20 blur-[100px] pointer-events-none"></div>
        <div class="fixed bottom-0 right-1/4 h-[30rem] w-[30rem] rounded-full bg-teal-400/20 blur-[130px] pointer-events-none"></div>
        <div class="fixed top-1/3 -right-20 h-80 w-80 rounded-full bg-amber-300/15 blur-[90px] pointer-events-none"></div>

        <div class="min-h-screen flex flex-col justify-center py-10 sm:px-6 lg:px-8 relative z-10">
            <div class="sm:mx-auto sm:w-full sm:max-w-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
