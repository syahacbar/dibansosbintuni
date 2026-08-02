<x-app-layout>
    <x-slot name="header">
        Dashboard Monitoring Executive
    </x-slot>

    <div class="space-y-6">
        <!-- Header Section -->
        <div class="rounded-2xl bg-gradient-to-r from-slate-950 via-slate-900 to-teal-950 p-6 text-white shadow-xl border border-slate-800">
            <h2 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                Dashboard Monitoring Executive
            </h2>
            <p class="mt-1 text-sm text-slate-300">
                Ringkasan statistik real-time DIBANSOS BINTUNI (Digitalisasi Bantuan Sosial Pendidikan Kabupaten Teluk Bintuni).
            </p>
        </div>

        <!-- Metric Stat Cards -->
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Mahasiswa</p>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6 0 3.375 3.375 0 0 1 6 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $widgets['total_mahasiswa'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Terdaftar dalam sistem</p>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pengajuan</p>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $widgets['total_pengajuan'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Berkas diajukan</p>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Verifikasi</p>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $widgets['total_verifikasi'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Lolos verifikasi dinas</p>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Ditolak</p>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $widgets['total_ditolak'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Tidak memenuhi kriteria</p>
            </div>
        </div>

        <!-- Chart & Distribution Section -->
        <div class="grid gap-6 xl:grid-cols-3">
            <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm xl:col-span-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-950">Grafik Tren Pengajuan Bulanan</h3>
                        <p class="mt-0.5 text-xs text-slate-500">Data visualisasi simulasi tren pengajuan bantuan.</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Demo Real-Time
                    </span>
                </div>

                @php($maxValue = collect($dummyChart)->max('value') ?: 1)
                <div class="mt-8 flex h-72 items-end gap-3 sm:gap-6 border-b border-l border-slate-200 px-4 pb-4">
                    @foreach ($dummyChart as $point)
                        <div class="flex flex-1 flex-col items-center gap-2 group">
                            <div class="flex h-56 w-full items-end justify-center">
                                <div
                                    class="w-full max-w-[42px] rounded-t-xl bg-gradient-to-t from-slate-900 to-emerald-600 transition-all duration-300 group-hover:from-emerald-700 group-hover:to-teal-500 shadow-md"
                                    style="height: {{ max(10, ($point['value'] / $maxValue) * 100) }}%"
                                    title="{{ $point['label'] }}: {{ $point['value'] }}"
                                ></div>
                            </div>
                            <span class="text-xs font-bold text-slate-600 group-hover:text-emerald-600 transition-colors">{{ $point['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
                <h3 class="text-base font-bold text-slate-950">Distribusi Status Pengajuan</h3>
                <p class="mt-0.5 text-xs text-slate-500">Proporsi status berkas saat ini.</p>

                @php($statusMax = max($statusDistribution ?: [1]))
                <div class="mt-6 space-y-5">
                    @foreach ($statusDistribution as $label => $value)
                        <div>
                            <div class="mb-1.5 flex items-center justify-between text-xs font-semibold">
                                <span class="text-slate-800">{{ $label }}</span>
                                <span class="rounded-md bg-slate-100 px-2 py-0.5 text-slate-700 font-bold">{{ $value }}</span>
                            </div>
                            <div class="h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                <div
                                    class="h-2.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 transition-all duration-500"
                                    style="width: {{ $statusMax > 0 ? ($value / $statusMax) * 100 : 0 }}%"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
