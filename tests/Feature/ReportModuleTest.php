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

class ReportModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_index_shows_mahasiswa_pengajuan_and_penerima_reports(): void
    {
        $admin = User::factory()->create();
        $this->createReportData();

        $this->actingAs($admin)
            ->get(route('reports.index', ['type' => 'mahasiswa']))
            ->assertOk()
            ->assertSee('Laporan Mahasiswa')
            ->assertSee('Mahasiswa Report');

        $this->actingAs($admin)
            ->get(route('reports.index', ['type' => 'pengajuan']))
            ->assertOk()
            ->assertSee('Laporan Pengajuan')
            ->assertSee('PGJ-REPORT');

        $this->actingAs($admin)
            ->get(route('reports.index', ['type' => 'penerima']))
            ->assertOk()
            ->assertSee('Laporan Penerima')
            ->assertSee('90');
    }

    public function test_report_can_be_exported_to_pdf_and_excel(): void
    {
        $admin = User::factory()->create();
        $this->createReportData();

        $this->actingAs($admin)
            ->get(route('reports.pdf', 'pengajuan'))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $this->actingAs($admin)
            ->get(route('reports.excel', 'pengajuan'))
            ->assertOk()
            ->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    private function createReportData(): void
    {
        $student = User::factory()->create([
            'name' => 'Mahasiswa Report',
            'email' => 'mahasiswa.report@example.com',
        ]);
        MahasiswaProfile::create([
            'user_id' => $student->id,
            'nama_lengkap' => 'Mahasiswa Report',
            'nik' => '9100000000000001',
            'nim' => 'RPT001',
            'no_hp' => '081234567890',
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
            'nomor_pengajuan' => 'PGJ-REPORT',
            'status' => PengajuanStatus::Disetujui,
            'verification_score' => 90,
            'submitted_at' => now(),
            'verified_at' => now(),
        ]);
    }
}
