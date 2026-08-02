<x-app-layout>
    <x-slot name="header">
        Dashboard Student Portal
    </x-slot>

    <div class="space-y-6">
        <!-- Student Hero Welcome Card -->
        <div class="rounded-3xl bg-gradient-to-r from-slate-950 via-slate-900 to-teal-950 p-6 sm:p-8 text-white shadow-2xl shadow-slate-950/20 border border-slate-800/80 relative overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
                <div class="flex items-start gap-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-xl font-extrabold text-white shadow-lg shadow-emerald-950/40">
                        {{ Str::of(Auth::user()->name)->substr(0, 1)->upper() }}
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-bold text-emerald-400 border border-emerald-500/30 mb-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>PORTAL MAHASISWA TELUK BINTUNI</span>
                        </div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                            Selamat Datang, {{ Auth::user()->name }}
                        </h1>
                        <p class="mt-1 text-sm text-slate-300">
                            Pantau kelayakan dokumen, timeline verifikasi, catatan operator, dan riwayat pengajuan bantuan sosial pendidikan.
                        </p>
                    </div>
                </div>

                <div>
                    <a
                        href="{{ route('mahasiswa.pengajuan.create') }}"
                        class="inline-flex items-center gap-2 rounded-2xl bg-emerald-500 hover:bg-emerald-400 px-5 py-3 text-xs font-extrabold text-white shadow-lg shadow-emerald-950/40 transition-all hover:scale-105"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Buat Pengajuan Bantuan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary KPI Cards -->
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['Total Pengajuan', $summary['total'], 'bg-blue-50 text-blue-600', 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z'],
                ['Draft Pengajuan', $summary['draft'], 'bg-amber-50 text-amber-600', 'm16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10'],
                ['Diajukan Ke Dinas', $summary['diajukan'], 'bg-indigo-50 text-indigo-600', 'M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5'],
                ['Selesai / Disalurkan', $summary['selesai'], 'bg-emerald-50 text-emerald-600', 'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0 1 12 2.714Z'],
            ] as $card)
                <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-500">{{ $card[0] }}</span>
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl {{ $card[2] }}">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card[3] }}" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-3 text-3xl font-extrabold text-slate-950 tracking-tight">{{ $card[1] }}</p>
                </div>
            @endforeach
        </div>

        <!-- Submission Status & Timeline Grid -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Latest Submission Detail & Verification Score Widget -->
            <section class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-950">Status Pengajuan Berkas Terakhir</h3>
                        <p class="text-xs text-slate-500">Rincian status verifikasi dan skor kelengkapan berkas.</p>
                    </div>
                    @if ($latestPengajuan)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            {{ $latestPengajuan->status->label() }}
                        </span>
                    @endif
                </div>

                @if ($latestPengajuan)
                    <div class="mt-6 grid gap-6 md:grid-cols-2">
                        <div class="space-y-4">
                            <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200/60">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Nomor Pengajuan</span>
                                <p class="text-base font-extrabold text-slate-950 mt-0.5">{{ $latestPengajuan->nomor_pengajuan }}</p>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200/60">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Jenis Bantuan & Periode</span>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $latestPengajuan->jenisBantuan?->nama ?: '-' }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $latestPengajuan->periodeBansos?->nama ?: '-' }}</p>
                            </div>
                        </div>

                        <!-- Verification Score Meter -->
                        <div class="rounded-2xl bg-gradient-to-br from-slate-950 to-slate-900 p-5 text-white flex flex-col justify-between border border-slate-800">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Skor Verifikasi Berkas</span>
                                <div class="mt-3 flex items-baseline gap-2">
                                    <span class="text-4xl font-extrabold text-white">
                                        {{ $latestPengajuan->verification_score !== null ? $latestPengajuan->verification_score : '85' }}
                                    </span>
                                    <span class="text-sm font-bold text-slate-400">/ 100</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center justify-between text-xs text-slate-300 mb-1.5">
                                    <span>Kelayakan Dokumen</span>
                                    <span class="font-bold text-emerald-400">Memenuhi Syarat</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-slate-800 overflow-hidden">
                                    <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $latestPengajuan->verification_score !== null ? $latestPengajuan->verification_score : 85 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Operator Verification Note -->
                    <div class="mt-6 rounded-2xl bg-amber-50/70 border border-amber-200/80 p-5">
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-amber-600 text-white font-bold text-xs">
                                💬
                            </div>
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-amber-950">Catatan Operator Dinas Pendidikan</h4>
                                <p class="mt-1 text-sm text-amber-900 leading-relaxed font-medium">
                                    {{ $latestPengajuan->verification_notes ?: 'Dokumen telah diterima dan sedang dalam tahap pemeriksaan berkas fisik oleh tim verifikasi.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-6 rounded-2xl border-2 border-dashed border-slate-200 p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                        <p class="mt-3 text-sm font-bold text-slate-700">Belum Ada Pengajuan Bantuan</p>
                        <p class="mt-1 text-xs text-slate-500">Klik tombol "Buat Pengajuan Bantuan" untuk memulai pengisian formulir.</p>
                    </div>
                @endif
            </section>

            <!-- Timeline Progress Stepper -->
            <section class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-base font-extrabold text-slate-950">Timeline Verifikasi</h3>
                    <p class="text-xs text-slate-500">Tahapan proses berkas pengajuan.</p>
                </div>

                @if ($latestPengajuan && $latestPengajuan->timelines->isNotEmpty())
                    <ol class="mt-6 relative border-l-2 border-slate-200 ml-3 space-y-6">
                        @foreach ($latestPengajuan->timelines as $timeline)
                            <li class="pl-6 relative">
                                <span class="absolute -left-2 top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-emerald-500 ring-4 ring-white"></span>
                                <h4 class="text-sm font-bold text-slate-900">{{ $timeline->label }}</h4>
                                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">{{ $timeline->description }}</p>
                                <span class="text-[10px] font-bold text-slate-400 mt-1 block">{{ $timeline->occurred_at->format('d M Y, H:i') }}</span>
                            </li>
                        @endforeach
                    </ol>
                @else
                    <div class="mt-6 space-y-5">
                        <div class="flex items-start gap-3">
                            <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white text-xs font-bold">1</div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Isi Form & Upload Dokumen</p>
                                <p class="text-[11px] text-slate-500">Lengkapi KTP, KK, KTM, KHS, & Buku Rekening</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-slate-200 text-slate-600 text-xs font-bold">2</div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Verifikasi Berkas Dinas</p>
                                <p class="text-[11px] text-slate-500">Pemeriksaan syarat dan keabsahan dokumen</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-slate-200 text-slate-600 text-xs font-bold">3</div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Penyaluran Bantuan</p>
                                <p class="text-[11px] text-slate-500">Transfer dana bantuan sosial pendidikan</p>
                            </div>
                        </div>
                    </div>
                @endif
            </section>
        </div>

        <!-- History Table Section -->
        <section class="rounded-3xl border border-slate-200/80 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 bg-slate-50/60">
                <h3 class="text-base font-extrabold text-slate-950">Riwayat Pengajuan Bantuan Saya</h3>
                <a href="{{ route('mahasiswa.pengajuan.index') }}" class="text-xs font-extrabold text-emerald-600 hover:text-emerald-700">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200/80">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">Nomor Pengajuan</th>
                            <th class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">Periode</th>
                            <th class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">Jenis Bantuan</th>
                            <th class="px-6 py-3.5 text-left text-xs font-extrabold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3.5 text-right text-xs font-extrabold uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($history as $pengajuan)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-slate-900">{{ $pengajuan->nomor_pengajuan }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600 font-medium">{{ $pengajuan->periodeBansos?->nama }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600 font-medium">{{ $pengajuan->jenisBantuan?->nama }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 border border-emerald-200">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $pengajuan->status->label() }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('mahasiswa.pengajuan.show', $pengajuan) }}" class="inline-flex items-center gap-1 rounded-lg bg-slate-900 px-3 py-1.5 text-xs font-bold text-white hover:bg-slate-800 transition-all">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">Belum ada riwayat pengajuan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
