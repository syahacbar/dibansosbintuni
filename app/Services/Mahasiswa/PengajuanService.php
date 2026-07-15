<?php

namespace App\Services\Mahasiswa;

use App\Enums\PengajuanStatus;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PengajuanService
{
    public function paginateForUser(User $user): LengthAwarePaginator
    {
        return $user->pengajuans()
            ->with(['periodeBansos', 'jenisBantuan'])
            ->latest()
            ->paginate(10);
    }

    public function createDraft(User $user, array $data): Pengajuan
    {
        $pengajuan = Pengajuan::create([
            ...$data,
            'user_id' => $user->id,
            'nomor_pengajuan' => $this->generateNumber(),
            'status' => PengajuanStatus::Draft,
        ]);

        $this->recordTimeline(
            $pengajuan,
            PengajuanStatus::Draft,
            'Draft dibuat',
            'Pengajuan bantuan dibuat sebagai draft.',
        );

        return $pengajuan;
    }

    public function updateDraft(Pengajuan $pengajuan, array $data): Pengajuan
    {
        if (! $pengajuan->isDraft()) {
            return $pengajuan;
        }

        $pengajuan->update($data);

        return $pengajuan->refresh();
    }

    public function submit(Pengajuan $pengajuan): Pengajuan
    {
        if (! $pengajuan->isDraft()) {
            return $pengajuan;
        }

        $pengajuan->update([
            'status' => PengajuanStatus::Diajukan,
            'submitted_at' => now(),
        ]);

        $this->recordTimeline(
            $pengajuan,
            PengajuanStatus::Diajukan,
            'Pengajuan diajukan',
            'Mahasiswa mengirim pengajuan bantuan.',
        );

        return $pengajuan->refresh();
    }

    private function generateNumber(): string
    {
        do {
            $number = 'PGJ-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
        } while (Pengajuan::where('nomor_pengajuan', $number)->exists());

        return $number;
    }

    private function recordTimeline(Pengajuan $pengajuan, PengajuanStatus $status, string $label, string $description): void
    {
        $pengajuan->timelines()->create([
            'status' => $status,
            'label' => $label,
            'description' => $description,
            'occurred_at' => now(),
        ]);
    }
}
