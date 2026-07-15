<x-app-layout>
    <x-slot name="header">
        Dashboard Operator
    </x-slot>

    <div class="space-y-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-950">Dashboard Operator</h1>
            <p class="mt-1 text-sm text-slate-500">Pantauan read-only pengajuan bantuan mahasiswa.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            @foreach ([
                'Total Pengajuan' => $stats['total'],
                'Draft' => $stats['draft'],
                'Diajukan' => $stats['diajukan'],
            ] as $label => $value)
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-950">Pengajuan Terbaru</h2>
                <a href="{{ route('operator.pengajuan.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nomor</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Mahasiswa</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Jenis Bantuan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($stats['latest'] as $pengajuan)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-900">
                                    <a href="{{ route('operator.pengajuan.show', $pengajuan) }}" class="hover:text-blue-700">{{ $pengajuan->nomor_pengajuan }}</a>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->user?->name }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->jenisBantuan?->nama }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->status->label() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada pengajuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
