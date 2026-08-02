<?php

namespace Tests\Feature;

use App\Enums\PengajuanStatus;
use App\Enums\VerificationLayer;
use App\Models\JenisBantuan;
use App\Models\MahasiswaProfile;
use App\Models\Pengajuan;
use App\Models\PeriodeBansos;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerificationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_operator_detail_runs_dummy_system_verification_layers(): void
    {
        $operator = User::factory()->create();
        $pengajuan = $this->createSubmittedPengajuan();

        $this->actingAs($operator)
            ->get(route('operator.pengajuan.show', $pengajuan))
            ->assertOk()
            ->assertSee('Verifikasi 3 Layer')
            ->assertSee('Verification Score');

        $pengajuan->refresh();

        $this->assertNotNull($pengajuan->verification_score);
        $this->assertDatabaseHas('pengajuan_verifications', [
            'pengajuan_id' => $pengajuan->id,
            'layer' => VerificationLayer::AutoValidation->value,
        ]);
        $this->assertDatabaseHas('pengajuan_verifications', [
            'pengajuan_id' => $pengajuan->id,
            'layer' => VerificationLayer::SmartVerification->value,
        ]);
    }

    public function test_operator_can_approve_pengajuan(): void
    {
        $operator = User::factory()->create();
        $pengajuan = $this->createSubmittedPengajuan();

        $this->actingAs($operator)
            ->post(route('operator.pengajuan.verify', $pengajuan), [
                'decision' => 'approve',
                'notes' => 'Data lengkap.',
            ])
            ->assertRedirect(route('operator.pengajuan.show', $pengajuan));

        $pengajuan->refresh();

        $this->assertSame(PengajuanStatus::Disetujui, $pengajuan->status);
        $this->assertSame($operator->id, $pengajuan->verified_by);
        $this->assertDatabaseHas('pengajuan_verifications', [
            'pengajuan_id' => $pengajuan->id,
            'layer' => VerificationLayer::HumanVerification->value,
            'decision' => 'approved',
        ]);
        $this->assertDatabaseHas('pengajuan_timelines', [
            'pengajuan_id' => $pengajuan->id,
            'status' => PengajuanStatus::Disetujui->value,
        ]);
    }

    public function test_revision_and_reject_require_notes(): void
    {
        $operator = User::factory()->create();
        $pengajuan = $this->createSubmittedPengajuan();

        $this->actingAs($operator)
            ->post(route('operator.pengajuan.verify', $pengajuan), [
                'decision' => 'revision',
                'notes' => '',
            ])
            ->assertSessionHasErrors('notes');
    }

    public function test_operator_can_request_revision_and_reject(): void
    {
        $operator = User::factory()->create();
        $revisionPengajuan = $this->createSubmittedPengajuan('PGJ-REV');
        $rejectPengajuan = $this->createSubmittedPengajuan('PGJ-REJ');

        $this->actingAs($operator)
            ->post(route('operator.pengajuan.verify', $revisionPengajuan), [
                'decision' => 'revision',
                'notes' => 'Perbaiki dokumen rekening.',
            ])
            ->assertRedirect(route('operator.pengajuan.show', $revisionPengajuan));

        $this->actingAs($operator)
            ->post(route('operator.pengajuan.verify', $rejectPengajuan), [
                'decision' => 'reject',
                'notes' => 'Tidak memenuhi persyaratan.',
            ])
            ->assertRedirect(route('operator.pengajuan.show', $rejectPengajuan));

        $this->assertSame(PengajuanStatus::Revisi, $revisionPengajuan->fresh()->status);
        $this->assertSame(PengajuanStatus::Ditolak, $rejectPengajuan->fresh()->status);
    }

    public function test_operator_can_mark_approved_pengajuan_as_disalurkan(): void
    {
        $operator = User::factory()->create();
        $pengajuan = $this->createSubmittedPengajuan('PGJ-SALUR');
        $pengajuan->update(['status' => PengajuanStatus::Disetujui, 'verified_at' => now(), 'verified_by' => $operator->id]);

        $this->actingAs($operator)
            ->post(route('operator.pengajuan.salurkan', $pengajuan), [
                'nomor_sp2d' => 'SP2D/2026/001928',
                'notes' => 'Telah dikirim via Bank Papua',
            ])
            ->assertRedirect(route('operator.pengajuan.show', $pengajuan))
            ->assertSessionHas('success');

        $pengajuan->refresh();

        $this->assertSame(PengajuanStatus::Disalurkan, $pengajuan->status);
        $this->assertSame('SP2D/2026/001928', $pengajuan->nomor_sp2d);
        $this->assertNotNull($pengajuan->disalurkan_at);
        $this->assertDatabaseHas('pengajuan_timelines', [
            'pengajuan_id' => $pengajuan->id,
            'status' => PengajuanStatus::Disalurkan->value,
        ]);
    }

    public function test_operator_can_view_penerima_list(): void
    {
        $operator = User::factory()->create();
        $approvedPengajuan = $this->createSubmittedPengajuan('PGJ-OK');
        $approvedPengajuan->update(['status' => PengajuanStatus::Disetujui]);

        $this->actingAs($operator)
            ->get(route('operator.penerima.index'))
            ->assertOk()
            ->assertSee('Daftar Penerima Bantuan Sosial')
            ->assertSee('PGJ-OK');
    }

    private function createSubmittedPengajuan(string $number = 'PGJ-VERIFY'): Pengajuan
    {
        $user = User::factory()->create();
        $suffix = substr(abs(crc32($number)), 0, 6);
        MahasiswaProfile::create([
            'user_id' => $user->id,
            'nik' => '9100000000'.$suffix,
            'nim' => 'MHS'.$suffix,
            'nama_lengkap' => $user->name,
            'nama_bank' => 'Bank Papua',
            'nomor_rekening' => '1234567890',
        ]);
        $periode = PeriodeBansos::create([
            'kode' => 'PB-'.$number,
            'nama' => 'Periode '.$number,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-12-31',
            'aktif' => true,
        ]);
        $jenisBantuan = JenisBantuan::create([
            'kode' => 'JB-'.$number,
            'nama' => 'Bantuan '.$number,
            'aktif' => true,
        ]);

        return Pengajuan::create([
            'user_id' => $user->id,
            'periode_bansos_id' => $periode->id,
            'jenis_bantuan_id' => $jenisBantuan->id,
            'nomor_pengajuan' => $number,
            'status' => PengajuanStatus::Diajukan,
            'submitted_at' => now(),
        ]);
    }
}
