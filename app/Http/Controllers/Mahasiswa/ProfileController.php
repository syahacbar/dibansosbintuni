<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mahasiswa\ProfileRequest;
use App\Models\Distrik;
use App\Models\Kampung;
use App\Models\ProgramStudi;
use App\Services\Mahasiswa\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private readonly ProfileService $profileService) {}

    public function edit(Request $request): View
    {
        return view('mahasiswa.profile', [
            'profile' => $this->profileService->getOrCreateForUser($request->user()),
            'programStudis' => ProgramStudi::with('fakultas.perguruanTinggi')->orderBy('nama')->get(),
            'distriks' => Distrik::orderBy('nama')->get(),
            'kampungs' => Kampung::with('distrik')->orderBy('nama')->get(),
        ]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $this->profileService->update($request->user(), $request->validated());

        return redirect()
            ->route('mahasiswa.profile.edit')
            ->with('success', 'Profil mahasiswa berhasil diperbarui.');
    }
}
