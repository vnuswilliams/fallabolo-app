<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum ExperienceTierEnum: string
{
    use EnumTrait;

    case TIER_0 = '0';
    case TIER_1 = '1';
    case TIER_2 = '2';
    case TIER_3 = '3';
    case TIER_4 = '4';

    public function label(): string
    {
        return match ($this) {
            self::TIER_0 => 'Sans expérience',
            self::TIER_1 => '1 à 2 ans',
            self::TIER_2 => '3 à 4 ans',
            self::TIER_3 => '5 à 10 ans',
            self::TIER_4 => 'Plus de 10 ans',
        };
    }

    public function valueWeight(): int
    {
        return (int) $this->value;
    }
}
