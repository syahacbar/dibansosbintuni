<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div
        class="mb-6 rounded-lg border border-slate-200 bg-slate-50 p-4"
        x-data="{
            accounts: [
                { role: 'Super Admin', email: 'admin@example.com', access: 'User, Role, Permission, Pengaturan Sistem, Monitoring, Report' },
                { role: 'Operator', email: 'operator@example.com', access: 'Dashboard Operator, Pengajuan, Preview Dokumen, Verifikasi' },
                { role: 'Mahasiswa', email: 'mahasiswa@example.com', access: 'Dashboard Mahasiswa, Profil, Dokumen, Pengajuan' },
            ],
            useAccount(email) {
                document.getElementById('email').value = email;
                document.getElementById('password').value = 'password';
            },
        }"
    >
        <div class="mb-3">
            <h2 class="text-sm font-semibold text-slate-950">Akun Demo</h2>
            <p class="mt-1 text-xs leading-5 text-slate-600">
                Klik gunakan untuk mengisi form login secara otomatis. Password semua akun:
                <span class="font-semibold text-slate-900">password</span>
            </p>
        </div>

        <div class="space-y-3">
            <template x-for="account in accounts" :key="account.email">
                <div class="rounded-md border border-slate-200 bg-white p-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900" x-text="account.role"></p>
                            <p class="mt-1 break-all text-xs text-slate-600" x-text="account.email"></p>
                        </div>

                        <button
                            type="button"
                            class="shrink-0 rounded-md bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2"
                            x-on:click="useAccount(account.email)"
                        >
                            Gunakan
                        </button>
                    </div>

                    <p class="mt-2 text-xs leading-5 text-slate-500" x-text="account.access"></p>
                </div>
            </template>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
