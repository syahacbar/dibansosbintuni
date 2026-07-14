<x-app-layout>
    <x-slot name="header">
        {{ $item ? 'Edit '.$title : 'Tambah '.$title }}
    </x-slot>

    <div class="max-w-3xl space-y-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-950">{{ $item ? 'Edit '.$title : 'Tambah '.$title }}</h1>
            <p class="mt-1 text-sm text-slate-500">Lengkapi data sesuai kebutuhan master data.</p>
        </div>

        <form method="POST" action="{{ $action }}" class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div class="grid gap-5">
                @foreach ($fields as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'];
                        $storedValue = $item ? data_get($item, $name) : null;
                        $value = old($name, $storedValue);
                    @endphp

                    <div>
                        @if ($type === 'checkbox')
                            <input type="hidden" name="{{ $name }}" value="0">
                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                                <input
                                    type="checkbox"
                                    name="{{ $name }}"
                                    value="1"
                                    @checked(old($name, $item ? (bool) data_get($item, $name) : true))
                                    class="rounded border-slate-300 text-slate-900 shadow-sm focus:ring-slate-500"
                                >
                                {{ $field['label'] }}
                            </label>
                        @else
                            <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">{{ $field['label'] }}</label>

                            @if ($type === 'textarea')
                                <textarea
                                    id="{{ $name }}"
                                    name="{{ $name }}"
                                    rows="4"
                                    class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500"
                                >{{ $value }}</textarea>
                            @elseif ($type === 'select')
                                <select
                                    id="{{ $name }}"
                                    name="{{ $name }}"
                                    class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500"
                                >
                                    <option value="">Pilih {{ Str::lower($field['label']) }}</option>
                                    @foreach (($field['options'] ?? []) as $optionValue => $optionLabel)
                                        <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input
                                    id="{{ $name }}"
                                    name="{{ $name }}"
                                    type="{{ $type }}"
                                    value="{{ $type === 'date' && $value instanceof DateTimeInterface ? $value->format('Y-m-d') : $value }}"
                                    class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500"
                                >
                            @endif
                        @endif

                        @error($name)
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex items-center justify-end gap-2">
                <a href="{{ route($routeName.'.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
