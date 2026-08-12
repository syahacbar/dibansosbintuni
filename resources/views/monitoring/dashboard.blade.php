<x-app-layout>
    <x-slot name="header">
        Executive Monitoring Dashboard
    </x-slot>

    <div class="space-y-6">
        <!-- Control & Filter Hub Banner -->
        <div class="rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-teal-950 p-6 sm:p-8 text-white shadow-2xl shadow-slate-950/20 border border-slate-800/80 relative overflow-hidden">
            <!-- Background Glow Orbs -->
            <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-teal-500/10 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-bold text-emerald-400 border border-emerald-500/30 mb-3">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>EXECUTIVE MONITORING CENTER</span>
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                        Monitoring Bantuan Sosial Pendidikan
                    </h1>
                    <p class="mt-1.5 text-sm text-slate-300 max-w-2xl leading-relaxed">
                        Visualisasi analitik, distribusi pengajuan, status verifikasi, dan penyaluran dana bantuan sosial Kabupaten Teluk Bintuni.
                    </p>
                </div>

                <!-- Action Toolbar Chips -->
                <div class="flex flex-wrap items-center gap-3">
                    <div class="inline-flex items-center gap-2 rounded-xl bg-slate-900/90 border border-slate-700/80 px-3.5 py-2 text-xs font-semibold text-slate-200">
                        <svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <span>Periode: <strong>2026/2027 (Aktif)</strong></span>
                    </div>

                    <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-emerald-950/40 transition-all hover:scale-105">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        <span>Export Laporan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- High-Tech KPI Stat Cards Grid -->
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Mahasiswa Card -->
            <div class="group rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Total Mahasiswa</span>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 group-hover:scale-110 transition-transform shadow-xs">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6 0 3.375 3.375 0 0 1 6 0Z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-950 tracking-tight">{{ $widgets['total_mahasiswa'] }}</span>
                    <span class="inline-flex items-center gap-0.5 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                        +12.4%
                    </span>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                    <span>Terverifikasi Aktif</span>
                    <span class="font-bold text-slate-700">94.2%</span>
                </div>
                <div class="mt-1.5 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-1.5 rounded-full bg-indigo-500" style="width: 94.2%"></div>
                </div>
            </div>

            <!-- Total Pengajuan Card -->
            <div class="group rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Total Pengajuan</span>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 group-hover:scale-110 transition-transform shadow-xs">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-950 tracking-tight">{{ $widgets['total_pengajuan'] }}</span>
                    <span class="inline-flex items-center gap-0.5 text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">
                        Submisi Real-time
                    </span>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                    <span>Target Kelayakan</span>
                    <span class="font-bold text-slate-700">100%</span>
                </div>
                <div class="mt-1.5 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-1.5 rounded-full bg-blue-500" style="width: 82%"></div>
                </div>
            </div>

            <!-- Total Verifikasi Card -->
            <div class="group rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Total Verifikasi Lolos</span>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 group-hover:scale-110 transition-transform shadow-xs">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-950 tracking-tight">{{ $widgets['total_verifikasi'] }}</span>
                    <span class="inline-flex items-center gap-0.5 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                        Approval 88.5%
                    </span>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                    <span>Siap Penyaluran</span>
                    <span class="font-bold text-emerald-600">Terverifikasi</span>
                </div>
                <div class="mt-1.5 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-1.5 rounded-full bg-emerald-500" style="width: 88.5%"></div>
                </div>
            </div>

            <!-- Total Ditolak Card -->
            <div class="group rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Ditolak / Incomplete</span>
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 group-hover:scale-110 transition-transform shadow-xs">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-950 tracking-tight">{{ $widgets['total_ditolak'] }}</span>
                    <span class="inline-flex items-center gap-0.5 text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                        Berkas Belum Sesuai
                    </span>
                </div>
                <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                    <span>Tingkat Penolakan</span>
                    <span class="font-bold text-rose-600">11.5%</span>
                </div>
                <div class="mt-1.5 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-1.5 rounded-full bg-rose-500" style="width: 11.5%"></div>
                </div>
            </div>
        </div>

        <!-- Visual Analytics Grid (Charts & Status Distribution) -->
        <div class="grid gap-6 xl:grid-cols-3">
            <!-- Interactive Monthly Trend Chart Card -->
            <section class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm xl:col-span-2">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-950">Grafik Tren Penyaluran & Pengajuan Bulanan</h3>
                        <p class="mt-0.5 text-xs text-slate-500">Visualisasi dinamika data pengajuan mahasiswa sepanjang periode aktif.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <span class="h-3 w-3 rounded-md bg-emerald-500"></span> Pengajuan Lolos
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                            <span class="h-3 w-3 rounded-md bg-slate-800"></span> Total Submisi
                        </span>
                    </div>
                </div>

                @php($maxValue = collect($dummyChart)->max('value') ?: 1)
                <div class="mt-8 flex h-72 items-end gap-3 sm:gap-6 border-b border-l border-slate-200 px-4 pb-4">
                    @foreach ($dummyChart as $point)
                        <div class="flex flex-1 flex-col items-center gap-2 group relative">
                            <!-- Tooltip callout on hover -->
                            <div class="absolute -top-10 opacity-0 group-hover:opacity-100 transition-opacity bg-slate-950 text-white text-[11px] font-bold px-2 py-1 rounded-md shadow-lg pointer-events-none z-20 whitespace-nowrap">
                                {{ $point['label'] }}: {{ $point['value'] }} berkas
                            </div>

                            <div class="flex h-56 w-full items-end justify-center">
                                <div
                                    class="w-full max-w-[40px] rounded-t-xl bg-gradient-to-t from-slate-950 via-teal-800 to-emerald-500 transition-all duration-300 group-hover:from-emerald-700 group-hover:to-teal-400 shadow-md group-hover:scale-105"
                                    style="height: {{ max(12, ($point['value'] / $maxValue) * 100) }}%"
                                ></div>
                            </div>
                            <span class="text-xs font-extrabold text-slate-600 group-hover:text-emerald-600 transition-colors">{{ $point['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Status Distribution Donut & Progress Widget -->
            <section class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-base font-extrabold text-slate-950">Distribusi Status Pengajuan</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Persentase proporsi seluruh berkas di sistem.</p>
                </div>

                @php($statusMax = max($statusDistribution ?: [1]))
                <div class="mt-6 space-y-5">
                    @foreach ($statusDistribution as $label => $value)
                        <div>
                            <div class="mb-1.5 flex items-center justify-between text-xs font-bold">
                                <span class="text-slate-800">{{ $label }}</span>
                                <span class="rounded-lg bg-slate-100 px-2.5 py-0.5 text-slate-900 font-extrabold border border-slate-200/60">{{ $value }} berkas</span>
                            </div>
                            <div class="h-3 rounded-full bg-slate-100 overflow-hidden">
                                <div
                                    class="h-3 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 transition-all duration-500"
                                    style="width: {{ $statusMax > 0 ? ($value / $statusMax) * 100 : 0 }}%"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 rounded-2xl bg-emerald-50/60 border border-emerald-200/80 p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white font-bold text-xs">
                            i
                        </div>
                        <div>
                            <p class="text-xs font-bold text-emerald-950">Informasi Monitoring</p>
                            <p class="mt-0.5 text-xs leading-relaxed text-emerald-800">
                                Seluruh berkas diverifikasi bertingkat oleh Tim Administrasi Dinas Pendidikan Teluk Bintuni.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Quick Activity Log Stream -->
        <section class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-extrabold text-slate-950">Aktivitas & Log Audit Terkini</h3>
                    <p class="text-xs text-slate-500">Jejak aktivitas transaksi data dalam sistem DIBANSOS BINTUNI.</p>
                </div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                    Live Stream Audit
                </span>
            </div>

            <div class="mt-6 space-y-4">
                <div class="flex items-start gap-4 rounded-2xl border border-slate-100 p-4 hover:bg-slate-50/80 transition-colors">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 font-bold">
                        ✓
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-900">Penyaluran Dana Bantuan Disetujui</p>
                        <p class="text-xs text-slate-500 mt-0.5">Operator Dinas telah menyetujui pengajuan #REQ-2026-008 atas nama Mahasiswa Teluk Bintuni.</p>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400 shrink-0">10 menit yang lalu</span>
                </div>

                <div class="flex items-start gap-4 rounded-2xl border border-slate-100 p-4 hover:bg-slate-50/80 transition-colors">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700 font-bold">
                        📄
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-900">Upload Dokumen KHS Baru</p>
                        <p class="text-xs text-slate-500 mt-0.5">Mahasiswa mengunggah berkas KHS semester ganjil untuk verifikasi tahap 2.</p>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400 shrink-0">45 menit yang lalu</span>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
