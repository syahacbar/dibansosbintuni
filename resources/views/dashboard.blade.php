<x-app-layout>
    <x-slot name="header">
        Dashboard Overview
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl bg-gradient-to-r from-slate-950 via-slate-900 to-teal-950 p-8 text-white shadow-xl border border-slate-800">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-semibold text-emerald-400 border border-emerald-500/30 mb-4">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Selamat Datang, {{ Auth::user()->name }}</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                    DIBANSOS BINTUNI
                </h1>
                <p class="mt-2 text-sm leading-relaxed text-slate-300">
                    Sistem Informasi Digitalisasi Bantuan Sosial Pendidikan Kabupaten Teluk Bintuni. Silakan pilih menu di sidebar kiri untuk mengelola data dan melihat statistik.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    @if (Auth::user()->hasRole('Super Admin'))
                        <a href="{{ route('monitoring.dashboard') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2.5 text-xs font-bold text-white shadow-md hover:bg-emerald-400 transition-all">
                            <span>Monitoring Dashboard</span>
                        </a>
                    @elseif (Auth::user()->hasRole('Operator'))
                        <a href="{{ route('operator.dashboard') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2.5 text-xs font-bold text-white shadow-md hover:bg-emerald-400 transition-all">
                            <span>Dashboard Verifikasi</span>
                        </a>
                    @else
                        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2.5 text-xs font-bold text-white shadow-md hover:bg-emerald-400 transition-all">
                            <span>Pengajuan Saya</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
