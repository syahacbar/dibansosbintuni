<?php

namespace App\Services\Mahasiswa;

use App\Models\MahasiswaProfile;
use App\Models\User;

class ProfileService
{
    public function getOrCreateForUser(User $user): MahasiswaProfile
    {
        return MahasiswaProfile::firstOrCreate(
            ['user_id' => $user->id],
            ['nama_lengkap' => $user->name],
        );
    }

    public function update(User $user, array $data): MahasiswaProfile
    {
        $profile = $this->getOrCreateForUser($user);
        $profile->update($data);

        return $profile->refresh();
    }
}
