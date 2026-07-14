<x-app-layout>
    <x-slot name="header">
        Detail {{ $title }}
    </x-slot>

    <div class="max-w-3xl space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold text-slate-950">Detail {{ $title }}</h1>
                <p class="mt-1 text-sm text-slate-500">Informasi detail data {{ Str::lower($title) }}.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route($routeName.'.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Kembali
                </a>
                <a href="{{ route($routeName.'.edit', $item) }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                    Edit
                </a>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="divide-y divide-slate-200">
                @foreach ($fields as $field)
                    @php($value = data_get($item, $field['name']))
                    <div class="grid gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-slate-500">{{ $field['label'] }}</dt>
                        <dd class="text-sm text-slate-900 sm:col-span-2">
                            @if (($field['type'] ?? null) === 'select')
                                {{ ($field['options'] ?? [])[$value] ?? '-' }}
                            @elseif ($field['name'] === 'aktif')
                                {{ $value ? 'Aktif' : 'Nonaktif' }}
                            @elseif ($value instanceof DateTimeInterface)
                                {{ $value->format('d/m/Y') }}
                            @else
                                {{ $value ?: '-' }}
                            @endif
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</x-app-layout>
