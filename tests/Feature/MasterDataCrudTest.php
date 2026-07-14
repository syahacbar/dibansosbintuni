<?php

namespace Tests\Feature;

use App\Models\Distrik;
use App\Models\Fakultas;
use App\Models\JenisBantuan;
use App\Models\Kampung;
use App\Models\PerguruanTinggi;
use App\Models\PeriodeBansos;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_periode_bansos_crud_can_be_accessed(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('master-data.periode-bansos.index'))->assertOk();
        $this->get(route('master-data.periode-bansos.create'))->assertOk();

        $this->post(route('master-data.periode-bansos.store'), [
            'kode' => 'PB-2026',
            'nama' => 'Periode 2026',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-12-31',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.periode-bansos.index'));

        $periodeBansos = PeriodeBansos::firstOrFail();

        $this->get(route('master-data.periode-bansos.show', $periodeBansos))->assertOk();
        $this->get(route('master-data.periode-bansos.edit', $periodeBansos))->assertOk();
        $this->put(route('master-data.periode-bansos.update', $periodeBansos), [
            'kode' => 'PB-2026',
            'nama' => 'Periode 2026 Update',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-12-31',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.periode-bansos.index'));
        $this->delete(route('master-data.periode-bansos.destroy', $periodeBansos))->assertRedirect(route('master-data.periode-bansos.index'));
    }

    public function test_jenis_bantuan_crud_can_be_accessed(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('master-data.jenis-bantuan.index'))->assertOk();
        $this->get(route('master-data.jenis-bantuan.create'))->assertOk();

        $this->post(route('master-data.jenis-bantuan.store'), [
            'kode' => 'UKT',
            'nama' => 'Bantuan UKT',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.jenis-bantuan.index'));

        $jenisBantuan = JenisBantuan::firstOrFail();

        $this->get(route('master-data.jenis-bantuan.show', $jenisBantuan))->assertOk();
        $this->get(route('master-data.jenis-bantuan.edit', $jenisBantuan))->assertOk();
        $this->put(route('master-data.jenis-bantuan.update', $jenisBantuan), [
            'kode' => 'UKT',
            'nama' => 'Bantuan UKT Update',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.jenis-bantuan.index'));
        $this->delete(route('master-data.jenis-bantuan.destroy', $jenisBantuan))->assertRedirect(route('master-data.jenis-bantuan.index'));
    }

    public function test_perguruan_tinggi_crud_can_be_accessed(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('master-data.perguruan-tinggi.index'))->assertOk();
        $this->get(route('master-data.perguruan-tinggi.create'))->assertOk();

        $this->post(route('master-data.perguruan-tinggi.store'), [
            'kode' => 'UNIPA',
            'nama' => 'Universitas Papua',
            'alamat' => 'Manokwari',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.perguruan-tinggi.index'));

        $perguruanTinggi = PerguruanTinggi::firstOrFail();

        $this->get(route('master-data.perguruan-tinggi.show', $perguruanTinggi))->assertOk();
        $this->get(route('master-data.perguruan-tinggi.edit', $perguruanTinggi))->assertOk();
        $this->put(route('master-data.perguruan-tinggi.update', $perguruanTinggi), [
            'kode' => 'UNIPA',
            'nama' => 'Universitas Papua Update',
            'alamat' => 'Manokwari',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.perguruan-tinggi.index'));
        $this->delete(route('master-data.perguruan-tinggi.destroy', $perguruanTinggi))->assertRedirect(route('master-data.perguruan-tinggi.index'));
    }

    public function test_fakultas_crud_can_be_accessed(): void
    {
        $this->actingAs(User::factory()->create());
        $perguruanTinggi = PerguruanTinggi::create(['kode' => 'UNIPA', 'nama' => 'Universitas Papua', 'aktif' => true]);

        $this->get(route('master-data.fakultas.index'))->assertOk();
        $this->get(route('master-data.fakultas.create'))->assertOk();

        $this->post(route('master-data.fakultas.store'), [
            'perguruan_tinggi_id' => $perguruanTinggi->id,
            'kode' => 'FT',
            'nama' => 'Fakultas Teknik',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.fakultas.index'));

        $fakultas = Fakultas::firstOrFail();

        $this->get(route('master-data.fakultas.show', $fakultas))->assertOk();
        $this->get(route('master-data.fakultas.edit', $fakultas))->assertOk();
        $this->put(route('master-data.fakultas.update', $fakultas), [
            'perguruan_tinggi_id' => $perguruanTinggi->id,
            'kode' => 'FT',
            'nama' => 'Fakultas Teknik Update',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.fakultas.index'));
        $this->delete(route('master-data.fakultas.destroy', $fakultas))->assertRedirect(route('master-data.fakultas.index'));
    }

    public function test_program_studi_crud_can_be_accessed(): void
    {
        $this->actingAs(User::factory()->create());
        $perguruanTinggi = PerguruanTinggi::create(['kode' => 'UNIPA', 'nama' => 'Universitas Papua', 'aktif' => true]);
        $fakultas = Fakultas::create(['perguruan_tinggi_id' => $perguruanTinggi->id, 'kode' => 'FT', 'nama' => 'Fakultas Teknik', 'aktif' => true]);

        $this->get(route('master-data.program-studi.index'))->assertOk();
        $this->get(route('master-data.program-studi.create'))->assertOk();

        $this->post(route('master-data.program-studi.store'), [
            'fakultas_id' => $fakultas->id,
            'kode' => 'IF',
            'nama' => 'Informatika',
            'jenjang' => 'S1',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.program-studi.index'));

        $programStudi = ProgramStudi::firstOrFail();

        $this->get(route('master-data.program-studi.show', $programStudi))->assertOk();
        $this->get(route('master-data.program-studi.edit', $programStudi))->assertOk();
        $this->put(route('master-data.program-studi.update', $programStudi), [
            'fakultas_id' => $fakultas->id,
            'kode' => 'IF',
            'nama' => 'Informatika Update',
            'jenjang' => 'S1',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.program-studi.index'));
        $this->delete(route('master-data.program-studi.destroy', $programStudi))->assertRedirect(route('master-data.program-studi.index'));
    }

    public function test_distrik_crud_can_be_accessed(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('master-data.distrik.index'))->assertOk();
        $this->get(route('master-data.distrik.create'))->assertOk();

        $this->post(route('master-data.distrik.store'), [
            'kode' => 'BNT',
            'nama' => 'Bintuni',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.distrik.index'));

        $distrik = Distrik::firstOrFail();

        $this->get(route('master-data.distrik.show', $distrik))->assertOk();
        $this->get(route('master-data.distrik.edit', $distrik))->assertOk();
        $this->put(route('master-data.distrik.update', $distrik), [
            'kode' => 'BNT',
            'nama' => 'Bintuni Update',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.distrik.index'));
        $this->delete(route('master-data.distrik.destroy', $distrik))->assertRedirect(route('master-data.distrik.index'));
    }

    public function test_kampung_crud_can_be_accessed(): void
    {
        $this->actingAs(User::factory()->create());
        $distrik = Distrik::create(['kode' => 'BNT', 'nama' => 'Bintuni', 'aktif' => true]);

        $this->get(route('master-data.kampung.index'))->assertOk();
        $this->get(route('master-data.kampung.create'))->assertOk();

        $this->post(route('master-data.kampung.store'), [
            'distrik_id' => $distrik->id,
            'kode' => 'KPG',
            'nama' => 'Kampung Lama',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.kampung.index'));

        $kampung = Kampung::firstOrFail();

        $this->get(route('master-data.kampung.show', $kampung))->assertOk();
        $this->get(route('master-data.kampung.edit', $kampung))->assertOk();
        $this->put(route('master-data.kampung.update', $kampung), [
            'distrik_id' => $distrik->id,
            'kode' => 'KPG',
            'nama' => 'Kampung Lama Update',
            'aktif' => '1',
        ])->assertRedirect(route('master-data.kampung.index'));
        $this->delete(route('master-data.kampung.destroy', $kampung))->assertRedirect(route('master-data.kampung.index'));
    }
}
