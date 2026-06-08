<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum SkillCategoryEnum: string
{
    use EnumTrait;

    case DEVELOPPEMENT            = 'developpement';
    case BASE_DE_DONNEES          = 'base_de_donnees';
    case DEVOPS_CLOUD             = 'devops_cloud';
    case IA_DATA_SCIENCE          = 'ia_data_science';
    case COMPTABILITE_FINANCE     = 'comptabilite_finance';
    case RH                       = 'rh';
    case COMMERCE_MARKETING       = 'commerce_marketing';
    case MANAGEMENT_PROJET        = 'management_projet';
    case GENIE_CIVIL_BTP          = 'genie_civil_btp';
    case ELECTRICITE_ENERGIE      = 'electricite_energie';
    case TELECOM_RESEAU           = 'telecom_reseau';
    case LOGISTIQUE_TRANSPORT     = 'logistique_transport';
    case SANTE_MEDICAL            = 'sante_medical';
    case DROIT_JURIDIQUE          = 'droit_juridique';
    case AGRICULTURE_ENVIRONNEMENT= 'agriculture_environnement';
    case ENSEIGNEMENT_FORMATION   = 'enseignement_formation';
    case COMMUNICATION_DESIGN     = 'communication_design';
    case HOTELLERIE_TOURISME      = 'hotellerie_tourisme';
    case SECURITE_QUALITE         = 'securite_qualite';
    case BUREAUTIQUE_TRANSVERSAL  = 'bureautique_transversal';

    public function label(): string
    {
        return match($this) {
            self::DEVELOPPEMENT             => 'Développement logiciel & Web',
            self::BASE_DE_DONNEES           => 'Base de données & Data',
            self::DEVOPS_CLOUD              => 'DevOps, Cloud & Infrastructure',
            self::IA_DATA_SCIENCE           => 'Intelligence artificielle & Data Science',
            self::COMPTABILITE_FINANCE      => 'Comptabilité & Finance',
            self::RH                        => 'Ressources Humaines',
            self::COMMERCE_MARKETING        => 'Commerce, Vente & Marketing',
            self::MANAGEMENT_PROJET         => 'Gestion de projet & Management',
            self::GENIE_CIVIL_BTP           => 'Génie civil & BTP',
            self::ELECTRICITE_ENERGIE       => 'Électricité, Électronique & Énergie',
            self::TELECOM_RESEAU            => 'Télécommunications & Réseaux',
            self::LOGISTIQUE_TRANSPORT      => 'Logistique, Transport & Supply Chain',
            self::SANTE_MEDICAL             => 'Santé & Médical',
            self::DROIT_JURIDIQUE           => 'Droit & Juridique',
            self::AGRICULTURE_ENVIRONNEMENT => 'Agriculture, Agro-alimentaire & Environnement',
            self::ENSEIGNEMENT_FORMATION    => 'Enseignement & Formation',
            self::COMMUNICATION_DESIGN      => 'Communication, Médias & Design',
            self::HOTELLERIE_TOURISME       => 'Hôtellerie, Tourisme & Restauration',
            self::SECURITE_QUALITE          => 'Sécurité, HSE & Qualité',
            self::BUREAUTIQUE_TRANSVERSAL   => 'Bureautique & Compétences transversales',
        };
    }
}
