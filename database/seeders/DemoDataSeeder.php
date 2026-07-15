<?php

namespace Database\Seeders;

use App\Enums\PengajuanStatus;
use App\Enums\StudentDocumentType;
use App\Models\Distrik;
use App\Models\Fakultas;
use App\Models\JenisBantuan;
use App\Models\Kampung;
use App\Models\MahasiswaDocument;
use App\Models\MahasiswaProfile;
use App\Models\Pengajuan;
use App\Models\PerguruanTinggi;
use App\Models\PeriodeBansos;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $periode = PeriodeBansos::updateOrCreate(
            ['kode' => '2026-REG'],
            [
                'nama' => 'Bansos Mahasiswa Reguler 2026',
                'tanggal_mulai' => '2026-01-01',
                'tanggal_selesai' => '2026-12-31',
                'deskripsi' => 'Periode demo bantuan sosial mahasiswa.',
                'aktif' => true,
            ],
        );

        $jenisUkt = JenisBantuan::updateOrCreate(
            ['kode' => 'UKT'],
            ['nama' => 'Bantuan UKT', 'deskripsi' => 'Bantuan uang kuliah tunggal.', 'aktif' => true],
        );
        $jenisHidup = JenisBantuan::updateOrCreate(
            ['kode' => 'BH'],
            ['nama' => 'Bantuan Biaya Hidup', 'deskripsi' => 'Bantuan biaya hidup mahasiswa.', 'aktif' => true],
        );

        $kampus = PerguruanTinggi::updateOrCreate(
            ['kode' => 'UNIPA'],
            ['nama' => 'Universitas Papua', 'alamat' => 'Manokwari', 'aktif' => true],
        );
        $fakultas = Fakultas::updateOrCreate(
            ['kode' => 'FT'],
            ['perguruan_tinggi_id' => $kampus->id, 'nama' => 'Fakultas Teknik', 'aktif' => true],
        );
        $programStudi = ProgramStudi::updateOrCreate(
            ['kode' => 'IF'],
            ['fakultas_id' => $fakultas->id, 'nama' => 'Informatika', 'jenjang' => 'S1', 'aktif' => true],
        );

        $distrik = Distrik::updateOrCreate(
            ['kode' => 'BNT'],
            ['nama' => 'Bintuni', 'deskripsi' => 'Distrik demo.', 'aktif' => true],
        );
        $kampung = Kampung::updateOrCreate(
            ['kode' => 'KPL'],
            ['distrik_id' => $distrik->id, 'nama' => 'Kampung Lama', 'aktif' => true],
        );

        $mahasiswa = User::where('email', 'mahasiswa@example.com')->firstOrFail();
        MahasiswaProfile::updateOrCreate(
            ['user_id' => $mahasiswa->id],
            [
                'program_studi_id' => $programStudi->id,
                'distrik_id' => $distrik->id,
                'kampung_id' => $kampung->id,
                'nik' => '9104010101010001',
                'nim' => '20260001',
                'nama_lengkap' => 'Mahasiswa Demo',
                'tempat_lahir' => 'Bintuni',
                'tanggal_lahir' => '2002-07-15',
                'jenis_kelamin' => 'L',
                'no_hp' => '081234567890',
                'nama_ayah' => 'Ayah Demo',
                'pekerjaan_ayah' => 'Nelayan',
                'nama_ibu' => 'Ibu Demo',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'perguruan_tinggi_nama' => $kampus->nama,
                'fakultas_nama' => $fakultas->nama,
                'program_studi_nama' => $programStudi->nama,
                'semester' => '5',
                'ipk' => 3.45,
                'nama_bank' => 'Bank Papua',
                'nomor_rekening' => '1234567890',
                'nama_pemilik_rekening' => 'Mahasiswa Demo',
                'alamat' => 'Kampung Lama, Distrik Bintuni',
                'rt' => '001',
                'rw' => '002',
            ],
        );

        foreach (StudentDocumentType::cases() as $type) {
            $path = "demo-documents/{$type->value}.txt";
            Storage::disk('public')->put($path, "Dokumen demo {$type->label()}");

            MahasiswaDocument::updateOrCreate(
                ['user_id' => $mahasiswa->id, 'document_type' => $type->value],
                [
                    'file_path' => $path,
                    'original_name' => $type->value.'.txt',
                    'mime_type' => 'text/plain',
                    'file_size' => strlen("Dokumen demo {$type->label()}"),
                ],
            );
        }

        $this->createPengajuan($mahasiswa, $periode, $jenisUkt, 'PGJ-DEMO-001', PengajuanStatus::Diajukan, null);
        $this->createPengajuan($mahasiswa, $periode, $jenisHidup, 'PGJ-DEMO-002', PengajuanStatus::Disetujui, 'Pengajuan memenuhi syarat demo.');

        $mahasiswaDua = User::factory()->create([
            'name' => 'Mahasiswa Kedua',
            'email' => 'mahasiswa2@example.com',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);
        $mahasiswaDua->assignRole('Mahasiswa');

        MahasiswaProfile::updateOrCreate(
            ['user_id' => $mahasiswaDua->id],
            [
                'nama_lengkap' => 'Mahasiswa Kedua',
                'nik' => '9104010101010002',
                'nim' => '20260002',
                'program_studi_id' => $programStudi->id,
                'nama_bank' => 'Bank Papua',
                'nomor_rekening' => '9876543210',
            ],
        );

        $this->createPengajuan($mahasiswaDua, $periode, $jenisUkt, 'PGJ-DEMO-003', PengajuanStatus::Ditolak, 'Data demo tidak memenuhi persyaratan.');
    }

    private function createPengajuan(User $user, PeriodeBansos $periode, JenisBantuan $jenisBantuan, string $number, PengajuanStatus $status, ?string $notes): void
    {
        $pengajuan = Pengajuan::updateOrCreate(
            ['nomor_pengajuan' => $number],
            [
                'user_id' => $user->id,
                'periode_bansos_id' => $periode->id,
                'jenis_bantuan_id' => $jenisBantuan->id,
                'status' => $status,
                'catatan' => 'Data demo MVP.',
                'verification_score' => $status === PengajuanStatus::Diajukan ? null : 85,
                'verification_notes' => $notes,
                'submitted_at' => now()->subDays(3),
                'verified_at' => $status === PengajuanStatus::Diajukan ? null : now()->subDay(),
            ],
        );

        $pengajuan->timelines()->firstOrCreate(
            ['status' => PengajuanStatus::Diajukan->value, 'label' => 'Pengajuan diajukan'],
            ['description' => 'Mahasiswa mengirim pengajuan bantuan.', 'occurred_at' => now()->subDays(3)],
        );

        if ($status !== PengajuanStatus::Diajukan) {
            $pengajuan->timelines()->firstOrCreate(
                ['status' => $status->value, 'label' => $status->label()],
                ['description' => $notes ?: 'Operator memperbarui status pengajuan.', 'occurred_at' => now()->subDay()],
            );
        }
    }
}
