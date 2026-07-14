<x-app-layout>
    <x-slot name="header">
        {{ $title }}
    </x-slot>

    <div class="space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold text-slate-950">{{ $title }}</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola data {{ Str::lower($title) }}.</p>
            </div>

            <a href="{{ route($routeName.'.create') }}" class="inline-flex items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                Tambah Data
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-4">
                <form method="GET" action="{{ route($routeName.'.index') }}" class="flex flex-col gap-3 sm:flex-row">
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari kode atau nama"
                        class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500"
                    >
                    <div class="flex gap-2">
                        <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                            Cari
                        </button>
                        <a href="{{ route($routeName.'.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            @foreach ($columns as $column)
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    {{ $column['label'] }}
                                </th>
                            @endforeach
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($items as $item)
                            <tr>
                                @foreach ($columns as $column)
                                    @php($value = data_get($item, $column['key']))
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-700">
                                        @if ($column['key'] === 'aktif')
                                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $value ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                                {{ $value ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        @elseif ($value instanceof DateTimeInterface)
                                            {{ $value->format('d/m/Y') }}
                                        @else
                                            {{ $value ?: '-' }}
                                        @endif
                                    </td>
                                @endforeach
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route($routeName.'.show', $item) }}" class="font-medium text-slate-600 hover:text-slate-950">Detail</a>
                                        <a href="{{ route($routeName.'.edit', $item) }}" class="font-medium text-blue-600 hover:text-blue-800">Edit</a>
                                        <form method="POST" action="{{ route($routeName.'.destroy', $item) }}" onsubmit="return confirm('Hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) + 1 }}" class="px-4 py-8 text-center text-sm text-slate-500">
                                    Data belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 px-4 py-3">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
