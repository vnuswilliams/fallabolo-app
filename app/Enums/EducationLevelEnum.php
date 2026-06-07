<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum EducationLevelEnum: string
{
    use EnumTrait;

    case NONE = 'none';
    case CEPC = 'cepc';
    case BEPC = 'bepc';
    case BAC = 'bac';
    case BTS = 'bts';
    case LICENCE = 'licence';
    case MASTER = 'master';
    case DOCTORAT = 'doctorat';

    public function label(): string
    {
        return match($this) {
            self::NONE => 'Aucun diplôme',
            self::CEPC => 'CEPC',
            self::BEPC => 'BEPC',
            self::BAC => 'BAC',
            self::BTS => 'BTS / DUT',
            self::LICENCE => 'Licence',
            self::MASTER => 'Master',
            self::DOCTORAT => 'Doctorat',
        };
    }

    public function valueWeight(): int
    {
        return match($this) {
            self::NONE => 0,
            self::CEPC => 1,
            self::BEPC => 2,
            self::BAC => 3,
            self::BTS => 4,
            self::LICENCE => 5,
            self::MASTER => 6,
            self::DOCTORAT => 7,
        };
    }
}
