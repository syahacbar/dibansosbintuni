<x-app-layout>
    <x-slot name="header">
        Dashboard Monitoring
    </x-slot>

    <div class="space-y-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-950">Dashboard Monitoring</h1>
            <p class="mt-1 text-sm text-slate-500">Ringkasan monitoring SIBANSOS Mahasiswa Kabupaten Teluk Bintuni.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                'Total Mahasiswa' => $widgets['total_mahasiswa'],
                'Total Pengajuan' => $widgets['total_pengajuan'],
                'Total Verifikasi' => $widgets['total_verifikasi'],
                'Total Ditolak' => $widgets['total_ditolak'],
            ] as $label => $value)
                <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-semibold text-slate-950">{{ $value }}</p>
                </section>
            @endforeach
        </div>

        <div class="grid gap-4 xl:grid-cols-3">
            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-slate-950">Grafik Pengajuan Dummy</h2>
                        <p class="mt-1 text-sm text-slate-500">Data simulasi bulanan untuk demo dashboard monitoring.</p>
                    </div>
                </div>

                @php($maxValue = collect($dummyChart)->max('value') ?: 1)
                <div class="mt-6 flex h-72 items-end gap-4 border-b border-l border-slate-200 px-4 pb-4">
                    @foreach ($dummyChart as $point)
                        <div class="flex flex-1 flex-col items-center gap-2">
                            <div class="flex h-56 w-full items-end">
                                <div
                                    class="w-full rounded-t-md bg-slate-900"
                                    style="height: {{ max(8, ($point['value'] / $maxValue) * 100) }}%"
                                    title="{{ $point['label'] }}: {{ $point['value'] }}"
                                ></div>
                            </div>
                            <span class="text-xs font-medium text-slate-500">{{ $point['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Status Pengajuan</h2>
                <p class="mt-1 text-sm text-slate-500">Distribusi status aktual.</p>

                @php($statusMax = max($statusDistribution ?: [1]))
                <div class="mt-5 space-y-4">
                    @foreach ($statusDistribution as $label => $value)
                        <div>
                            <div class="mb-1 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-700">{{ $label }}</span>
                                <span class="text-slate-500">{{ $value }}</span>
                            </div>
                            <div class="h-2 rounded-full bg-slate-100">
                                <div class="h-2 rounded-full bg-blue-600" style="width: {{ $statusMax > 0 ? ($value / $statusMax) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
