<x-app-layout>
    <x-slot name="header">
        Daftar Pengajuan
    </x-slot>

    <div class="space-y-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-950">Daftar Pengajuan</h1>
            <p class="mt-1 text-sm text-slate-500">Cari dan filter pengajuan bantuan mahasiswa.</p>
        </div>

        <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-4">
                <form method="GET" action="{{ route('operator.pengajuan.index') }}" class="grid gap-3 lg:grid-cols-5">
                    <input
                        type="search"
                        name="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Cari nomor, mahasiswa, bantuan"
                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500 lg:col-span-2"
                    >
                    <select name="status" class="rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        <option value="">Semua status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    <select name="periode_bansos_id" class="rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        <option value="">Semua periode</option>
                        @foreach ($periodes as $periode)
                            <option value="{{ $periode->id }}" @selected((string) ($filters['periode_bansos_id'] ?? '') === (string) $periode->id)>{{ $periode->nama }}</option>
                        @endforeach
                    </select>
                    <select name="jenis_bantuan_id" class="rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        <option value="">Semua bantuan</option>
                        @foreach ($jenisBantuans as $jenisBantuan)
                            <option value="{{ $jenisBantuan->id }}" @selected((string) ($filters['jenis_bantuan_id'] ?? '') === (string) $jenisBantuan->id)>{{ $jenisBantuan->nama }}</option>
                        @endforeach
                    </select>
                    <div class="flex gap-2 lg:col-span-5">
                        <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Terapkan</button>
                        <a href="{{ route('operator.pengajuan.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Nomor</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Mahasiswa</th>
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
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->user?->name }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->periodeBansos?->nama }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $pengajuan->jenisBantuan?->nama }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm">
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $pengajuan->status->value === 'diajukan' ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $pengajuan->status->label() }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm">
                                    <a href="{{ route('operator.pengajuan.show', $pengajuan) }}" class="font-medium text-blue-600 hover:text-blue-800">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Data pengajuan tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-4 py-3">
                {{ $pengajuans->links() }}
            </div>
        </section>
    </div>
</x-app-layout>
