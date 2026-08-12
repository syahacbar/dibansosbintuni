<x-app-layout>
    <x-slot name="header">
        Portal Utama DIBANSOS BINTUNI
    </x-slot>

    <div class="space-y-6">
        <!-- Hero Command Card -->
        <div class="rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-teal-950 p-6 sm:p-10 text-white shadow-2xl shadow-slate-950/20 border border-slate-800/80 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full bg-emerald-500/20 px-3.5 py-1 text-xs font-extrabold text-emerald-400 border border-emerald-500/30 mb-4">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>SISTEM INFORMASI DIGITAL BANTUAN SOSIAL</span>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl leading-tight">
                    Kabupaten Teluk Bintuni
                </h1>
                <p class="mt-3 text-sm sm:text-base leading-relaxed text-slate-300">
                    Portal terpadu pengajuan, verifikasi, dan monitoring bantuan sosial pendidikan bagi mahasiswa asal Kabupaten Teluk Bintuni.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    @if (Auth::user()->hasRole('Super Admin'))
                        <a href="{{ route('monitoring.dashboard') }}" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 px-5 py-3 text-xs font-extrabold text-white shadow-lg shadow-emerald-950/40 hover:from-emerald-400 hover:to-teal-500 transition-all hover:scale-105">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3 1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9 3-3 2.143 2.143L15.428 7.5" />
                            </svg>
                            <span>Buka Monitoring Executive</span>
                        </a>
                        <a href="{{ route('super-admin.users.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 border border-slate-700 px-5 py-3 text-xs font-extrabold text-slate-200 hover:bg-slate-800 transition-all">
                            <span>Manajemen User</span>
                        </a>
                    @elseif (Auth::user()->hasRole('Operator'))
                        <a href="{{ route('operator.dashboard') }}" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 px-5 py-3 text-xs font-extrabold text-white shadow-lg shadow-emerald-950/40 hover:from-emerald-400 hover:to-teal-500 transition-all hover:scale-105">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z" />
                            </svg>
                            <span>Buka Verifikasi Operator</span>
                        </a>
                    @else
                        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 px-5 py-3 text-xs font-extrabold text-white shadow-lg shadow-emerald-950/40 hover:from-emerald-400 hover:to-teal-500 transition-all hover:scale-105">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Mulai Buat Pengajuan</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Access Feature Cards Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-lg transition-all">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 font-bold text-lg mb-4">
                    📁
                </div>
                <h3 class="text-base font-extrabold text-slate-950">Syarat Berkas Digital</h3>
                <p class="mt-1 text-xs text-slate-500 leading-relaxed">
                    Upload KTP, Kartu Keluarga, KTM, KHS Semester, dan Surat Aktif Kuliah langsung dalam format digital.
                </p>
            </div>

            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-lg transition-all">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 font-bold text-lg mb-4">
                    🛡️
                </div>
                <h3 class="text-base font-extrabold text-slate-950">Verifikasi Transparan</h3>
                <p class="mt-1 text-xs text-slate-500 leading-relaxed">
                    Pemeriksaan syarat berkas secara bertingkat dengan catatan verifikasi langsung dari Tim Dinas Pendidikan.
                </p>
            </div>

            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-lg transition-all">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 font-bold text-lg mb-4">
                    📊
                </div>
                <h3 class="text-base font-extrabold text-slate-950">Laporan Real-Time</h3>
                <p class="mt-1 text-xs text-slate-500 leading-relaxed">
                    Monitor statistik pengajuan, kelayakan penerima, dan ekspor laporan resmi format PDF & Excel.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
