<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum ApplicationStatusEnum: string
{
    use EnumTrait;

    case PENDING = 'pending';
    case VIEWED = 'viewed';
    case SHORTLISTED = 'shortlisted';
    case REJECTED = 'rejected';
    case HIRED = 'hired';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::VIEWED => 'Consultée',
            self::SHORTLISTED => 'Présélectionnée',
            self::REJECTED => 'Refusée',
            self::HIRED => 'Recruté',
        };
    }
}
