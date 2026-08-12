<?php

namespace App\Http\Controllers\Auth;

use App\Enums\JenisBeasiswa;
use App\Enums\JenisPenerima;
use App\Http\Controllers\Controller;
use App\Models\MahasiswaProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => ['nullable', 'string', 'max:20', 'unique:'.MahasiswaProfile::class.',nik'],
            'nim' => ['nullable', 'string', 'max:50', 'unique:'.MahasiswaProfile::class.',nim'],
            'jenis_beasiswa' => ['required', Rule::enum(JenisBeasiswa::class)],
            'jenis_penerima' => ['required', Rule::enum(JenisPenerima::class)],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Mahasiswa');

        MahasiswaProfile::create([
            'user_id' => $user->id,
            'nama_lengkap' => $user->name,
            'nik' => $request->nik,
            'nim' => $request->nim,
            'jenis_beasiswa' => $request->jenis_beasiswa,
            'jenis_penerima' => $request->jenis_penerima,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
