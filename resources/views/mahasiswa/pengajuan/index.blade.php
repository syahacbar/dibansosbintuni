<x-app-layout>
    <x-slot name="header">
        Pengajuan Bantuan
    </x-slot>

    <div class="space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold text-slate-950">Pengajuan Bantuan</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola draft dan pengajuan bantuan mahasiswa.</p>
            </div>

            <a href="{{ route('mahasiswa.pengajuan.create') }}" class="inline-flex items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                Buat Pengajuan
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
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
                        @forelse ($pengajuans as $pengajuan)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-900">{{ $pengajuan->nomor_pengajuan }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->periodeBansos?->nama }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->jenisBantuan?->nama }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm">
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $pengajuan->isDraft() ? 'bg-slate-100 text-slate-700' : 'bg-blue-50 text-blue-700' }}">
                                        {{ $pengajuan->status->label() }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('mahasiswa.pengajuan.show', $pengajuan) }}" class="font-medium text-slate-600 hover:text-slate-950">Detail</a>
                                        @if ($pengajuan->isDraft())
                                            <a href="{{ route('mahasiswa.pengajuan.edit', $pengajuan) }}" class="font-medium text-blue-600 hover:text-blue-800">Edit</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada pengajuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-4 py-3">
                {{ $pengajuans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
