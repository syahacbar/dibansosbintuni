<x-app-layout>
    <x-slot name="header">
        Upload Dokumen Mahasiswa
    </x-slot>

    <div class="max-w-5xl space-y-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-950">Upload Dokumen Mahasiswa</h1>
            <p class="mt-1 text-sm text-slate-500">Unggah dokumen KTP, KK, KTM, Surat Aktif, KHS, dan Buku Rekening.</p>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid gap-4 lg:grid-cols-2">
            @foreach ($documentTypes as $type => $label)
                @php($document = $documents->get($type))
                <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-base font-semibold text-slate-950">{{ $label }}</h2>
                            <p class="mt-1 text-sm text-slate-500">PDF, JPG, JPEG, atau PNG. Maksimal 4 MB.</p>
                        </div>
                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $document ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $document ? 'Terunggah' : 'Belum ada' }}
                        </span>
                    </div>

                    @if ($document)
                        <div class="mt-4 rounded-md bg-slate-50 p-3 text-sm text-slate-700">
                            <p class="font-medium text-slate-900">{{ $document->original_name }}</p>
                            <p class="mt-1">{{ number_format($document->file_size / 1024, 1) }} KB</p>
                            <div class="mt-3 flex gap-3">
                                <a href="{{ $document->url }}" target="_blank" class="font-medium text-blue-600 hover:text-blue-800">Lihat</a>
                                <form method="POST" action="{{ route('mahasiswa.documents.destroy', $type) }}" onsubmit="return confirm('Hapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.documents.store') }}" enctype="multipart/form-data" class="mt-4 space-y-3">
                        @csrf
                        <input type="hidden" name="document_type" value="{{ $type }}">
                        <input
                            type="file"
                            name="document_file"
                            accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png"
                            class="block w-full rounded-md border border-slate-300 text-sm text-slate-700 file:mr-4 file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-700"
                        >
                        <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                            {{ $document ? 'Ganti Dokumen' : 'Upload Dokumen' }}
                        </button>
                    </form>
                </section>
            @endforeach
        </div>
    </div>
</x-app-layout>
