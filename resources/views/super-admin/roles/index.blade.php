<x-app-layout>
    <x-slot name="header">Role</x-slot>
    <div class="space-y-4">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div><h1 class="text-xl font-semibold text-slate-950">Role</h1><p class="mt-1 text-sm text-slate-500">Kelola role pengguna.</p></div>
            <a href="{{ route('super-admin.roles.create') }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Tambah Role</a>
        </div>
        @include('super-admin.partials.flash')
        <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-4">
                <form method="GET" class="flex gap-2">
                    <input name="search" value="{{ $search }}" placeholder="Cari role" class="w-full rounded-md border-slate-300 text-sm">
                    <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Cari</button>
                </form>
            </div>
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50"><tr><th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Nama</th><th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Permission</th><th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">Aksi</th></tr></thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($roles as $role)
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $role->name }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $role->permissions->pluck('name')->join(', ') ?: '-' }}</td>
                            <td class="px-4 py-3 text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('super-admin.roles.show', $role) }}" class="font-medium text-slate-600">Detail</a>
                                    <a href="{{ route('super-admin.roles.edit', $role) }}" class="font-medium text-blue-600">Edit</a>
                                    <form method="POST" action="{{ route('super-admin.roles.destroy', $role) }}" onsubmit="return confirm('Hapus role ini?')">@csrf @method('DELETE')<button class="font-medium text-red-600">Hapus</button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-8 text-center text-sm text-slate-500">Data role belum tersedia.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t border-slate-200 px-4 py-3">{{ $roles->links() }}</div>
        </section>
    </div>
</x-app-layout>
