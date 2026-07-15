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

        $bansosPendidikan = JenisBantuan::updateOrCreate(
            ['kode' => 'BANSOS-PENDIDIKAN'],
            [
                'nama' => 'Bansos Pendidikan',
                'deskripsi' => 'Bantuan sosial pendidikan bagi mahasiswa Kabupaten Teluk Bintuni.',
                'aktif' => true,
            ],
        );
        $beasiswaPrestasi = JenisBantuan::updateOrCreate(
            ['kode' => 'BEASISWA-PRESTASI'],
            [
                'nama' => 'Beasiswa Prestasi',
                'deskripsi' => 'Beasiswa untuk mahasiswa berprestasi akademik maupun non-akademik.',
                'aktif' => true,
            ],
        );
        $beasiswaOtsus = JenisBantuan::updateOrCreate(
            ['kode' => 'BEASISWA-OTSUS'],
            [
                'nama' => 'Beasiswa Otsus',
                'deskripsi' => 'Beasiswa afirmasi Otonomi Khusus untuk mahasiswa Papua Barat.',
                'aktif' => true,
            ],
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
        $mahasiswa->forceFill(['name' => 'Agnes Wambrauw'])->save();

        MahasiswaProfile::updateOrCreate(
            ['user_id' => $mahasiswa->id],
            [
                'program_studi_id' => $programStudi->id,
                'distrik_id' => $distrik->id,
                'kampung_id' => $kampung->id,
                'nik' => '9104010101010001',
                'nim' => '20260001',
                'nama_lengkap' => 'Agnes Wambrauw',
                'tempat_lahir' => 'Bintuni',
                'tanggal_lahir' => '2002-09-18',
                'jenis_kelamin' => 'P',
                'no_hp' => '082198120451',
                'nama_ayah' => 'Petrus Wambrauw',
                'pekerjaan_ayah' => 'Nelayan',
                'nama_ibu' => 'Maria Kambu',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'perguruan_tinggi_nama' => $kampus->nama,
                'fakultas_nama' => $fakultas->nama,
                'program_studi_nama' => $programStudi->nama,
                'semester' => '5',
                'ipk' => 3.62,
                'nama_bank' => 'Bank Papua',
                'nomor_rekening' => '1204018826',
                'nama_pemilik_rekening' => 'Agnes Wambrauw',
                'alamat' => 'Kampung Lama, Distrik Bintuni',
                'rt' => '001',
                'rw' => '002',
            ],
        );

        foreach (StudentDocumentType::cases() as $type) {
            $path = "demo-documents/{$type->value}.txt";
            Storage::disk('public')->put($path, "Dokumen contoh {$type->label()} Agnes Wambrauw");

            MahasiswaDocument::updateOrCreate(
                ['user_id' => $mahasiswa->id, 'document_type' => $type->value],
                [
                    'file_path' => $path,
                    'original_name' => $type->value.'.txt',
                    'mime_type' => 'text/plain',
                    'file_size' => strlen("Dokumen contoh {$type->label()} Agnes Wambrauw"),
                ],
            );
        }

        $this->createPengajuan($mahasiswa, $periode, $bansosPendidikan, 'PGJ-2026-0001', PengajuanStatus::Diajukan, null);
        $this->createPengajuan($mahasiswa, $periode, $beasiswaPrestasi, 'PGJ-2026-0002', PengajuanStatus::Disetujui, 'Berkas lengkap dan IPK memenuhi kriteria beasiswa prestasi.');

        $mahasiswaDua = User::updateOrCreate(
            ['email' => 'mahasiswa2@example.com'],
            [
                'name' => 'Rafael Torey',
                'password' => 'password',
                'email_verified_at' => now(),
            ],
        );
        $mahasiswaDua->assignRole('Mahasiswa');

        MahasiswaProfile::updateOrCreate(
            ['user_id' => $mahasiswaDua->id],
            [
                'program_studi_id' => $programStudi->id,
                'distrik_id' => $distrik->id,
                'kampung_id' => $kampung->id,
                'nama_lengkap' => 'Rafael Torey',
                'nik' => '9104010101010002',
                'nim' => '20260002',
                'tempat_lahir' => 'Manimeri',
                'tanggal_lahir' => '2001-11-04',
                'jenis_kelamin' => 'L',
                'no_hp' => '081248773091',
                'nama_ayah' => 'Yohanis Torey',
                'pekerjaan_ayah' => 'Petani',
                'nama_ibu' => 'Ester Wanma',
                'pekerjaan_ibu' => 'Pedagang',
                'perguruan_tinggi_nama' => $kampus->nama,
                'fakultas_nama' => $fakultas->nama,
                'program_studi_nama' => $programStudi->nama,
                'semester' => '7',
                'ipk' => 2.78,
                'nama_bank' => 'Bank Papua',
                'nomor_rekening' => '1204024457',
                'nama_pemilik_rekening' => 'Rafael Torey',
                'alamat' => 'Kampung Lama, Distrik Bintuni',
                'rt' => '003',
                'rw' => '001',
            ],
        );

        $this->createPengajuan($mahasiswaDua, $periode, $beasiswaOtsus, 'PGJ-2026-0003', PengajuanStatus::Ditolak, 'Berkas KHS belum sesuai dengan semester aktif.');

        Pengajuan::whereIn('nomor_pengajuan', ['PGJ-DEMO-001', 'PGJ-DEMO-002', 'PGJ-DEMO-003'])->delete();
        JenisBantuan::whereIn('kode', ['UKT', 'BH'])->delete();
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
                'catatan' => 'Pengajuan bantuan pendidikan tahun berjalan.',
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
