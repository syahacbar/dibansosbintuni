<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DIBANSOS BINTUNI') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans antialiased text-slate-900 bg-slate-50/90 selection:bg-emerald-500 selection:text-white">
        @php
            $pageTitle = isset($header) ? trim(strip_tags((string) $header)) : 'Dashboard';
            $logoPath = \App\Models\SystemSetting::where('key', 'logo_path')->value('value');
            $currentUser = Auth::user();
            $isSuperAdmin = $currentUser?->hasRole('Super Admin') ?? false;
            $isOperator = $currentUser?->hasRole('Operator') ?? false;
            $isMahasiswa = ($currentUser?->hasRole('Mahasiswa') ?? false) || (! $isSuperAdmin && ! $isOperator);
        @endphp

        <div x-data="{ sidebarOpen: false, searchOpen: false }" class="min-h-screen bg-slate-50/90">
            <!-- Sidebar Navigation -->
            <aside
                class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full overflow-y-auto border-r border-slate-800/90 bg-slate-950 text-slate-300 transition-transform duration-300 ease-in-out lg:translate-x-0 shadow-2xl"
                :class="{ 'translate-x-0': sidebarOpen }"
            >
                <!-- Brand Header -->
                <div class="sticky top-0 z-10 flex h-20 items-center border-b border-slate-800/90 bg-slate-950/95 px-6 backdrop-blur-md">
                    <a href="{{ route('dashboard') }}" class="group flex min-w-0 items-center gap-3.5 transition-all">
                        @if ($logoPath)
                            <img src="{{ Storage::disk('public')->url($logoPath) }}" alt="Logo" class="h-10 w-10 shrink-0 rounded-xl border border-slate-700/60 bg-slate-900 p-1 object-contain shadow-md shadow-emerald-950/30 group-hover:scale-105 transition-transform">
                        @else
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 via-teal-600 to-emerald-700 text-base font-extrabold text-white shadow-lg shadow-emerald-950/40 group-hover:scale-105 transition-transform">
                                DB
                            </div>
                        @endif
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5">
                                <h2 class="truncate text-base font-extrabold tracking-tight text-white group-hover:text-emerald-400 transition-colors">
                                    DIBANSOS
                                </h2>
                                <span class="rounded bg-emerald-500/20 px-1.5 py-0.5 text-[9px] font-bold text-emerald-400 border border-emerald-500/30">PRO</span>
                            </div>
                            <p class="truncate text-[11px] font-medium text-slate-400">
                                Kab. Teluk Bintuni
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Sidebar Nav Items -->
                <nav class="space-y-6 px-4 py-6">
                    <!-- General Navigation -->
                    <div>
                        <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-emerald-400/90">
                            Utama
                        </p>
                        <div class="mt-2 space-y-1">
                            <a
                                href="{{ route('dashboard') }}"
                                class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                            >
                                <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <span>Dashboard Portal</span>
                            </a>
                        </div>
                    </div>

                    <!-- Mahasiswa Menu -->
                    @if ($isMahasiswa)
                        <div>
                            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-emerald-400/90">
                                Layanan Mahasiswa
                            </p>
                            <div class="mt-2 space-y-1">
                                <a
                                    href="{{ route('mahasiswa.profile.edit') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('mahasiswa.profile.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <span>Profil Mahasiswa</span>
                                </a>
                                <a
                                    href="{{ route('mahasiswa.documents.index') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('mahasiswa.documents.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span>Upload Berkas Syarat</span>
                                </a>
                                <a
                                    href="{{ route('mahasiswa.pengajuan.index') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('mahasiswa.pengajuan.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                    <span>Pengajuan Bantuan</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Dinas Pendidikan Operator Menu -->
                    @if ($isOperator)
                        <div>
                            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-emerald-400/90">
                                Verifikasi & Penyaluran
                            </p>
                            <div class="mt-2 space-y-1">
                                <a
                                    href="{{ route('operator.dashboard') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('operator.dashboard') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z" />
                                    </svg>
                                    <span>Dashboard Verifikasi</span>
                                </a>
                                <a
                                    href="{{ route('operator.pengajuan.index') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('operator.pengajuan.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm0 5.25h.007v.008H3.75V12Zm0 5.25h.007v.008H3.75v-.008Z" />
                                    </svg>
                                    <span>Daftar Pengajuan</span>
                                </a>
                                <a
                                    href="{{ route('operator.penerima.index') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('operator.penerima.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6 0 3.375 3.375 0 0 1 6 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    <span>Penerima Bantuan</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Super Admin Menu -->
                    @if ($isSuperAdmin)
                        <div>
                            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-emerald-400/90">
                                Administrasi Sistem
                            </p>
                            <div class="mt-2 space-y-1">
                                <a
                                    href="{{ route('super-admin.users.index') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('super-admin.users.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <span>Manajemen User</span>
                                </a>
                                <a
                                    href="{{ route('super-admin.roles.index') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('super-admin.roles.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                    </svg>
                                    <span>Role & Hak Akses</span>
                                </a>
                                <a
                                    href="{{ route('super-admin.permissions.index') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('super-admin.permissions.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                    </svg>
                                    <span>Permissions</span>
                                </a>
                                <a
                                    href="{{ route('super-admin.settings.edit') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('super-admin.settings.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0m-9.75 0h9.75" />
                                    </svg>
                                    <span>Pengaturan Sistem</span>
                                </a>
                            </div>
                        </div>

                        <div>
                            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-emerald-400/90">
                                Executive & Laporan
                            </p>
                            <div class="mt-2 space-y-1">
                                <a
                                    href="{{ route('monitoring.dashboard') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('monitoring.dashboard') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3 1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9 3-3 2.143 2.143L15.428 7.5" />
                                    </svg>
                                    <span>Dashboard Monitoring</span>
                                </a>
                                <a
                                    href="{{ route('reports.index') }}"
                                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                >
                                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    <span>Laporan & Export</span>
                                </a>
                            </div>
                        </div>

                        <div>
                            <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-emerald-400/90">
                                Master Data
                            </p>
                            <div class="mt-2 space-y-1">
                                @foreach ([
                                    'master-data.periode-bansos.index' => ['Periode Bansos', 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5'],
                                    'master-data.jenis-bantuan.index' => ['Jenis Bantuan', 'M21 11.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V7.5Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM12 10.5v5.25'],
                                    'master-data.perguruan-tinggi.index' => ['Perguruan Tinggi', 'M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342'],
                                    'master-data.fakultas.index' => ['Fakultas', 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5h-15V21'],
                                    'master-data.program-studi.index' => ['Program Studi', 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25'],
                                    'master-data.distrik.index' => ['Distrik', 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z'],
                                    'master-data.kampung.index' => ['Kampung', 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75'],
                                ] as $route => $data)
                                    <a
                                        href="{{ route($route) }}"
                                        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs(Str::beforeLast($route, '.index').'.*') ? 'bg-gradient-to-r from-emerald-500/20 via-emerald-500/10 to-transparent text-emerald-400 font-bold border-l-4 border-emerald-500 shadow-sm' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}"
                                    >
                                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $data[1] }}" />
                                        </svg>
                                        <span>{{ $data[0] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </nav>
            </aside>

            <!-- Backdrop overlay for mobile -->
            <div
                x-show="sidebarOpen"
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-30 bg-slate-950/70 backdrop-blur-xs lg:hidden"
                @click="sidebarOpen = false"
            ></div>

            <!-- Main Layout Wrapper -->
            <div class="flex flex-col min-h-screen lg:pl-72 transition-all">
                <!-- Control Hub Top Header -->
                <header class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/95 backdrop-blur-md shadow-xs">
                    <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center gap-4">
                            <!-- Mobile Menu Toggle Button -->
                            <button
                                type="button"
                                class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200/80 bg-slate-50 text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 lg:hidden transition-colors"
                                @click="sidebarOpen = true"
                            >
                                <span class="sr-only">Buka sidebar</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>

                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <h1 class="text-lg font-extrabold tracking-tight text-slate-950">
                                        {{ $pageTitle }}
                                    </h1>
                                </div>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <p class="text-xs font-medium text-slate-500 hidden sm:block">
                                        Sistem Informasi Bantuan Sosial Pendidikan Kabupaten Teluk Bintuni
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- System Status & Quick Actions Header Hub -->
                        <div class="flex items-center gap-3">
                            <!-- Live Status Indicator Pill -->
                            <div class="hidden xl:flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50/80 px-3 py-1.2 text-xs font-semibold text-slate-600">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                <span>System Operational</span>
                                <span class="text-slate-300">|</span>
                                <span class="text-slate-500 font-mono text-[11px]">{{ date('D, d M Y') }}</span>
                            </div>

                            <!-- Notification Pill (Simulated) -->
                            <div class="relative">
                                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200/80 bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                    </svg>
                                    <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                                </button>
                            </div>

                            <!-- User Profile Header Section -->
                            <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                                <div class="hidden md:flex flex-col items-end">
                                    <span class="text-sm font-extrabold text-slate-900 leading-tight">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 mt-0.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        {{ Auth::user()->roles->pluck('name')->map(fn ($r) => $r === 'Operator' ? 'Dinas Pendidikan' : $r)->join(', ') ?: 'Mahasiswa' }}
                                    </span>
                                </div>

                                <x-dropdown align="right" width="56">
                                    <x-slot name="trigger">
                                        <button class="relative flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 via-teal-700 to-emerald-800 text-sm font-extrabold text-white shadow-md shadow-emerald-950/20 hover:scale-105 transition-transform focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                            {{ Str::of(Auth::user()->name)->substr(0, 1)->upper() }}
                                            <span class="absolute bottom-0 right-0 h-3.5 w-3.5 rounded-full bg-emerald-400 border-2 border-white"></span>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="px-4 py-3 border-b border-slate-100">
                                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Signed in as</p>
                                            <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                        </div>

                                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 font-medium">
                                            <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <span>Pengaturan Profil</span>
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="flex items-center gap-2 font-semibold text-rose-600 hover:bg-rose-50 hover:text-rose-700"
                                            >
                                                <svg class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                                </svg>
                                                <span>Keluar (Logout)</span>
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main Content Area -->
                <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>

                <!-- Footer -->
                <footer class="mt-auto border-t border-slate-200/80 bg-white px-6 py-4">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-slate-900">DIBANSOS BINTUNI</span>
                            <span>&bull;</span>
                            <span>Digitalisasi Bantuan Sosial Pendidikan Kabupaten Teluk Bintuni</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center gap-1 font-semibold text-slate-600">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Demo Mode Isolated
                            </span>
                            <span>&bull;</span>
                            <span>&copy; {{ date('Y') }} Pemerintah Kabupaten Teluk Bintuni.</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
