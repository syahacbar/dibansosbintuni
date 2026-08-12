<?php

namespace Tests\Feature;

use App\Enums\JenisBeasiswa;
use App\Enums\JenisPenerima;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class MahasiswaRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'Mahasiswa']);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Pendaftaran Akun Mahasiswa');
        $response->assertSee('Jenis Beasiswa');
        $response->assertSee('Jenis Penerima');
    }

    public function test_new_students_can_register_with_jenis_beasiswa_and_jenis_penerima(): void
    {
        $response = $this->post('/register', [
            'name' => 'Mahasiswa Baru Bintuni',
            'email' => 'mhsbaru@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'nik' => '9100000000999999',
            'nim' => 'MHS999',
            'jenis_beasiswa' => 'kedinasan',
            'jenis_penerima' => 'OAP',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));

        $user = User::where('email', 'mhsbaru@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('Mahasiswa'));

        $profile = $user->mahasiswaProfile;
        $this->assertNotNull($profile);
        $this->assertSame('Mahasiswa Baru Bintuni', $profile->nama_lengkap);
        $this->assertSame('9100000000999999', $profile->nik);
        $this->assertSame('MHS999', $profile->nim);
        $this->assertSame(JenisBeasiswa::Kedinasan, $profile->jenis_beasiswa);
        $this->assertSame(JenisPenerima::Oap, $profile->jenis_penerima);
    }
}
