<x-app-layout>
    <x-slot name="header">
        Detail Pengajuan Operator
    </x-slot>

    @php
        $profile = $pengajuan->user?->mahasiswaProfile;
        $documents = $pengajuan->user?->mahasiswaDocuments?->keyBy(fn ($document) => $document->document_type->value) ?? collect();
        $verifications = $pengajuan->verifications->groupBy(fn ($verification) => $verification->layer->value);
    @endphp

    <div class="space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold text-slate-950">Detail Pengajuan</h1>
                <p class="mt-1 text-sm text-slate-500">{{ $pengajuan->nomor_pengajuan }}</p>
            </div>
            <a href="{{ route('operator.pengajuan.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

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
                        'Verification Score' => $pengajuan->verification_score !== null ? $pengajuan->verification_score.'/100' : '-',
                        'Tanggal Submit' => $pengajuan->submitted_at?->format('d/m/Y H:i') ?: '-',
                        'Diverifikasi Oleh' => $pengajuan->verifier?->name ?: '-',
                        'Tanggal Verifikasi' => $pengajuan->verified_at?->format('d/m/Y H:i') ?: '-',
                        'No. SP2D / Transfer' => $pengajuan->nomor_sp2d ?: '-',
                        'Tanggal Penyaluran' => $pengajuan->disalurkan_at?->format('d/m/Y H:i') ?: '-',
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
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-slate-500">Catatan Verifikasi</dt>
                        <dd class="mt-1 text-sm text-slate-950">{{ $pengajuan->verification_notes ?: '-' }}</dd>
                    </div>
                    @if ($pengajuan->catatan_penyaluran)
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-slate-500">Catatan Penyaluran</dt>
                            <dd class="mt-1 text-sm text-slate-950">{{ $pengajuan->catatan_penyaluran }}</dd>
                        </div>
                    @endif
                </dl>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Timeline Status</h2>
                <ol class="mt-4 space-y-4">
                    @foreach ($pengajuan->timelines as $timeline)
                        <li class="border-l-2 border-slate-300 pl-4">
                            <p class="text-sm font-semibold text-slate-900">{{ $timeline->label }}</p>
                            <p class="text-xs text-slate-500">{{ $timeline->description }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $timeline->occurred_at?->format('d/m/Y H:i') }}</p>
                        </li>
                    @endforeach
                </ol>
            </section>
        </div>

        @if ($pengajuan->canBeDisalurkan())
            <section class="rounded-lg border border-emerald-200 bg-emerald-50/50 p-6 shadow-sm">
                <h2 class="text-base font-semibold text-emerald-950">Penyaluran Bantuan Sosial</h2>
                <p class="mt-1 text-sm text-emerald-700">Pengajuan ini telah disetujui. Silakan masukkan Nomor SP2D / Bukti Transfer saat bantuan disalurkan.</p>
                <form method="POST" action="{{ route('operator.pengajuan.salurkan', $pengajuan) }}" class="mt-4 space-y-4">
                    @csrf
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="nomor_sp2d" class="block text-sm font-medium text-slate-700">Nomor SP2D / Transfer Bank</label>
                            <input type="text" id="nomor_sp2d" name="nomor_sp2d" value="{{ old('nomor_sp2d', $pengajuan->nomor_sp2d) }}" placeholder="Contoh: SP2D/2026/001928" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-slate-700">Catatan Penyaluran</label>
                            <input type="text" id="notes" name="notes" value="{{ old('notes', $pengajuan->catatan_penyaluran) }}" placeholder="Catatan tambahan pencairan..." class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-800">
                            Tandai Telah Disalurkan
                        </button>
                    </div>
                </form>
            </section>
        @endif

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                <div>
                    <h2 class="text-base font-semibold text-slate-950">Verifikasi 3 Layer</h2>
                    <p class="mt-1 text-sm text-slate-500">Layer 1 dan 2 berjalan dummy rule-based, tanpa OCR maupun AI.</p>
                </div>
                <div class="rounded-lg bg-slate-900 px-4 py-3 text-white">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-300">Verification Score</p>
                    <p class="text-2xl font-semibold">{{ $pengajuan->verification_score ?? 0 }}/100</p>
                </div>
            </div>

            <div class="mt-5 grid gap-4 lg:grid-cols-3">
                @foreach ([
                    'auto_validation' => 'Layer 1 - Auto Validation',
                    'smart_verification' => 'Layer 2 - Smart Verification',
                    'human_verification' => 'Layer 3 - Human Verification',
                ] as $layerKey => $layerLabel)
                    @php($latestVerification = $verifications->get($layerKey)?->first())
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="text-sm font-semibold text-slate-950">{{ $layerLabel }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ $latestVerification?->notes ?: 'Belum ada hasil.' }}</p>
                        <div class="mt-3 flex items-center justify-between text-sm">
                            <span class="text-slate-500">Keputusan</span>
                            <span class="font-medium text-slate-950">{{ $latestVerification?->decision->label() ?: '-' }}</span>
                        </div>
                        <div class="mt-2 flex items-center justify-between text-sm">
                            <span class="text-slate-500">Skor</span>
                            <span class="font-medium text-slate-950">{{ $latestVerification?->score !== null ? $latestVerification->score.'/100' : '-' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        @if ($pengajuan->canBeVerified())
            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Human Verification</h2>
                <form method="POST" action="{{ route('operator.pengajuan.verify', $pengajuan) }}" class="mt-4 grid gap-4">
                    @csrf
                    <div>
                        <label for="decision" class="block text-sm font-medium text-slate-700">Keputusan</label>
                        <select id="decision" name="decision" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            <option value="">Pilih keputusan</option>
                            <option value="approve" @selected(old('decision') === 'approve')>Approve</option>
                            <option value="revision" @selected(old('decision') === 'revision')>Revisi</option>
                            <option value="reject" @selected(old('decision') === 'reject')>Tolak</option>
                        </select>
                        @error('decision')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-slate-700">Catatan</label>
                        <textarea id="notes" name="notes" rows="4" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">{{ old('notes') }}</textarea>
                        @error('notes')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                            Simpan Keputusan
                        </button>
                    </div>
                </form>
            </section>
        @endif

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
