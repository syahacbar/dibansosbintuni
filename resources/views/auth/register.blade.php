<x-guest-layout>
    <div class="sm:mx-auto sm:w-full sm:max-w-xl">
        <div class="rounded-3xl border border-white/80 bg-white/95 p-8 sm:p-10 shadow-2xl shadow-emerald-950/10 backdrop-blur-2xl text-slate-900 relative overflow-hidden">
            <!-- Top Gradient Accent Bar -->
            <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-emerald-600 via-teal-500 to-emerald-700"></div>

            <div class="mb-6 text-center">
                <div class="inline-flex items-center justify-center p-2 mb-3 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100 shadow-xs">
                    <x-application-logo class="h-12 w-auto max-w-[100px] object-contain" />
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pendaftaran Akun Mahasiswa</h2>
                <p class="text-xs font-semibold text-slate-500 mt-1">Daftarkan diri Anda untuk mengajukan Beasiswa & Bantuan Sosial Pendidikan Teluk Bintuni</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1">Nama Lengkap</label>
                    <input id="name" class="block w-full rounded-xl border border-slate-300/90 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama sesuai KTP" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-rose-600" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1">Alamat Email</label>
                    <input id="email" class="block w-full rounded-xl border border-slate-300/90 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@contoh.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-600" />
                </div>

                <!-- NIK & NIM Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nik" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1">NIK (KTP)</label>
                        <input id="nik" class="block w-full rounded-xl border border-slate-300/90 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" type="text" name="nik" :value="old('nik')" placeholder="16 digit NIK" maxlength="20" />
                        <x-input-error :messages="$errors->get('nik')" class="mt-1.5 text-xs text-rose-600" />
                    </div>
                    <div>
                        <label for="nim" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1">NIM Mahasiswa</label>
                        <input id="nim" class="block w-full rounded-xl border border-slate-300/90 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" type="text" name="nim" :value="old('nim')" placeholder="NIM Kampus" maxlength="50" />
                        <x-input-error :messages="$errors->get('nim')" class="mt-1.5 text-xs text-rose-600" />
                    </div>
                </div>

                <!-- Jenis Beasiswa & Jenis Penerima Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_beasiswa" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1">Jenis Beasiswa</label>
                        <select id="jenis_beasiswa" name="jenis_beasiswa" class="block w-full rounded-xl border border-slate-300/90 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" required>
                            @foreach(\App\Enums\JenisBeasiswa::cases() as $jb)
                                <option value="{{ $jb->value }}" {{ old('jenis_beasiswa') === $jb->value ? 'selected' : '' }}>
                                    {{ $jb->label() }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('jenis_beasiswa')" class="mt-1.5 text-xs text-rose-600" />
                    </div>

                    <div>
                        <label for="jenis_penerima" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1">Jenis Penerima</label>
                        <select id="jenis_penerima" name="jenis_penerima" class="block w-full rounded-xl border border-slate-300/90 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all" required>
                            @foreach(\App\Enums\JenisPenerima::cases() as $jp)
                                <option value="{{ $jp->value }}" {{ old('jenis_penerima') === $jp->value ? 'selected' : '' }}>
                                    {{ $jp->label() }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('jenis_penerima')" class="mt-1.5 text-xs text-rose-600" />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1">Password</label>
                    <input id="password" class="block w-full rounded-xl border border-slate-300/90 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-600" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" class="block w-full rounded-xl border border-slate-300/90 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-900 focus:border-emerald-600 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 transition-all"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-rose-600" />
                </div>

                <div class="flex items-center justify-between pt-4">
                    <a class="text-xs font-bold text-slate-600 hover:text-emerald-700 transition-colors" href="{{ route('login') }}">
                        {{ __('Sudah punya akun? Login') }}
                    </a>

                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 via-teal-700 to-emerald-700 px-6 py-3 text-xs font-extrabold text-white shadow-md hover:from-emerald-700 hover:to-teal-800 transition-all">
                        {{ __('Daftar Akun Mahasiswa') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
