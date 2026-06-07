<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum AssetCategoryEnum: string
{
    use EnumTrait;

    case SECTORIEL = 'sectoriel';
    case CERTIFICATION = 'certification';
    case CONTEXTUEL = 'contextuel';
    case LANGUE_SUPP = 'langue_supp';

    public function label(): string
    {
        return match($this) {
            self::SECTORIEL => 'Expérience sectorielle',
            self::CERTIFICATION => 'Certification',
            self::CONTEXTUEL => 'Compétence contextuelle',
            self::LANGUE_SUPP => 'Langue supplémentaire',
        };
    }
}
