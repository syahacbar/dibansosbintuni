<?php

namespace Tests\Feature;

use App\Enums\PengajuanStatus;
use App\Models\JenisBantuan;
use App\Models\MahasiswaProfile;
use App\Models\Pengajuan;
use App\Models\PeriodeBansos;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonitoringDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_monitoring_dashboard_shows_widgets_and_dummy_chart(): void
    {
        $admin = User::factory()->create();
        $student = User::factory()->create();
        MahasiswaProfile::create([
            'user_id' => $student->id,
            'nama_lengkap' => 'Mahasiswa Monitoring',
        ]);
        $periode = PeriodeBansos::create([
            'kode' => 'PB-2026',
            'nama' => 'Periode 2026',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-12-31',
            'aktif' => true,
        ]);
        $jenisBantuan = JenisBantuan::create([
            'kode' => 'UKT',
            'nama' => 'Bantuan UKT',
            'aktif' => true,
        ]);
        Pengajuan::create([
            'user_id' => $student->id,
            'periode_bansos_id' => $periode->id,
            'jenis_bantuan_id' => $jenisBantuan->id,
            'nomor_pengajuan' => 'PGJ-MONITORING-1',
            'status' => PengajuanStatus::Ditolak,
            'verified_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('monitoring.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Monitoring')
            ->assertSee('Total Mahasiswa')
            ->assertSee('Total Pengajuan')
            ->assertSee('Total Verifikasi')
            ->assertSee('Total Ditolak')
            ->assertSee('Grafik Pengajuan Dummy')
            ->assertSee('Jan')
            ->assertSee('Ditolak');
    }
}
