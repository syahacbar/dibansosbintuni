<x-app-layout>
    <x-slot name="header">{{ $permission ? 'Edit Permission' : 'Tambah Permission' }}</x-slot>
    <form method="POST" action="{{ $action }}" class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @if ($method !== 'POST') @method($method) @endif
        <label class="block text-sm font-medium text-slate-700">Nama Permission</label>
        <input name="name" value="{{ old('name', $permission?->name) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm">
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        <input type="hidden" name="guard_name" value="web">
        <div class="mt-6 flex justify-end gap-2"><a href="{{ route('super-admin.permissions.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">Batal</a><button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Simpan</button></div>
    </form>
</x-app-layout>
