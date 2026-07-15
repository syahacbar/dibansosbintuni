<?php

namespace Tests\Feature;

use App\Models\MahasiswaProfile;
use App\Models\Pengajuan;
use App\Models\PeriodeBansos;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MvpDemoSeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_seed_contains_mvp_demo_data(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', ['email' => 'admin@example.com']);
        $this->assertDatabaseHas('users', ['email' => 'operator@example.com']);
        $this->assertDatabaseHas('users', ['email' => 'mahasiswa@example.com']);
        $this->assertGreaterThanOrEqual(1, PeriodeBansos::count());
        $this->assertDatabaseHas('jenis_bantuans', ['kode' => 'BANSOS-PENDIDIKAN', 'nama' => 'Bansos Pendidikan']);
        $this->assertDatabaseHas('jenis_bantuans', ['kode' => 'BEASISWA-PRESTASI', 'nama' => 'Beasiswa Prestasi']);
        $this->assertDatabaseHas('jenis_bantuans', ['kode' => 'BEASISWA-OTSUS', 'nama' => 'Beasiswa Otsus']);
        $this->assertDatabaseMissing('jenis_bantuans', ['kode' => 'UKT']);
        $this->assertDatabaseMissing('jenis_bantuans', ['kode' => 'BH']);
        $this->assertGreaterThanOrEqual(2, MahasiswaProfile::count());
        $this->assertDatabaseHas('mahasiswa_profiles', [
            'nama_lengkap' => 'Agnes Wambrauw',
            'nama_ayah' => 'Petrus Wambrauw',
            'nama_ibu' => 'Maria Kambu',
        ]);
        $this->assertGreaterThanOrEqual(3, Pengajuan::count());
        $this->assertTrue(User::where('email', 'admin@example.com')->firstOrFail()->hasRole('Super Admin'));
    }
}
