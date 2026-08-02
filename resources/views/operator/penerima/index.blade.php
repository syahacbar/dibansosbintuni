<x-app-layout>
    <x-slot name="header">
        Daftar Penerima Bantuan Sosial
    </x-slot>

    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-slate-950">Daftar Penerima Bantuan Sosial</h1>
                <p class="mt-1 text-sm text-slate-500">Daftar mahasiswa penerima bantuan yang telah disetujui dan disalurkan oleh Dinas Pendidikan.</p>
            </div>
            <div class="flex gap-2">
                <a
                    href="{{ route('reports.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50"
                >
                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Cetak / Ekspor Laporan
                </a>
            </div>
        </div>

        <!-- Filter Bar -->
        <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
            <form method="GET" action="{{ route('operator.penerima.index') }}" class="grid gap-4 md:grid-cols-4">
                <div class="md:col-span-2">
                    <label for="search" class="sr-only">Cari</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Cari nama mahasiswa, NIM, NIK, atau no. pengajuan..."
                        class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500"
                    />
                </div>

                <div>
                    <label for="periode_bansos_id" class="sr-only">Periode</label>
                    <select name="periode_bansos_id" id="periode_bansos_id" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        <option value="">Semua Periode</option>
                        @foreach ($periodes as $periode)
                            <option value="{{ $periode->id }}" @selected((string) ($filters['periode_bansos_id'] ?? '') === (string) $periode->id)>{{ $periode->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <select name="jenis_bantuan_id" id="jenis_bantuan_id" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        <option value="">Semua Jenis Bantuan</option>
                        @foreach ($jenisBantuans as $jenis)
                            <option value="{{ $jenis->id }}" @selected((string) ($filters['jenis_bantuan_id'] ?? '') === (string) $jenis->id)>{{ $jenis->nama }}</option>
                        @endforeach
                    </select>

                    <button
                        type="submit"
                        class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700"
                    >
                        Filter
                    </button>
                </div>
            </form>
        </section>

        <!-- Table List -->
        <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">No. Pengajuan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama Mahasiswa</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Perguruan Tinggi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jenis Bantuan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">No. SP2D / Penyaluran</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($pengajuans as $pengajuan)
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-900">
                                {{ $pengajuan->nomor_pengajuan }}
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-900">
                                <div class="font-semibold">{{ $pengajuan->user->name }}</div>
                                <div class="text-xs text-slate-500">NIM: {{ $pengajuan->user->mahasiswaProfile?->nim ?? '-' }} | Bank: {{ $pengajuan->user->mahasiswaProfile?->nama_bank ?? '-' }} ({{ $pengajuan->user->mahasiswaProfile?->nomor_rekening ?? '-' }})</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700">
                                {{ $pengajuan->user->mahasiswaProfile?->perguruan_tinggi_nama ?? '-' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">
                                {{ $pengajuan->jenisBantuan?->nama }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm">
                                @if ($pengajuan->status === \App\Enums\PengajuanStatus::Disalurkan)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800">
                                        Disalurkan
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                        Disetujui (Siap Salur)
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700">
                                @if ($pengajuan->nomor_sp2d)
                                    <div class="font-medium text-slate-900">{{ $pengajuan->nomor_sp2d }}</div>
                                    <div class="text-xs text-slate-500">{{ $pengajuan->disalurkan_at?->format('d M Y') }}</div>
                                @else
                                    <span class="text-xs text-slate-400">Belum disalurkan</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-medium">
                                <a
                                    href="{{ route('operator.pengajuan.show', $pengajuan) }}"
                                    class="text-slate-900 hover:text-slate-600 hover:underline"
                                >
                                    Detail / Verifikasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">
                                Belum ada daftar penerima bantuan sosial yang disetujui/disalurkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $pengajuans->links() }}
        </div>
    </div>
</x-app-layout>
