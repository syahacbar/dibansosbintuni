<x-app-layout>
    <x-slot name="header">
        Detail Pengajuan Operator
    </x-slot>

    @php
        $profile = $pengajuan->user?->mahasiswaProfile;
        $documents = $pengajuan->user?->mahasiswaDocuments?->keyBy(fn ($document) => $document->document_type->value) ?? collect();
    @endphp

    <div class="space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold text-slate-950">Detail Pengajuan</h1>
                <p class="mt-1 text-sm text-slate-500">{{ $pengajuan->nomor_pengajuan }}</p>
            </div>
            <a href="{{ route('operator.pengajuan.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>

        <div class="grid gap-4 lg:grid-cols-3">
            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <h2 class="text-base font-semibold text-slate-950">Pengajuan</h2>
                <dl class="mt-4 grid gap-4 md:grid-cols-2">
                    @foreach ([
                        'Mahasiswa' => $pengajuan->user?->name,
                        'Email' => $pengajuan->user?->email,
                        'Periode' => $pengajuan->periodeBansos?->nama,
                        'Jenis Bantuan' => $pengajuan->jenisBantuan?->nama,
                        'Status' => $pengajuan->status->label(),
                        'Tanggal Submit' => $pengajuan->submitted_at?->format('d/m/Y H:i') ?: '-',
                    ] as $label => $value)
                        <div>
                            <dt class="text-sm font-medium text-slate-500">{{ $label }}</dt>
                            <dd class="mt-1 text-sm text-slate-950">{{ $value ?: '-' }}</dd>
                        </div>
                    @endforeach
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-slate-500">Catatan</dt>
                        <dd class="mt-1 text-sm text-slate-950">{{ $pengajuan->catatan ?: '-' }}</dd>
                    </div>
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

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-950">Profil Mahasiswa</h2>
            <dl class="mt-4 grid gap-4 md:grid-cols-3">
                @foreach ([
                    'NIK' => $profile?->nik,
                    'NIM' => $profile?->nim,
                    'Nama Lengkap' => $profile?->nama_lengkap,
                    'No. HP' => $profile?->no_hp,
                    'Program Studi' => $profile?->programStudi?->nama ?: $profile?->program_studi_nama,
                    'Alamat' => $profile?->alamat,
                ] as $label => $value)
                    <div>
                        <dt class="text-sm font-medium text-slate-500">{{ $label }}</dt>
                        <dd class="mt-1 text-sm text-slate-950">{{ $value ?: '-' }}</dd>
                    </div>
                @endforeach
            </dl>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-950">Preview Dokumen</h2>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                @foreach ($documentTypes as $type => $label)
                    @php($document = $documents->get($type))
                    <div class="rounded-lg border border-slate-200 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-slate-950">{{ $label }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $document?->original_name ?: 'Belum diunggah' }}</p>
                            </div>
                            @if ($document)
                                <a href="{{ $document->url }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-800">Buka</a>
                            @endif
                        </div>

                        @if ($document && str_starts_with($document->mime_type, 'image/'))
                            <img src="{{ $document->url }}" alt="{{ $label }}" class="mt-3 h-48 w-full rounded-md border border-slate-200 object-contain">
                        @elseif ($document && $document->mime_type === 'application/pdf')
                            <iframe src="{{ $document->url }}" title="{{ $label }}" class="mt-3 h-48 w-full rounded-md border border-slate-200"></iframe>
                        @else
                            <div class="mt-3 flex h-48 items-center justify-center rounded-md border border-dashed border-slate-300 text-sm text-slate-500">
                                Tidak ada preview
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-app-layout>
