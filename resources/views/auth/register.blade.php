<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Pendaftaran Akun Mahasiswa</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Daftarkan diri Anda untuk mengajukan Bantuan Sosial Pendidikan Teluk Bintuni</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama sesuai KTP" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- NIK & NIM Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="nik" :value="__('NIK (Nomor Induk Kependudukan)')" />
                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" placeholder="16 digit NIK" maxlength="20" />
                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="nim" :value="__('NIM / Nomor Mahasiswa')" />
                <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" :value="old('nim')" placeholder="NIM Kampus" maxlength="50" />
                <x-input-error :messages="$errors->get('nim')" class="mt-2" />
            </div>
        </div>

        <!-- Jenis Beasiswa & Jenis Penerima Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="jenis_beasiswa" :value="__('Jenis Beasiswa')" />
                <select id="jenis_beasiswa" name="jenis_beasiswa" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                    @foreach(\App\Enums\JenisBeasiswa::cases() as $jb)
                        <option value="{{ $jb->value }}" {{ old('jenis_beasiswa') === $jb->value ? 'selected' : '' }}>
                            {{ $jb->label() }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('jenis_beasiswa')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="jenis_penerima" :value="__('Jenis Penerima')" />
                <select id="jenis_penerima" name="jenis_penerima" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                    @foreach(\App\Enums\JenisPenerima::cases() as $jp)
                        <option value="{{ $jp->value }}" {{ old('jenis_penerima') === $jp->value ? 'selected' : '' }}>
                            {{ $jp->label() }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('jenis_penerima')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah punya akun? Login') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar Akun') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
