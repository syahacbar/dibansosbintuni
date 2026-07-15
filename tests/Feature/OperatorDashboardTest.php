<?php

namespace Tests\Feature;

use App\Enums\PengajuanStatus;
use App\Enums\StudentDocumentType;
use App\Models\JenisBantuan;
use App\Models\MahasiswaDocument;
use App\Models\MahasiswaProfile;
use App\Models\Pengajuan;
use App\Models\PengajuanTimeline;
use App\Models\PeriodeBansos;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OperatorDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_operator_dashboard_can_be_accessed(): void
    {
        $operator = User::factory()->create();
        $this->createPengajuan();

        $this->actingAs($operator)
            ->get(route('operator.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Operator')
            ->assertSee('Total Pengajuan')
            ->assertSee('Diajukan');
    }

    public function test_operator_can_search_and_filter_pengajuan(): void
    {
        $operator = User::factory()->create();
        $pengajuan = $this->createPengajuan();

        $this->actingAs($operator)
            ->get(route('operator.pengajuan.index', [
                'search' => $pengajuan->nomor_pengajuan,
                'status' => PengajuanStatus::Diajukan->value,
                'periode_bansos_id' => $pengajuan->periode_bansos_id,
                'jenis_bantuan_id' => $pengajuan->jenis_bantuan_id,
            ]))
            ->assertOk()
            ->assertSee($pengajuan->nomor_pengajuan)
            ->assertSee($pengajuan->user->name);
    }

    public function test_operator_can_view_pengajuan_detail_and_document_preview(): void
    {
        Storage::fake('public');

        $operator = User::factory()->create();
        $pengajuan = $this->createPengajuan();
        MahasiswaProfile::create([
            'user_id' => $pengajuan->user_id,
            'nama_lengkap' => 'Mahasiswa Demo',
            'nik' => '9100000000000001',
            'nim' => 'MHS001',
        ]);
        Storage::disk('public')->put('mahasiswa/1/documents/ktp.jpg', 'fake-image');
        MahasiswaDocument::create([
            'user_id' => $pengajuan->user_id,
            'document_type' => StudentDocumentType::Ktp,
            'file_path' => 'mahasiswa/1/documents/ktp.jpg',
            'original_name' => 'ktp.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 100,
        ]);

        $this->actingAs($operator)
            ->get(route('operator.pengajuan.show', $pengajuan))
            ->assertOk()
            ->assertSee('Detail Pengajuan')
            ->assertSee('Preview Dokumen')
            ->assertSee('ktp.jpg');
    }

    public function test_operator_routes_are_read_only(): void
    {
        $this->assertFalse(route('operator.pengajuan.index') === route('mahasiswa.pengajuan.store'));

        $this->actingAs(User::factory()->create())
            ->post('/operator/pengajuan')
            ->assertMethodNotAllowed();
    }

    private function createPengajuan(): Pengajuan
    {
        $user = User::factory()->create(['name' => 'Mahasiswa Operator Test']);
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
            'nomor_pengajuan' => 'PGJ-OPR-'.fake()->unique()->numerify('####'),
            'status' => PengajuanStatus::Diajukan,
            'submitted_at' => now(),
        ]);
        PengajuanTimeline::create([
            'pengajuan_id' => $pengajuan->id,
            'status' => PengajuanStatus::Diajukan,
            'label' => 'Pengajuan diajukan',
            'description' => 'Mahasiswa mengirim pengajuan bantuan.',
            'occurred_at' => now(),
        ]);

        return $pengajuan->load(['user', 'periodeBansos', 'jenisBantuan']);
    }
}
