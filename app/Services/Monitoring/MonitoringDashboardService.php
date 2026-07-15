<?php

namespace App\Services\Monitoring;

use App\Enums\PengajuanStatus;
use App\Models\MahasiswaProfile;
use App\Models\Pengajuan;

class MonitoringDashboardService
{
    public function widgets(): array
    {
        return [
            'total_mahasiswa' => MahasiswaProfile::count(),
            'total_pengajuan' => Pengajuan::count(),
            'total_verifikasi' => Pengajuan::whereNotNull('verified_at')->count(),
            'total_ditolak' => Pengajuan::where('status', PengajuanStatus::Ditolak->value)->count(),
        ];
    }

    public function dummyChart(): array
    {
        return [
            ['label' => 'Jan', 'value' => 12],
            ['label' => 'Feb', 'value' => 18],
            ['label' => 'Mar', 'value' => 16],
            ['label' => 'Apr', 'value' => 24],
            ['label' => 'Mei', 'value' => 30],
            ['label' => 'Jun', 'value' => 27],
        ];
    }

    public function statusDistribution(): array
    {
        return [
            'Draft' => Pengajuan::where('status', PengajuanStatus::Draft->value)->count(),
            'Diajukan' => Pengajuan::where('status', PengajuanStatus::Diajukan->value)->count(),
            'Disetujui' => Pengajuan::where('status', PengajuanStatus::Disetujui->value)->count(),
            'Revisi' => Pengajuan::where('status', PengajuanStatus::Revisi->value)->count(),
            'Ditolak' => Pengajuan::where('status', PengajuanStatus::Ditolak->value)->count(),
        ];
    }
}
