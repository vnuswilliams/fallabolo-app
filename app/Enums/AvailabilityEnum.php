<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum AvailabilityEnum: string
{
    use EnumTrait;

    case IMMEDIATE = 'immediate';
    case FIFTEEN_DAYS = '15_days';
    case THIRTY_DAYS = '30_days';
    case MORE = 'more';

    public function label(): string
    {
        return match ($this) {
            self::IMMEDIATE => 'Immédiate',
            self::FIFTEEN_DAYS => '15 jours',
            self::THIRTY_DAYS => '30 jours',
            self::MORE => "Plus d'un mois",
        };
    }

    public function valueWeight(): int
    {
        return match ($this) {
            self::IMMEDIATE => 0,
            self::FIFTEEN_DAYS => 1,
            self::THIRTY_DAYS => 2,
            self::MORE => 3,
        };
    }
}
