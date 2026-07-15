<x-app-layout>
    <x-slot name="header">
        Laporan
    </x-slot>

    <div class="space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold text-slate-950">Laporan</h1>
                <p class="mt-1 text-sm text-slate-500">Export laporan Mahasiswa, Pengajuan, dan Penerima ke PDF atau Excel.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('reports.pdf', $type) }}" class="rounded-md bg-red-700 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">Export PDF</a>
                <a href="{{ route('reports.excel', $type) }}" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Export Excel</a>
            </div>
        </div>

        <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
            <form method="GET" action="{{ route('reports.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <label for="type" class="text-sm font-medium text-slate-700">Jenis Laporan</label>
                <select id="type" name="type" class="rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                    @foreach ($types as $value => $label)
                        <option value="{{ $value }}" @selected($type === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Tampilkan</button>
            </form>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-950">{{ $title }}</h2>
                <p class="mt-1 text-sm text-slate-500">Total baris: {{ $rows->count() }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            @foreach ($headings as $heading)
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $heading }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($rows as $row)
                            <tr>
                                @foreach ($row as $cell)
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">{{ $cell ?: '-' }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($headings) }}" class="px-4 py-8 text-center text-sm text-slate-500">Data laporan belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
