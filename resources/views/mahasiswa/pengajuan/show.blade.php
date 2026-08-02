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
                @if ($pengajuan->canBeEdited())
                    <a href="{{ route('mahasiswa.pengajuan.edit', $pengajuan) }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        {{ $pengajuan->isRevisi() ? 'Perbarui Data Pengajuan' : 'Edit Draft' }}
                    </a>
                    <form method="POST" action="{{ route('mahasiswa.pengajuan.submit', $pengajuan) }}">
                        @csrf
                        <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                            {{ $pengajuan->isRevisi() ? 'Kirim Ulang Pengajuan' : 'Submit Pengajuan' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if (session('error'))
            <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($pengajuan->isRevisi())
            <div class="rounded-md border border-amber-200 bg-amber-50 p-4">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-amber-900">Permohonan Memerlukan Revisi</h3>
                        <p class="mt-1 text-sm text-amber-800">Catatan Dinas Pendidikan: <strong>{{ $pengajuan->verification_notes ?: 'Silakan periksa kembali berkas/profil Anda.' }}</strong></p>
                        <p class="mt-2 text-xs text-amber-700">Silakan lengkapi/perbaiki dokumen atau profil Anda, lalu tekan tombol <strong>Kirim Ulang Pengajuan</strong>.</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($pengajuan->status === \App\Enums\PengajuanStatus::Disalurkan)
            <div class="rounded-md border border-emerald-200 bg-emerald-50 p-4">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-emerald-900">Selamat! Bantuan Sosial Pendidikan Telah Disalurkan</h3>
                        <p class="mt-1 text-sm text-emerald-800">No. SP2D / Transfer: <strong>{{ $pengajuan->nomor_sp2d ?: '-' }}</strong> | Tanggal: <strong>{{ $pengajuan->disalurkan_at?->format('d M Y H:i') ?: '-' }}</strong></p>
                        @if ($pengajuan->catatan_penyaluran)
                            <p class="mt-1 text-xs text-emerald-700">Catatan: {{ $pengajuan->catatan_penyaluran }}</p>
                        @endif
                    </div>
                </div>
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
