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
        if (! $pengajuan->canBeEdited()) {
            return $pengajuan;
        }

        $pengajuan->update($data);

        return $pengajuan->refresh();
    }

    public function submit(Pengajuan $pengajuan): Pengajuan
    {
        if (! $pengajuan->canBeSubmitted()) {
            return $pengajuan;
        }

        $this->ensurePrerequisitesMet($pengajuan->user);

        $wasRevisi = $pengajuan->isRevisi();

        $pengajuan->update([
            'status' => PengajuanStatus::Diajukan,
            'submitted_at' => now(),
        ]);

        $label = $wasRevisi ? 'Pengajuan dikirim ulang' : 'Pengajuan diajukan';
        $description = $wasRevisi
            ? 'Mahasiswa memperbarui dokumen/data dan mengirim ulang pengajuan.'
            : 'Mahasiswa mengirim pengajuan bantuan.';

        $this->recordTimeline(
            $pengajuan,
            PengajuanStatus::Diajukan,
            $label,
            $description,
        );

        return $pengajuan->refresh();
    }

    public function getMissingPrerequisites(User $user): array
    {
        $missing = [];
        $user->loadMissing(['mahasiswaProfile', 'mahasiswaDocuments']);

        $profile = $user->mahasiswaProfile;
        if (! $profile || ! $profile->nik || ! $profile->nim || ! $profile->nama_lengkap || ! $profile->nama_bank || ! $profile->nomor_rekening) {
            $missing[] = 'Data Profil Mahasiswa belum lengkap (NIK, NIM, Bank, dll)';
        }

        $uploadedTypes = $user->mahasiswaDocuments->pluck('document_type')->map(fn ($type) => is_object($type) ? $type->value : (string) $type)->all();
        $allTypes = \App\Enums\StudentDocumentType::cases();

        foreach ($allTypes as $docType) {
            if (! in_array($docType->value, $uploadedTypes, true)) {
                $missing[] = "Dokumen {$docType->label()} belum diunggah";
            }
        }

        return $missing;
    }

    private function ensurePrerequisitesMet(User $user): void
    {
        $missing = $this->getMissingPrerequisites($user);
        if (! empty($missing)) {
            throw new \InvalidArgumentException('Persyaratan pengajuan belum lengkap: '.implode(', ', $missing));
        }
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
