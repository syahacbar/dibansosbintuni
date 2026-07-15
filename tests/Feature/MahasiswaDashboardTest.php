<?php

namespace Tests\Feature;

use App\Enums\PengajuanStatus;
use App\Models\JenisBantuan;
use App\Models\Pengajuan;
use App\Models\PengajuanTimeline;
use App\Models\PeriodeBansos;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_dashboard_can_be_accessed_without_pengajuan(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Mahasiswa')
            ->assertSee('Belum ada pengajuan bantuan')
            ->assertSee('Belum ada riwayat pengajuan');
    }

    public function test_student_dashboard_shows_status_timeline_operator_notes_and_history(): void
    {
        $user = User::factory()->create();
        $operator = User::factory()->create(['name' => 'Operator Demo']);
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
        $pengajuan = Pengajuan::create([
            'user_id' => $user->id,
            'periode_bansos_id' => $periode->id,
            'jenis_bantuan_id' => $jenisBantuan->id,
            'nomor_pengajuan' => 'PGJ-DASHBOARD',
            'status' => PengajuanStatus::Revisi,
            'verification_score' => 75,
            'verification_notes' => 'Lengkapi dokumen KHS.',
            'verified_by' => $operator->id,
            'verified_at' => now(),
            'submitted_at' => now(),
        ]);
        PengajuanTimeline::create([
            'pengajuan_id' => $pengajuan->id,
            'status' => PengajuanStatus::Diajukan,
            'label' => 'Pengajuan diajukan',
            'description' => 'Mahasiswa mengirim pengajuan bantuan.',
            'occurred_at' => now()->subDay(),
        ]);
        PengajuanTimeline::create([
            'pengajuan_id' => $pengajuan->id,
            'status' => PengajuanStatus::Revisi,
            'label' => 'Revisi',
            'description' => 'Lengkapi dokumen KHS.',
            'occurred_at' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Status Pengajuan Terbaru')
            ->assertSee('PGJ-DASHBOARD')
            ->assertSee('Revisi')
            ->assertSee('Lengkapi dokumen KHS.')
            ->assertSee('Riwayat Pengajuan')
            ->assertSee('Bantuan UKT')
            ->assertSee('75/100');
    }

    public function test_student_dashboard_only_shows_authenticated_user_history(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
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
            'user_id' => $otherUser->id,
            'periode_bansos_id' => $periode->id,
            'jenis_bantuan_id' => $jenisBantuan->id,
            'nomor_pengajuan' => 'PGJ-OTHER',
            'status' => PengajuanStatus::Diajukan,
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee('PGJ-OTHER');
    }
}
