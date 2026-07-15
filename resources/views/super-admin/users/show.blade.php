<x-app-layout>
    <x-slot name="header">Detail User</x-slot>
    <div class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <dl class="grid gap-4 md:grid-cols-2">
            <div><dt class="text-sm text-slate-500">Nama</dt><dd class="text-sm font-medium text-slate-950">{{ $user->name }}</dd></div>
            <div><dt class="text-sm text-slate-500">Email</dt><dd class="text-sm font-medium text-slate-950">{{ $user->email }}</dd></div>
            <div class="md:col-span-2"><dt class="text-sm text-slate-500">Role</dt><dd class="text-sm font-medium text-slate-950">{{ $user->roles->pluck('name')->join(', ') ?: '-' }}</dd></div>
        </dl>
        <div class="mt-6"><a href="{{ route('super-admin.users.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">Kembali</a></div>
    </div>
</x-app-layout>
