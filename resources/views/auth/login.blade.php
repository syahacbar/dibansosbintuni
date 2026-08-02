<x-guest-layout>
    <div class="sm:mx-auto sm:w-full sm:max-w-xl">
        <!-- Main Card Container -->
        <div class="rounded-3xl border border-slate-800/80 bg-slate-900/90 p-8 sm:p-10 shadow-2xl shadow-emerald-950/40 backdrop-blur-2xl text-white relative overflow-hidden">
            <!-- Decorative Subtle Top Border Accent -->
            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-emerald-500 via-teal-400 to-emerald-600"></div>

            <!-- Brand Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center p-2 mb-3">
                    <x-application-logo class="h-16 w-auto max-w-[120px] object-contain drop-shadow-lg" />
                </div>
                <div class="flex items-center justify-center gap-2">
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                        DIBANSOS BINTUNI
                    </h1>
                    <span class="rounded-full bg-emerald-500/20 px-2.5 py-0.5 text-[10px] font-extrabold text-emerald-400 border border-emerald-500/30">
                        OFFICIAL
                    </span>
                </div>
                <p class="mt-1.5 text-xs font-semibold text-slate-400">
                    Digitalisasi Bantuan Sosial Pendidikan Kabupaten Teluk Bintuni
                </p>
            </div>

            <!-- Session Status Alert -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <!-- Quick Demo Accounts Hub Component -->
            <div
                class="mb-8 rounded-2xl border border-slate-800 bg-slate-950/80 p-5 shadow-inner"
                x-data="{
                    activeAccount: null,
                    accounts: [
                        { role: 'Super Admin', email: 'admin@example.com', desc: 'Akses Penuh, Role, User, Setting & Monitoring' },
                        { role: 'Operator Dinas', email: 'operator@example.com', desc: 'Verifikasi Berkas & Penyaluran Bansos' },
                        { role: 'Mahasiswa', email: 'mahasiswa@example.com', desc: 'Upload Dokumen & Pengajuan Syarat' },
                    ],
                    useAccount(email, role) {
                        document.getElementById('email').value = email;
                        document.getElementById('password').value = 'password';
                        this.activeAccount = role;
                    },
                }"
            >
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <h2 class="text-xs font-extrabold uppercase tracking-wider text-emerald-400">Pilih Akun Demo Uji Coba</h2>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">Password: <code class="text-emerald-400 bg-slate-900 px-1.5 py-0.5 rounded border border-slate-800">password</code></span>
                </div>

                <div class="space-y-2.5">
                    <template x-for="account in accounts" :key="account.email">
                        <button
                            type="button"
                            class="w-full text-left rounded-xl border p-3 transition-all flex items-center justify-between gap-3 group"
                            :class="activeAccount === account.role ? 'border-emerald-500 bg-emerald-500/10 text-white shadow-md' : 'border-slate-800 bg-slate-900/60 hover:border-slate-700 hover:bg-slate-900 text-slate-300'"
                            x-on:click="useAccount(account.email, account.role)"
                        >
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-white group-hover:text-emerald-400 transition-colors" x-text="account.role"></span>
                                    <template x-if="activeAccount === account.role">
                                        <span class="text-[9px] font-extrabold bg-emerald-500 text-slate-950 px-1.5 py-0.2 rounded-full">TERPILIH</span>
                                    </template>
                                </div>
                                <p class="text-[11px] text-slate-400 truncate mt-0.5" x-text="account.email"></p>
                            </div>

                            <span class="shrink-0 rounded-lg bg-slate-800 group-hover:bg-emerald-600 px-2.5 py-1 text-[11px] font-bold text-slate-200 group-hover:text-white transition-all">
                                Gunakan
                            </span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false }">
                @csrf

                <!-- Email Address Input -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                        Alamat Email / Username
                    </label>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="nama@example.com"
                            class="block w-full rounded-xl border border-slate-700 bg-slate-950/80 pl-11 pr-4 py-3 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                        />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-400" />
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                            Kata Sandi (Password)
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 transition-colors" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>
                    <div class="relative rounded-xl shadow-xs">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </div>
                        <input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="block w-full rounded-xl border border-slate-700 bg-slate-950/80 pl-11 pr-11 py-3 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-white transition-colors"
                        >
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-400" />
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="rounded border-slate-700 bg-slate-950 text-emerald-500 shadow-xs focus:ring-emerald-500 focus:ring-offset-slate-900"
                        />
                        <span class="ms-2 text-xs font-semibold text-slate-300">Ingat Saya di Perangkat Ini</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-500 via-teal-600 to-emerald-600 px-6 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-emerald-950/50 hover:from-emerald-400 hover:to-teal-500 transition-all hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-900"
                    >
                        <span>Masuk ke Sistem DIBANSOS</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Footer Info -->
            <div class="mt-8 pt-6 border-t border-slate-800/80 text-center text-[11px] text-slate-500">
                &copy; {{ date('Y') }} Pemerintah Kabupaten Teluk Bintuni. All rights reserved.
            </div>
        </div>
    </div>
</x-guest-layout>
