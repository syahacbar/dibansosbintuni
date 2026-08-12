<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gradient-to-br from-slate-50 via-teal-50/40 to-emerald-50/60">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DIBANSOS BINTUNI — Portal Inovasi Pelayanan Publik</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Vite Assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans antialiased text-slate-900 bg-gradient-to-br from-slate-50 via-teal-50/30 to-emerald-50/40 selection:bg-emerald-600 selection:text-white relative overflow-x-hidden">
        <!-- Soft Background Ambient Lights -->
        <div class="fixed -top-20 left-1/3 h-[32rem] w-[32rem] rounded-full bg-emerald-400/20 blur-[130px] pointer-events-none"></div>
        <div class="fixed bottom-0 right-1/4 h-[35rem] w-[35rem] rounded-full bg-teal-400/25 blur-[140px] pointer-events-none"></div>

        <!-- Navigation Header Bar -->
        <header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-md shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <x-application-logo class="h-12 w-auto max-w-[220px] object-contain" />
                    <div>
                        <span class="rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold px-2.5 py-0.5 border border-emerald-300">OFFICIAL PORTAL</span>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Pemerintah Kabupaten Teluk Bintuni</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-xs font-extrabold text-white shadow-md hover:bg-emerald-700 transition-all">
                            <span>Buka Dashboard</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-xs font-extrabold text-slate-700 hover:bg-slate-50 transition-all">
                            Masuk Portal
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-700 px-5 py-2.5 text-xs font-extrabold text-white shadow-md hover:from-emerald-700 hover:to-teal-800 transition-all">
                            Daftar Mahasiswa
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Hero Section -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Hero Content -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-300 bg-emerald-50 px-4 py-1.5 text-xs font-extrabold text-emerald-800 shadow-2xs">
                        <span class="h-2 w-2 rounded-full bg-emerald-600 animate-ping"></span>
                        <span>Sistem Informasi Bantuan Sosial Pendidikan Terintegrasi</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-none">
                        Digitalisasi <span class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-800 bg-clip-text text-transparent">Bantuan Sosial</span> Pendidikan Bintuni
                    </h1>

                    <p class="text-base sm:text-lg font-medium text-slate-600 max-w-2xl leading-relaxed">
                        Portal inovasi pelayanan publik Dinas Pendidikan & Kebudayaan Kabupaten Teluk Bintuni untuk transparansi, efisiensi verifikasi 3-layer, dan penyaluran beasiswa tepat sasaran bagi mahasiswa OAP & Nusantara.
                    </p>

                    <!-- Feature Pillars Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                        <div class="rounded-2xl border border-slate-200/90 bg-white/90 p-4 shadow-sm backdrop-blur-xs">
                            <div class="h-10 w-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-800 font-extrabold mb-3">
                                01
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-900">Mandiri & Transparan</h3>
                            <p class="text-xs text-slate-500 mt-1">Registrasi mandiri mahasiswa & pelacakan status realtime.</p>
                        </div>

                        <div class="rounded-2xl border border-slate-200/90 bg-white/90 p-4 shadow-sm backdrop-blur-xs">
                            <div class="h-10 w-10 rounded-xl bg-teal-100 flex items-center justify-center text-teal-800 font-extrabold mb-3">
                                02
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-900">Verifikasi 3 Layer</h3>
                            <p class="text-xs text-slate-500 mt-1">Auto-Validation, Smart Scoring, & Verifikasi Operator.</p>
                        </div>

                        <div class="rounded-2xl border border-slate-200/90 bg-white/90 p-4 shadow-sm backdrop-blur-xs">
                            <div class="h-10 w-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-800 font-extrabold mb-3">
                                03
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-900">Pencairan SP2D</h3>
                            <p class="text-xs text-slate-500 mt-1">Integrasi nomor SP2D & pencairan Bank Papua.</p>
                        </div>
                    </div>

                    <!-- Call To Actions -->
                    <div class="flex flex-wrap items-center gap-4 pt-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 via-teal-700 to-emerald-700 px-8 py-4 text-sm font-extrabold text-white shadow-xl shadow-emerald-950/20 hover:scale-[1.02] transition-all">
                            <span>Mulai Akses Pameran</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-300 bg-white px-6 py-4 text-sm font-extrabold text-emerald-800 hover:bg-emerald-50 transition-all shadow-sm">
                            <span>Daftar Akun Mahasiswa</span>
                        </a>
                    </div>
                </div>

                <!-- Right Exhibition Hero Card -->
                <div class="lg:col-span-5">
                    <div class="rounded-3xl border border-white/80 bg-white/95 p-6 sm:p-8 shadow-2xl shadow-emerald-950/10 backdrop-blur-2xl relative overflow-hidden">
                        <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-emerald-600 via-teal-500 to-emerald-700"></div>

                        <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                            <div>
                                <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700">Uji Coba Pameran Pelayanan</span>
                                <h2 class="text-lg font-extrabold text-slate-900">Akses Role Demo</h2>
                            </div>
                            <span class="rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold px-3 py-1">LIVE DEMO</span>
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('login') }}" class="block rounded-2xl border border-slate-200/90 bg-slate-50/80 p-4 hover:border-emerald-400 hover:bg-emerald-50/40 transition-all group">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-extrabold text-slate-900 group-hover:text-emerald-700">Super Admin</span>
                                    <span class="text-[10px] font-bold bg-slate-200 group-hover:bg-emerald-600 group-hover:text-white text-slate-700 px-2 py-0.5 rounded">admin@example.com</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">Akses kontrol sistem, User, Role, Master Data & Monitoring Executive.</p>
                            </a>

                            <a href="{{ route('login') }}" class="block rounded-2xl border border-slate-200/90 bg-slate-50/80 p-4 hover:border-emerald-400 hover:bg-emerald-50/40 transition-all group">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-extrabold text-slate-900 group-hover:text-emerald-700">Operator Dinas</span>
                                    <span class="text-[10px] font-bold bg-slate-200 group-hover:bg-emerald-600 group-hover:text-white text-slate-700 px-2 py-0.5 rounded">operator@example.com</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">Verifikasi berkas 3-layer, rekomendasi, dan penerbitan SP2D.</p>
                            </a>

                            <a href="{{ route('login') }}" class="block rounded-2xl border border-slate-200/90 bg-slate-50/80 p-4 hover:border-emerald-400 hover:bg-emerald-50/40 transition-all group">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-extrabold text-slate-900 group-hover:text-emerald-700">Mahasiswa</span>
                                    <span class="text-[10px] font-bold bg-slate-200 group-hover:bg-emerald-600 group-hover:text-white text-slate-700 px-2 py-0.5 rounded">mahasiswa@example.com</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">Upload dokumen KTP/KTM/KHS & pelacakan status penyaluran bantuan.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer Bar -->
        <footer class="border-t border-slate-200/80 bg-white/80 backdrop-blur-md py-6 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-semibold text-slate-500">
                <p>&copy; {{ date('Y') }} Pemerintah Kabupaten Teluk Bintuni &bull; Dinas Pendidikan & Kebudayaan.</p>
                <div class="flex items-center gap-2 text-emerald-800">
                    <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                    <span>Pelayanan Sosial Pendidikan Terintegrasi</span>
                </div>
            </div>
        </footer>
    </body>
</html>
