<x-app-layout>
    <x-slot name="header">Detail Permission</x-slot>
    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-lg font-semibold text-slate-950">{{ $permission->name }}</h1>
        <p class="mt-2 text-sm text-slate-500">Guard: {{ $permission->guard_name }}</p>
        <div class="mt-6"><a href="{{ route('super-admin.permissions.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">Kembali</a></div>
    </div>
</x-app-layout>
