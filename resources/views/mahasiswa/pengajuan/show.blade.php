<x-app-layout>
    <x-slot name="header">
        Detail Pengajuan
    </x-slot>

    <div class="max-w-5xl space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold text-slate-950">Detail Pengajuan</h1>
                <p class="mt-1 text-sm text-slate-500">{{ $pengajuan->nomor_pengajuan }}</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('mahasiswa.pengajuan.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Kembali
                </a>
                @if ($pengajuan->isDraft())
                    <a href="{{ route('mahasiswa.pengajuan.edit', $pengajuan) }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Edit Draft
                    </a>
                    <form method="POST" action="{{ route('mahasiswa.pengajuan.submit', $pengajuan) }}">
                        @csrf
                        <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                            Submit Pengajuan
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 lg:grid-cols-3">
            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <h2 class="text-base font-semibold text-slate-950">Informasi Pengajuan</h2>
                <dl class="mt-4 divide-y divide-slate-200">
                    @foreach ([
                        'Nomor Pengajuan' => $pengajuan->nomor_pengajuan,
                        'Periode' => $pengajuan->periodeBansos?->nama,
                        'Jenis Bantuan' => $pengajuan->jenisBantuan?->nama,
                        'Status' => $pengajuan->status->label(),
                        'Tanggal Submit' => $pengajuan->submitted_at?->format('d/m/Y H:i') ?: '-',
                        'Catatan' => $pengajuan->catatan ?: '-',
                    ] as $label => $value)
                        <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-slate-500">{{ $label }}</dt>
                            <dd class="text-sm text-slate-900 sm:col-span-2">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Timeline Status</h2>
                <ol class="mt-4 space-y-4">
                    @foreach ($pengajuan->timelines as $timeline)
                        <li class="relative border-l border-slate-200 pl-4">
                            <span class="absolute -left-1.5 top-1.5 h-3 w-3 rounded-full {{ $timeline->status->value === 'diajukan' ? 'bg-blue-600' : 'bg-slate-400' }}"></span>
                            <p class="text-sm font-semibold text-slate-950">{{ $timeline->label }}</p>
                            <p class="mt-1 text-sm text-slate-600">{{ $timeline->description }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $timeline->occurred_at->format('d/m/Y H:i') }}</p>
                        </li>
                    @endforeach
                </ol>
            </section>
        </div>
    </div>
</x-app-layout>
