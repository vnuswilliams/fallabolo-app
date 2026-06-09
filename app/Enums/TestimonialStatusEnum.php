<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum TestimonialStatusEnum: string
{
    use EnumTrait;

    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::APPROVED => 'Approuvé',
            self::REJECTED => 'Rejeté',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'amber',
            self::APPROVED => 'emerald',
            self::REJECTED => 'rose',
        };
    }
}
