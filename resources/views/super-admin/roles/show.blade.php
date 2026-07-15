<x-app-layout>
    <x-slot name="header">Detail Role</x-slot>
    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-lg font-semibold text-slate-950">{{ $role->name }}</h1>
        <p class="mt-4 text-sm font-medium text-slate-500">Permission</p>
        <p class="mt-1 text-sm text-slate-950">{{ $role->permissions->pluck('name')->join(', ') ?: '-' }}</p>
        <div class="mt-6"><a href="{{ route('super-admin.roles.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">Kembali</a></div>
    </div>
</x-app-layout>
