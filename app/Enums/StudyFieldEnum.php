<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum StudyFieldEnum: string
{
    use EnumTrait;  


    case AGRICULTURE = 'Agriculture';
    case AGRONOMY = 'Agronomie';
    case ARCHITECTURE = 'Architecture';
    case ARTS = 'Arts';
    case BIOLOGY = 'Biologie';
    case CHEMISTRY = 'Chimie';
    case COMMUNICATION = 'Communication';
    case ACCOUNTING = 'Comptabilité';
    case LAW = 'Droit';
    case ECONOMICS = 'Économie';
    case EDUCATION = 'Éducation';
    case ELECTRICAL_ENGINEERING = 'Génie électrique';
    case CIVIL_ENGINEERING = 'Génie civil';
    case INDUSTRIAL_ENGINEERING = 'Génie industriel';
    case COMPUTER_ENGINEERING = 'Génie informatique';
    case MECHANICAL_ENGINEERING = 'Génie mécanique';
    case GEOGRAPHY = 'Géographie';
    case HISTORY = 'Histoire';
    case HUMAN_RESOURCES = 'Gestion des ressources humaines';
    case MANAGEMENT = 'Gestion et management';
    case COMPUTER_SCIENCE = 'Informatique';
    case JOURNALISM = 'Journalisme';
    case LANGUAGES = 'Langues et linguistique';
    case MATHEMATICS = 'Mathématiques';
    case MARKETING = 'Marketing';
    case MEDICINE = 'Médecine';
    case NURSING = 'Sciences infirmières';
    case PHARMACY = 'Pharmacie';
    case PHYSICS = 'Physique';
    case POLITICAL_SCIENCE = 'Science politique';
    case PSYCHOLOGY = 'Psychologie';
    case PUBLIC_HEALTH = 'Santé publique';
    case SOCIOLOGY = 'Sociologie';
    case STATISTICS = 'Statistiques';
    case TELECOMMUNICATIONS = 'Télécommunications';
    case THEOLOGY = 'Théologie';
    case TOURISM = 'Tourisme et hôtellerie';
    case TRANSPORT_LOGISTICS = 'Transport et logistique';
    case INTERNATIONAL_RELATIONS = 'Relations internationales';
    case FINANCE = 'Finance';
    case BANKING = 'Banque et assurance';
    case ENVIRONMENT = 'Environnement et développement durable';

    public function label(): string
{
    return $this->value;
}

}