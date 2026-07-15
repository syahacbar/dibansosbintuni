<?php

namespace App\Services\Mahasiswa;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Support\Collection;

class DashboardService
{
    public function latestPengajuan(User $user): ?Pengajuan
    {
        return $user->pengajuans()
            ->with(['periodeBansos', 'jenisBantuan', 'timelines', 'verifier'])
            ->latest()
            ->first();
    }

    /**
     * @return Collection<int, Pengajuan>
     */
    public function history(User $user): Collection
    {
        return $user->pengajuans()
            ->with(['periodeBansos', 'jenisBantuan'])
            ->latest()
            ->limit(10)
            ->get();
    }

    public function summary(User $user): array
    {
        return [
            'total' => $user->pengajuans()->count(),
            'draft' => $user->pengajuans()->where('status', 'draft')->count(),
            'diajukan' => $user->pengajuans()->where('status', 'diajukan')->count(),
            'selesai' => $user->pengajuans()
                ->whereIn('status', ['disetujui', 'revisi', 'ditolak'])
                ->count(),
        ];
    }
}
