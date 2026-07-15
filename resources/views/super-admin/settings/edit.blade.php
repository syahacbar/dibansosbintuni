<x-app-layout>
    <x-slot name="header">Pengaturan Sistem</x-slot>
    <div class="max-w-3xl space-y-4">
        <div><h1 class="text-xl font-semibold text-slate-950">Pengaturan Sistem</h1><p class="mt-1 text-sm text-slate-500">Atur tahun aktif dan logo aplikasi.</p></div>
        @include('super-admin.partials.flash')
        <form method="POST" action="{{ route('super-admin.settings.update') }}" enctype="multipart/form-data" class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')
            <div class="grid gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Tahun Aktif</label>
                    <input type="number" name="active_year" value="{{ old('active_year', $settings['active_year'] ?? date('Y')) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm">
                    @error('active_year')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Logo</label>
                    @if (! empty($settings['logo_path']))
                        <img src="{{ Storage::disk('public')->url($settings['logo_path']) }}" alt="Logo" class="mt-2 h-20 w-20 rounded-md border border-slate-200 object-contain">
                    @endif
                    <input type="file" name="logo" accept=".png,.jpg,.jpeg,.webp,image/png,image/jpeg,image/webp" class="mt-2 block w-full rounded-md border border-slate-300 text-sm file:mr-4 file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
                    @error('logo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="mt-6 flex justify-end"><button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Simpan Pengaturan</button></div>
        </form>
    </div>
</x-app-layout>
