<x-app-layout>
    <x-slot name="header">
        {{ $pengajuan ? 'Edit Draft Pengajuan' : 'Buat Pengajuan' }}
    </x-slot>

    <div class="max-w-3xl space-y-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-950">{{ $pengajuan ? 'Edit Draft Pengajuan' : 'Buat Pengajuan' }}</h1>
            <p class="mt-1 text-sm text-slate-500">Pilih periode dan jenis bantuan yang akan diajukan.</p>
        </div>

        <form method="POST" action="{{ $action }}" class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div class="grid gap-5">
                <div>
                    <label for="periode_bansos_id" class="block text-sm font-medium text-slate-700">Periode Bansos</label>
                    <select id="periode_bansos_id" name="periode_bansos_id" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        <option value="">Pilih periode</option>
                        @foreach ($periodes as $periode)
                            <option value="{{ $periode->id }}" @selected((string) old('periode_bansos_id', $pengajuan?->periode_bansos_id) === (string) $periode->id)>
                                {{ $periode->nama }} ({{ $periode->tanggal_mulai->format('d/m/Y') }} - {{ $periode->tanggal_selesai->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('periode_bansos_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="jenis_bantuan_id" class="block text-sm font-medium text-slate-700">Jenis Bantuan</label>
                    <select id="jenis_bantuan_id" name="jenis_bantuan_id" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        <option value="">Pilih jenis bantuan</option>
                        @foreach ($jenisBantuans as $jenisBantuan)
                            <option value="{{ $jenisBantuan->id }}" @selected((string) old('jenis_bantuan_id', $pengajuan?->jenis_bantuan_id) === (string) $jenisBantuan->id)>
                                {{ $jenisBantuan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_bantuan_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="catatan" class="block text-sm font-medium text-slate-700">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="4" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">{{ old('catatan', $pengajuan?->catatan) }}</textarea>
                    @error('catatan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2">
                <a href="{{ route('mahasiswa.pengajuan.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Batal
                </a>
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                    Simpan Draft
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
