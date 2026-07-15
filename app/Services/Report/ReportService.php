<?php

namespace App\Services\Report;

use App\Enums\PengajuanStatus;
use App\Models\MahasiswaProfile;
use App\Models\Pengajuan;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class ReportService
{
    public function title(string $type): string
    {
        return match ($type) {
            'mahasiswa' => 'Laporan Mahasiswa',
            'pengajuan' => 'Laporan Pengajuan',
            'penerima' => 'Laporan Penerima',
            default => throw new InvalidArgumentException('Tipe laporan tidak valid.'),
        };
    }

    public function headings(string $type): array
    {
        return match ($type) {
            'mahasiswa' => ['Nama', 'Email', 'NIK', 'NIM', 'Program Studi', 'No. HP'],
            'pengajuan' => ['Nomor', 'Mahasiswa', 'Periode', 'Jenis Bantuan', 'Status', 'Tanggal Submit'],
            'penerima' => ['Nomor', 'Mahasiswa', 'Jenis Bantuan', 'Verification Score', 'Tanggal Verifikasi'],
            default => throw new InvalidArgumentException('Tipe laporan tidak valid.'),
        };
    }

    public function rows(string $type): Collection
    {
        return match ($type) {
            'mahasiswa' => $this->mahasiswaRows(),
            'pengajuan' => $this->pengajuanRows(),
            'penerima' => $this->penerimaRows(),
            default => throw new InvalidArgumentException('Tipe laporan tidak valid.'),
        };
    }

    public function filename(string $type, string $extension): string
    {
        return $type.'-'.now()->format('Ymd-His').'.'.$extension;
    }

    private function mahasiswaRows(): Collection
    {
        return MahasiswaProfile::query()
            ->with(['user', 'programStudi'])
            ->orderBy('nama_lengkap')
            ->get()
            ->map(fn (MahasiswaProfile $profile): array => [
                $profile->nama_lengkap,
                $profile->user?->email,
                $profile->nik,
                $profile->nim,
                $profile->programStudi?->nama ?: $profile->program_studi_nama,
                $profile->no_hp,
            ]);
    }

    private function pengajuanRows(): Collection
    {
        return Pengajuan::query()
            ->with(['user', 'periodeBansos', 'jenisBantuan'])
            ->latest()
            ->get()
            ->map(fn (Pengajuan $pengajuan): array => [
                $pengajuan->nomor_pengajuan,
                $pengajuan->user?->name,
                $pengajuan->periodeBansos?->nama,
                $pengajuan->jenisBantuan?->nama,
                $pengajuan->status->label(),
                $pengajuan->submitted_at?->format('d/m/Y H:i'),
            ]);
    }

    private function penerimaRows(): Collection
    {
        return Pengajuan::query()
            ->with(['user', 'jenisBantuan'])
            ->where('status', PengajuanStatus::Disetujui->value)
            ->latest('verified_at')
            ->get()
            ->map(fn (Pengajuan $pengajuan): array => [
                $pengajuan->nomor_pengajuan,
                $pengajuan->user?->name,
                $pengajuan->jenisBantuan?->nama,
                $pengajuan->verification_score,
                $pengajuan->verified_at?->format('d/m/Y H:i'),
            ]);
    }
}
