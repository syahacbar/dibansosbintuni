<x-app-layout>
    <x-slot name="header">User</x-slot>

    <div class="space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl font-semibold text-slate-950">User</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola akun pengguna sistem.</p>
            </div>
            <a href="{{ route('super-admin.users.create') }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Tambah User</a>
        </div>

        @include('super-admin.partials.flash')

        <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-4">
                <form method="GET" class="flex gap-2">
                    <input name="search" value="{{ $search }}" placeholder="Cari nama atau email" class="w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                    <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Cari</button>
                    <a href="{{ route('super-admin.users.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">Reset</a>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Role</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $user->roles->pluck('name')->join(', ') ?: '-' }}</td>
                                <td class="px-4 py-3 text-right text-sm">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('super-admin.users.show', $user) }}" class="font-medium text-slate-600">Detail</a>
                                        <a href="{{ route('super-admin.users.edit', $user) }}" class="font-medium text-blue-600">Edit</a>
                                        <form method="POST" action="{{ route('super-admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="font-medium text-red-600">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">Data user belum tersedia.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-4 py-3">{{ $users->links() }}</div>
        </section>
    </div>
</x-app-layout>
