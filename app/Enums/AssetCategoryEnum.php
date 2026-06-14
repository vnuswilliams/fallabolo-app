<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum AssetCategoryEnum: string
{
    use EnumTrait;

    case SECTORIELLE = 'sectorielle';
    case CERTIFICAT = 'certificat';
    case CONTEXTUELLES = 'context';
    case MOBILITE = 'mobility';
    case PERMIS = 'permis';
    case SOFTSKILLS = 'softskill';
    case LANGUES = 'langue';
    case RESEAU = 'reseau';
    case TECHNQUE = 'technique';
    case AUTRE = 'autres';

    public function label(): string
    {
        return match ($this) {
            self::TECHNQUE => 'Technique & outils',
            self::RESEAU => 'Réseau & influence',
            self::LANGUES => 'Langues',
            self::PERMIS => 'Permis & habilitations',
            self::MOBILITE => 'Mobilité & disponibilité',
            self::CONTEXTUELLES => 'Compétences contextuelles',
            self::SOFTSKILLS => 'Soft skills',
            self::CERTIFICAT => 'Certifications & formations',
            self::SECTORIELLE => 'Expérience sectorielle',
            self::AUTRE => 'Autre'
        };
    }
}
