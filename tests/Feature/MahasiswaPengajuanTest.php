<?php

namespace Tests\Feature;

use App\Enums\PengajuanStatus;
use App\Models\JenisBantuan;
use App\Models\Pengajuan;
use App\Models\PeriodeBansos;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaPengajuanTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengajuan_pages_can_be_accessed(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('mahasiswa.pengajuan.index'))
            ->assertOk()
            ->assertSee('Pengajuan Bantuan');

        $this->get(route('mahasiswa.pengajuan.create'))
            ->assertOk()
            ->assertSee('Buat Pengajuan');
    }

    public function test_student_can_create_draft_and_submit_pengajuan(): void
    {
        $user = User::factory()->create();
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

        $this->actingAs($user)
            ->post(route('mahasiswa.pengajuan.store'), [
                'periode_bansos_id' => $periode->id,
                'jenis_bantuan_id' => $jenisBantuan->id,
                'catatan' => 'Butuh bantuan UKT',
            ])
            ->assertRedirect();

        $pengajuan = Pengajuan::firstOrFail();

        $this->assertSame(PengajuanStatus::Draft, $pengajuan->status);
        $this->assertDatabaseHas('pengajuan_timelines', [
            'pengajuan_id' => $pengajuan->id,
            'status' => PengajuanStatus::Draft->value,
        ]);

        $this->actingAs($user)
            ->put(route('mahasiswa.pengajuan.update', $pengajuan), [
                'periode_bansos_id' => $periode->id,
                'jenis_bantuan_id' => $jenisBantuan->id,
                'catatan' => 'Catatan diperbarui',
            ])
            ->assertRedirect(route('mahasiswa.pengajuan.show', $pengajuan));

        $this->actingAs($user)
            ->post(route('mahasiswa.pengajuan.submit', $pengajuan))
            ->assertRedirect(route('mahasiswa.pengajuan.show', $pengajuan));

        $pengajuan->refresh();

        $this->assertSame(PengajuanStatus::Diajukan, $pengajuan->status);
        $this->assertNotNull($pengajuan->submitted_at);
        $this->assertDatabaseHas('pengajuan_timelines', [
            'pengajuan_id' => $pengajuan->id,
            'status' => PengajuanStatus::Diajukan->value,
        ]);
    }

    public function test_student_cannot_access_other_student_pengajuan(): void
    {
        $owner = User::factory()->create();
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
        $pengajuan = Pengajuan::create([
            'user_id' => $owner->id,
            'periode_bansos_id' => $periode->id,
            'jenis_bantuan_id' => $jenisBantuan->id,
            'nomor_pengajuan' => 'PGJ-TEST',
            'status' => PengajuanStatus::Draft,
        ]);

        $this->actingAs($otherUser)
            ->get(route('mahasiswa.pengajuan.show', $pengajuan))
            ->assertForbidden();
    }
}
