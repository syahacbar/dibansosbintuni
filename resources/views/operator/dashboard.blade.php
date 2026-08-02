<x-app-layout>
    <x-slot name="header">
        Dashboard Verifikasi Operator
    </x-slot>

    <div class="space-y-6">
        <!-- Header Banner -->
        <div class="rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-teal-950 p-6 text-white shadow-xl shadow-slate-900/10 border border-slate-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                        Dashboard Verifikasi Dinas Pendidikan
                    </h2>
                    <p class="mt-1 text-sm text-slate-300">
                        Pantauan pengajuan bantuan sosial pendidikan Kabupaten Teluk Bintuni.
                    </p>
                </div>
                <a
                    href="{{ route('operator.pengajuan.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-emerald-900/30 hover:bg-emerald-400 transition-all self-start md:self-auto"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z" />
                    </svg>
                    <span>Mulai Verifikasi</span>
                </a>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pengajuan</p>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $stats['total'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Seluruh berkas terdaftar</p>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Draft Mahasiswa</p>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $stats['draft'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Belum disubmit final</p>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Pengajuan Diajukan</p>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $stats['diajukan'] }}</p>
                <p class="mt-1 text-xs text-slate-500">Siap untuk diverifikasi</p>
            </div>
        </div>

        <!-- Recent Submissions Section -->
        <section class="rounded-2xl border border-slate-200/80 bg-white shadow-sm overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-200/80 px-6 py-4 gap-3 bg-slate-50/50">
                <div>
                    <h3 class="text-base font-bold text-slate-950">Pengajuan Terbaru</h3>
                    <p class="text-xs text-slate-500">Daftar pengajuan masuk terkini yang membutuhkan perhatian.</p>
                </div>
                <a href="{{ route('operator.pengajuan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700">
                    <span>Lihat Semua Pengajuan</span>
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200/80">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Nomor Pengajuan</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Nama Mahasiswa</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Jenis Bantuan</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3.5 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($stats['latest'] as $pengajuan)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-slate-900">
                                    <a href="{{ route('operator.pengajuan.show', $pengajuan) }}" class="text-emerald-700 hover:text-emerald-900 hover:underline">
                                        {{ $pengajuan->nomor_pengajuan }}
                                    </a>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-800">
                                    {{ $pengajuan->user?->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                    {{ $pengajuan->jenisBantuan?->nama }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $pengajuan->status->label() }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('operator.pengajuan.show', $pengajuan) }}" class="inline-flex items-center gap-1 rounded-lg bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-800 transition-all">
                                        <span>Detail</span>
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">
                                    Belum ada data pengajuan terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
