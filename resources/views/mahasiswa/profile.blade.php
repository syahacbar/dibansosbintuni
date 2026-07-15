<x-app-layout>
    <x-slot name="header">
        Profil Mahasiswa
    </x-slot>

    <div class="max-w-5xl space-y-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-950">Profil Mahasiswa</h1>
            <p class="mt-1 text-sm text-slate-500">Lengkapi biodata, orang tua, pendidikan, rekening, dan alamat.</p>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('mahasiswa.profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Biodata</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                        <input id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $profile->nama_lengkap) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        @error('nama_lengkap')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="nik" class="block text-sm font-medium text-slate-700">NIK</label>
                        <input id="nik" name="nik" value="{{ old('nik', $profile->nik) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        @error('nik')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-slate-700">Tempat Lahir</label>
                        <input id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $profile->tempat_lahir) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        @error('tempat_lahir')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                        <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $profile->tanggal_lahir?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        @error('tanggal_lahir')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="L" @selected(old('jenis_kelamin', $profile->jenis_kelamin) === 'L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin', $profile->jenis_kelamin) === 'P')>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-slate-700">No. HP</label>
                        <input id="no_hp" name="no_hp" value="{{ old('no_hp', $profile->no_hp) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        @error('no_hp')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Orang Tua</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    @foreach ([
                        'nama_ayah' => 'Nama Ayah',
                        'pekerjaan_ayah' => 'Pekerjaan Ayah',
                        'nama_ibu' => 'Nama Ibu',
                        'pekerjaan_ibu' => 'Pekerjaan Ibu',
                    ] as $name => $label)
                        <div>
                            <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">{{ $label }}</label>
                            <input id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $profile->{$name}) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Pendidikan</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="nim" class="block text-sm font-medium text-slate-700">NIM</label>
                        <input id="nim" name="nim" value="{{ old('nim', $profile->nim) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        @error('nim')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="program_studi_id" class="block text-sm font-medium text-slate-700">Program Studi Master Data</label>
                        <select id="program_studi_id" name="program_studi_id" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            <option value="">Pilih program studi</option>
                            @foreach ($programStudis as $programStudi)
                                <option value="{{ $programStudi->id }}" @selected((string) old('program_studi_id', $profile->program_studi_id) === (string) $programStudi->id)>
                                    {{ $programStudi->nama }} - {{ $programStudi->fakultas?->nama }} - {{ $programStudi->fakultas?->perguruanTinggi?->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('program_studi_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    @foreach ([
                        'perguruan_tinggi_nama' => 'Perguruan Tinggi',
                        'fakultas_nama' => 'Fakultas',
                        'program_studi_nama' => 'Program Studi',
                        'semester' => 'Semester',
                        'ipk' => 'IPK',
                    ] as $name => $label)
                        <div>
                            <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">{{ $label }}</label>
                            <input id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $profile->{$name}) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Rekening</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    @foreach ([
                        'nama_bank' => 'Nama Bank',
                        'nomor_rekening' => 'Nomor Rekening',
                        'nama_pemilik_rekening' => 'Nama Pemilik Rekening',
                    ] as $name => $label)
                        <div>
                            <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">{{ $label }}</label>
                            <input id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $profile->{$name}) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-950">Alamat</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="distrik_id" class="block text-sm font-medium text-slate-700">Distrik</label>
                        <select id="distrik_id" name="distrik_id" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            <option value="">Pilih distrik</option>
                            @foreach ($distriks as $distrik)
                                <option value="{{ $distrik->id }}" @selected((string) old('distrik_id', $profile->distrik_id) === (string) $distrik->id)>{{ $distrik->nama }}</option>
                            @endforeach
                        </select>
                        @error('distrik_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="kampung_id" class="block text-sm font-medium text-slate-700">Kampung</label>
                        <select id="kampung_id" name="kampung_id" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            <option value="">Pilih kampung</option>
                            @foreach ($kampungs as $kampung)
                                <option value="{{ $kampung->id }}" @selected((string) old('kampung_id', $profile->kampung_id) === (string) $kampung->id)>{{ $kampung->nama }} - {{ $kampung->distrik?->nama }}</option>
                            @endforeach
                        </select>
                        @error('kampung_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-slate-700">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="4" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">{{ old('alamat', $profile->alamat) }}</textarea>
                        @error('alamat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="rt" class="block text-sm font-medium text-slate-700">RT</label>
                        <input id="rt" name="rt" value="{{ old('rt', $profile->rt) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        @error('rt')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="rw" class="block text-sm font-medium text-slate-700">RW</label>
                        <input id="rw" name="rw" value="{{ old('rw', $profile->rw) }}" class="mt-1 w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        @error('rw')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <div class="flex justify-end">
                <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
