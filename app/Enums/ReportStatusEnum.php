<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum ReportStatusEnum: string
{
    use EnumTrait;

    case PENDING = 'pending';
    case REVIEWED = 'reviewed';
    case DISMISSED = 'dismissed';
    case CONFIRMED = 'confirmed';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::REVIEWED => 'Examiné',
            self::DISMISSED => 'Rejeté',
            self::CONFIRMED => 'Confirmé',
        };
    }
}
