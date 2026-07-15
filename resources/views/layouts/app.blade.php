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
    <body class="font-sans antialiased">
        @php
            $pageTitle = isset($header) ? trim(strip_tags((string) $header)) : 'Dashboard';
        @endphp

        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-100 text-slate-900">
            <aside
                class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full border-r border-slate-200 bg-white transition-transform duration-200 lg:translate-x-0"
                :class="{ 'translate-x-0': sidebarOpen }"
            >
                <div class="flex h-16 items-center border-b border-slate-200 px-6">
                    <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-slate-950">
                        SIBANSOS Mahasiswa
                    </a>
                </div>

                <nav class="space-y-1 px-4 py-5">
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' }}"
                    >
                        Dashboard
                    </a>

                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Mahasiswa</p>
                        <div class="mt-2 space-y-1">
                            <a
                                href="{{ route('mahasiswa.profile.edit') }}"
                                class="flex items-center rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('mahasiswa.profile.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' }}"
                            >
                                Profil
                            </a>
                            <a
                                href="{{ route('mahasiswa.documents.index') }}"
                                class="flex items-center rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('mahasiswa.documents.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' }}"
                            >
                                Upload Dokumen
                            </a>
                            <a
                                href="{{ route('mahasiswa.pengajuan.index') }}"
                                class="flex items-center rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('mahasiswa.pengajuan.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' }}"
                            >
                                Pengajuan Bantuan
                            </a>
                        </div>
                    </div>

                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Master Data</p>
                        <div class="mt-2 space-y-1">
                            @foreach ([
                                'master-data.periode-bansos.index' => 'Periode Bansos',
                                'master-data.jenis-bantuan.index' => 'Jenis Bantuan',
                                'master-data.perguruan-tinggi.index' => 'Perguruan Tinggi',
                                'master-data.fakultas.index' => 'Fakultas',
                                'master-data.program-studi.index' => 'Program Studi',
                                'master-data.distrik.index' => 'Distrik',
                                'master-data.kampung.index' => 'Kampung',
                            ] as $route => $label)
                                <a
                                    href="{{ route($route) }}"
                                    class="flex items-center rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs(Str::beforeLast($route, '.index').'.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-950' }}"
                                >
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </nav>
            </aside>

            <div
                x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-30 bg-slate-950/40 lg:hidden"
                @click="sidebarOpen = false"
            ></div>

            <div class="min-h-screen lg:pl-72">
                <nav class="sticky top-0 z-20 border-b border-slate-200 bg-white">
                    <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-slate-200 text-slate-700 lg:hidden"
                                @click="sidebarOpen = true"
                            >
                                <span class="sr-only">Buka sidebar</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75ZM2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10Zm0 5.25a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div>
                                <p class="text-sm font-semibold text-slate-950">
                                    {{ $pageTitle }}
                                </p>
                                <p class="text-xs text-slate-500">Kabupaten Teluk Bintuni</p>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:gap-4">
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500">{{ Auth::user()->roles->pluck('name')->join(', ') ?: 'User' }}</p>
                            </div>

                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-900 text-sm font-semibold text-white">
                                        {{ Str::of(Auth::user()->name)->substr(0, 1)->upper() }}
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </nav>

                <main class="px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>

                <footer class="border-t border-slate-200 bg-white px-4 py-4 text-sm text-slate-500 sm:px-6 lg:px-8">
                    &copy; {{ date('Y') }} SIBANSOS Mahasiswa Kabupaten Teluk Bintuni
                </footer>
            </div>
        </div>
    </body>
</html>
