<x-app-layout>
    <x-slot name="header">{{ $user ? 'Edit User' : 'Tambah User' }}</x-slot>

    <form method="POST" action="{{ $action }}" class="max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @if ($method !== 'POST') @method($method) @endif

        <div class="grid gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700">Nama</label>
                <input name="name" value="{{ old('name', $user?->name) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Email</label>
                <input name="email" value="{{ old('email', $user?->email) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" name="password" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-700">Role</p>
                <div class="mt-2 grid gap-2 md:grid-cols-3">
                    @foreach ($roles as $role)
                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" @checked(in_array($role->name, old('roles', $user?->roles->pluck('name')->all() ?? []), true)) class="rounded border-slate-300">
                            {{ $role->name }}
                        </label>
                    @endforeach
                </div>
                @error('roles')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('super-admin.users.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">Batal</a>
            <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Simpan</button>
        </div>
    </form>
</x-app-layout>
