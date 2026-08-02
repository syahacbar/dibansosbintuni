<?php

namespace App\Services\Operator;

use App\Enums\PengajuanStatus;
use App\Enums\StudentDocumentType;
use App\Enums\VerificationDecision;
use App\Enums\VerificationLayer;
use App\Models\Pengajuan;
use App\Models\User;

class VerificationService
{
    public function runSystemLayers(Pengajuan $pengajuan): Pengajuan
    {
        $pengajuan->loadMissing(['user.mahasiswaProfile', 'user.mahasiswaDocuments']);

        $autoScore = $this->autoValidationScore($pengajuan);
        $smartScore = $this->smartVerificationScore($pengajuan, $autoScore);
        $finalScore = (int) round(($autoScore * 0.6) + ($smartScore * 0.4));

        $this->recordLayer(
            $pengajuan,
            VerificationLayer::AutoValidation,
            $autoScore >= 70 ? VerificationDecision::Passed : VerificationDecision::NeedsReview,
            $autoScore,
            [
                'profile_complete' => $pengajuan->user->mahasiswaProfile !== null,
                'uploaded_documents' => $pengajuan->user->mahasiswaDocuments->count(),
                'required_documents' => count(StudentDocumentType::cases()),
            ],
            'Validasi otomatis memeriksa kelengkapan profil dan dokumen wajib.',
        );

        $this->recordLayer(
            $pengajuan,
            VerificationLayer::SmartVerification,
            $smartScore >= 70 ? VerificationDecision::Passed : VerificationDecision::NeedsReview,
            $smartScore,
            ['mode' => 'dummy', 'source' => 'rule_based_placeholder'],
            'Smart verification dummy menghasilkan skor awal tanpa OCR maupun AI.',
        );

        $pengajuan->forceFill(['verification_score' => $finalScore])->save();

        return $pengajuan->refresh();
    }

    public function humanDecision(Pengajuan $pengajuan, User $operator, string $decision, ?string $notes): Pengajuan
    {
        abort_unless($pengajuan->canBeVerified(), 403);

        $pengajuan = $this->runSystemLayers($pengajuan);

        $status = match ($decision) {
            'approve' => PengajuanStatus::Disetujui,
            'revision' => PengajuanStatus::Revisi,
            'reject' => PengajuanStatus::Ditolak,
        };

        $verificationDecision = match ($decision) {
            'approve' => VerificationDecision::Approved,
            'revision' => VerificationDecision::Revision,
            'reject' => VerificationDecision::Rejected,
        };

        $pengajuan->update([
            'status' => $status,
            'verification_notes' => $notes,
            'verified_by' => $operator->id,
            'verified_at' => now(),
        ]);

        $this->recordLayer(
            $pengajuan,
            VerificationLayer::HumanVerification,
            $verificationDecision,
            $pengajuan->verification_score,
            ['decision' => $decision],
            $notes,
            $operator,
        );

        $pengajuan->timelines()->create([
            'status' => $status,
            'label' => $status->label(),
            'description' => $notes ?: 'Operator memperbarui status verifikasi pengajuan.',
            'occurred_at' => now(),
        ]);

        return $pengajuan->refresh();
    }

    public function markAsDisalurkan(Pengajuan $pengajuan, User $operator, ?string $nomorSp2d, ?string $notes): Pengajuan
    {
        abort_unless($pengajuan->canBeDisalurkan(), 403);

        $pengajuan->update([
            'status' => PengajuanStatus::Disalurkan,
            'disalurkan_at' => now(),
            'nomor_sp2d' => $nomorSp2d,
            'catatan_penyaluran' => $notes,
        ]);

        $pengajuan->timelines()->create([
            'status' => PengajuanStatus::Disalurkan,
            'label' => 'Bantuan Disalurkan',
            'description' => ($nomorSp2d ? "No SP2D/Transfer: {$nomorSp2d}. " : '').($notes ?: 'Bantuan sosial pendidikan telah berhasil disalurkan/dicairkan.'),
            'occurred_at' => now(),
        ]);

        return $pengajuan->refresh();
    }

    private function autoValidationScore(Pengajuan $pengajuan): int
    {
        $score = 0;
        $profile = $pengajuan->user->mahasiswaProfile;

        if ($profile && $profile->nik && $profile->nim && $profile->nama_lengkap) {
            $score += 40;
        }

        if ($profile && $profile->nama_bank && $profile->nomor_rekening) {
            $score += 20;
        }

        $uploadedTypes = $pengajuan->user->mahasiswaDocuments
            ->pluck('document_type')
            ->map(fn (StudentDocumentType $type): string => $type->value)
            ->all();

        $requiredTypes = StudentDocumentType::values();
        $documentCompleteness = count(array_intersect($requiredTypes, $uploadedTypes)) / max(count($requiredTypes), 1);

        return min(100, $score + (int) round($documentCompleteness * 40));
    }

    private function smartVerificationScore(Pengajuan $pengajuan, int $autoScore): int
    {
        $hasSubmittedAt = $pengajuan->submitted_at !== null;
        $score = $autoScore + ($hasSubmittedAt ? 8 : 0);

        return max(0, min(100, $score));
    }

    private function recordLayer(
        Pengajuan $pengajuan,
        VerificationLayer $layer,
        VerificationDecision $decision,
        ?int $score,
        array $metadata,
        ?string $notes,
        ?User $operator = null,
    ): void {
        $pengajuan->verifications()->create([
            'operator_id' => $operator?->id,
            'layer' => $layer,
            'decision' => $decision,
            'score' => $score,
            'metadata' => $metadata,
            'notes' => $notes,
            'verified_at' => now(),
        ]);
    }
}
