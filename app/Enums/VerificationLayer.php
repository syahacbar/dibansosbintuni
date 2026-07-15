<?php

namespace App\Enums;

enum VerificationLayer: string
{
    case AutoValidation = 'auto_validation';
    case SmartVerification = 'smart_verification';
    case HumanVerification = 'human_verification';

    public function label(): string
    {
        return match ($this) {
            self::AutoValidation => 'Layer 1 - Auto Validation',
            self::SmartVerification => 'Layer 2 - Smart Verification',
            self::HumanVerification => 'Layer 3 - Human Verification',
        };
    }
}
