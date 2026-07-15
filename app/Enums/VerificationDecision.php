<?php

namespace App\Enums;

enum VerificationDecision: string
{
    case Passed = 'passed';
    case NeedsReview = 'needs_review';
    case Approved = 'approved';
    case Revision = 'revision';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Passed => 'Lolos',
            self::NeedsReview => 'Perlu Review',
            self::Approved => 'Disetujui',
            self::Revision => 'Revisi',
            self::Rejected => 'Ditolak',
        };
    }
}
