<?php

namespace Tests\Feature;

use App\Models\MahasiswaProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_can_be_accessed(): void
    {
        $user = User::factory()->create(['name' => 'Mahasiswa Demo']);

        $this->actingAs($user)
            ->get(route('mahasiswa.profile.edit'))
            ->assertOk()
            ->assertSee('Profil Mahasiswa');

        $this->assertDatabaseHas('mahasiswa_profiles', [
            'user_id' => $user->id,
            'nama_lengkap' => 'Mahasiswa Demo',
        ]);
    }

    public function test_profile_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('mahasiswa.profile.update'), [
                'nik' => '9100000000000001',
                'nim' => 'MHS001',
                'nama_lengkap' => 'Mahasiswa Teluk Bintuni',
                'tempat_lahir' => 'Bintuni',
                'tanggal_lahir' => '2002-01-01',
                'jenis_kelamin' => 'L',
                'no_hp' => '081234567890',
                'nama_ayah' => 'Ayah Demo',
                'nama_ibu' => 'Ibu Demo',
                'semester' => '4',
                'ipk' => '3.50',
                'nama_bank' => 'Bank Papua',
                'nomor_rekening' => '1234567890',
                'nama_pemilik_rekening' => 'Mahasiswa Teluk Bintuni',
                'alamat' => 'Teluk Bintuni',
            ])
            ->assertRedirect(route('mahasiswa.profile.edit'));

        $this->assertDatabaseHas('mahasiswa_profiles', [
            'user_id' => $user->id,
            'nik' => '9100000000000001',
            'nim' => 'MHS001',
            'nama_lengkap' => 'Mahasiswa Teluk Bintuni',
        ]);

        $this->assertInstanceOf(MahasiswaProfile::class, $user->fresh()->mahasiswaProfile);
    }
}
