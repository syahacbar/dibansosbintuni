<x-app-layout>
    <x-slot name="header">{{ $role ? 'Edit Role' : 'Tambah Role' }}</x-slot>
    <form method="POST" action="{{ $action }}" class="max-w-4xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @if ($method !== 'POST') @method($method) @endif
        <div class="grid gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700">Nama Role</label>
                <input name="name" value="{{ old('name', $role?->name) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <input type="hidden" name="guard_name" value="web">
            <div>
                <p class="text-sm font-medium text-slate-700">Permission</p>
                <div class="mt-2 grid gap-2 md:grid-cols-3">
                    @foreach ($permissions as $permission)
                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" @checked(in_array($permission->name, old('permissions', $role?->permissions->pluck('name')->all() ?? []), true)) class="rounded border-slate-300">
                            {{ $permission->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-2"><a href="{{ route('super-admin.roles.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">Batal</a><button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Simpan</button></div>
    </form>
</x-app-layout>
