<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum DrivingPermitEnum: string
{
    use EnumTrait;

    case PERMIS_A = 'permis_A';
    case PERMIS_B = 'permis_B';
    case PERMIS_C = 'permis_C';
    case PERMIS_D = 'permis_D';
    case PERMIS_ABCD = 'permis_ABCD';

    public function label(): string
    {
        return match($this) {
            self::PERMIS_A => 'Permis A',
            self::PERMIS_B => 'Permis B',
            self::PERMIS_C => 'Permis C',
            self::PERMIS_D => 'Permis D',
            self::PERMIS_ABCD => 'Permis ABCD',
        };
    }
}
