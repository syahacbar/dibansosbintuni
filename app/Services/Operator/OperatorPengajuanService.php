<?php

namespace App\Services\Operator;

use App\Enums\PengajuanStatus;
use App\Models\Pengajuan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class OperatorPengajuanService
{
    public function stats(): array
    {
        return [
            'total' => Pengajuan::count(),
            'draft' => Pengajuan::where('status', PengajuanStatus::Draft->value)->count(),
            'diajukan' => Pengajuan::where('status', PengajuanStatus::Diajukan->value)->count(),
            'latest' => Pengajuan::with(['user', 'periodeBansos', 'jenisBantuan'])
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }

    public function paginate(array $filters): LengthAwarePaginator
    {
        return $this->baseQuery()
            ->when($filters['search'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('nomor_pengajuan', 'like', "%{$search}%")
                        ->orWhereRelation('user', 'name', 'like', "%{$search}%")
                        ->orWhereRelation('user', 'email', 'like', "%{$search}%")
                        ->orWhereRelation('jenisBantuan', 'nama', 'like', "%{$search}%")
                        ->orWhereRelation('periodeBansos', 'nama', 'like', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status))
            ->when($filters['periode_bansos_id'] ?? null, fn (Builder $query, string $periodeId) => $query->where('periode_bansos_id', $periodeId))
            ->when($filters['jenis_bantuan_id'] ?? null, fn (Builder $query, string $jenisId) => $query->where('jenis_bantuan_id', $jenisId))
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function findForDetail(Pengajuan $pengajuan): Pengajuan
    {
        return $pengajuan->load([
            'user.mahasiswaProfile.programStudi.fakultas.perguruanTinggi',
            'user.mahasiswaProfile.distrik',
            'user.mahasiswaProfile.kampung',
            'user.mahasiswaDocuments',
            'periodeBansos',
            'jenisBantuan',
            'timelines',
            'verifications.operator',
            'verifier',
        ]);
    }

    /**
     * @return Collection<int, Pengajuan>
     */
    public function latest(): Collection
    {
        return $this->baseQuery()->latest()->limit(5)->get();
    }

    private function baseQuery(): Builder
    {
        return Pengajuan::query()->with(['user', 'periodeBansos', 'jenisBantuan']);
    }
}
