<x-app-layout>
    <x-slot name="header">
        Dashboard Mahasiswa
    </x-slot>

    <div class="space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold text-slate-950">Dashboard Mahasiswa</h1>
                <p class="mt-1 text-sm text-slate-500">Pantau status, timeline, catatan operator, dan riwayat pengajuan bantuan.</p>
            </div>
            <a href="{{ route('mahasiswa.pengajuan.create') }}" class="inline-flex items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                Buat Pengajuan
            </a>
        </div>

        <div class="grid gap-4 md:grid-cols-4">
            @foreach ([
                'Total' => $summary['total'],
                'Draft' => $summary['draft'],
                'Diajukan' => $summary['diajukan'],
                'Selesai' => $summary['selesai'],
            ] as $label => $value)
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-4 lg:grid-cols-3">
            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <h2 class="text-base font-semibold text-slate-950">Status Pengajuan Terbaru</h2>

                @if ($latestPengajuan)
                    <dl class="mt-4 grid gap-4 md:grid-cols-2">
                        @foreach ([
                            'Nomor Pengajuan' => $latestPengajuan->nomor_pengajuan,
                            'Status' => $latestPengajuan->status->label(),
                            'Periode' => $latestPengajuan->periodeBansos?->nama,
                            'Jenis Bantuan' => $latestPengajuan->jenisBantuan?->nama,
                            'Verification Score' => $latestPengajuan->verification_score !== null ? $latestPengajuan->verification_score.'/100' : '-',
                            'Tanggal Verifikasi' => $latestPengajuan->verified_at?->format('d/m/Y H:i') ?: '-',
                        ] as $label => $value)
                            <div>
                                <dt class="text-sm font-medium text-slate-500">{{ $label }}</dt>
                                <dd class="mt-1 text-sm text-slate-950">{{ $value ?: '-' }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    <div class="mt-5 rounded-lg bg-slate-50 p-4">
                        <p class="text-sm font-medium text-slate-500">Catatan Operator</p>
                        <p class="mt-2 text-sm text-slate-900">{{ $latestPengajuan->verification_notes ?: 'Belum ada catatan operator.' }}</p>
                    </div>
                @else
                    <div class="mt-4 rounded-lg border border-dashed border-slate-300 p-6 text-center text-sm text-slate-500">
                        Belum ada pengajuan bantuan.
                    </div>
                @endif
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Timeline</h2>

                @if ($latestPengajuan && $latestPengajuan->timelines->isNotEmpty())
                    <ol class="mt-4 space-y-4">
                        @foreach ($latestPengajuan->timelines as $timeline)
                            <li class="relative border-l border-slate-200 pl-4">
                                <span class="absolute -left-1.5 top-1.5 h-3 w-3 rounded-full bg-slate-700"></span>
                                <p class="text-sm font-semibold text-slate-950">{{ $timeline->label }}</p>
                                <p class="mt-1 text-sm text-slate-600">{{ $timeline->description }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $timeline->occurred_at->format('d/m/Y H:i') }}</p>
                            </li>
                        @endforeach
                    </ol>
                @else
                    <p class="mt-4 text-sm text-slate-500">Timeline belum tersedia.</p>
                @endif
            </section>
        </div>

        <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-950">Riwayat Pengajuan</h2>
                <a href="{{ route('mahasiswa.pengajuan.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nomor</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Periode</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jenis Bantuan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($history as $pengajuan)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-900">{{ $pengajuan->nomor_pengajuan }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->periodeBansos?->nama }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->jenisBantuan?->nama }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->status->label() }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm">
                                    <a href="{{ route('mahasiswa.pengajuan.show', $pengajuan) }}" class="font-medium text-blue-600 hover:text-blue-800">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada riwayat pengajuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
