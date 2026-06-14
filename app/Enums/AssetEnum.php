<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum AssetEnum: string
{
    use EnumTrait;

    // ── Expérience sectorielle ────────────────────────────────
    case SECTORIEL = 'sectoriel';           // Expérience dans le même secteur d'activité
    case STARTUP = 'startup';             // Expérience en startup / environnement agile
    case GRAND_GROUPE = 'grand_groupe';        // Expérience en grande entreprise / groupe international
    case PME = 'pme';                 // Expérience en PME / structure à taille humaine
    case ONG = 'ong';                 // Expérience en ONG / secteur associatif
    case SECTEUR_PUBLIC = 'secteur_public';      // Expérience dans le secteur public / administration

    // ── Certifications & formations ───────────────────────────
    case CERTIFICATION = 'certification';       // Certification professionnelle reconnue
    case DIPLOME_GRANDE_ECOLE = 'diplome_grande_ecole'; // Diplôme grande école / université de renom
    case FORMATION_CONTINUE = 'formation_continue';  // Formation continue récente (< 2 ans)
    case CERTIFICATION_CLOUD = 'certification_cloud'; // Certification cloud (AWS, Azure, GCP)
    case CERTIFICATION_GESTION = 'certification_gestion'; // Certification gestion de projet (PMP, Prince2, Scrum)
    case CERTIFICATION_SECURITE = 'certification_securite'; // Certification sécurité (CISSP, CEH, ISO 27001)
    case CERTIFICATION_COMPTABLE = 'certification_comptable'; // CPA, ACCA, expertise comptable

    // ── Compétences contextuelles ─────────────────────────────
    case CONTEXTUEL = 'contextuel';          // Compétence contextuelle spécifique au poste
    case MANAGEMENT = 'management';          // Expérience en management d'équipe
    case GESTION_PROJET = 'gestion_projet';      // Gestion de projet (méthodologies agiles, Scrum, Kanban)
    case NEGOCIATION = 'negociation';         // Compétences en négociation commerciale
    case RELATION_CLIENT = 'relation_client';     // Expérience relation client / account management
    case CONDUITE_CHANGEMENT = 'conduite_changement'; // Conduite du changement organisationnel
    case AUDIT = 'audit';               // Expérience en audit interne ou externe
    case CONFORMITE = 'conformite';          // Conformité / compliance réglementaire
    case VEILLE_STRATEGIQUE = 'veille_strategique';  // Veille stratégique et intelligence économique

    // ── Mobilité & disponibilité ──────────────────────────────
    case TELETRAVAIL = 'teletravail';         // Expérience confirmée en télétravail
    case MOBILITE_NATIONALE = 'mobilite_nationale';  // Mobilité nationale (prêt à se déplacer)
    case MOBILITE_INTERNATIONALE = 'mobilite_internationale'; // Mobilité internationale
    case EXPATRIATION = 'expatriation';        // Expérience d'expatriation

    // ── Permis & habilitations ────────────────────────────────
    case PERMIS_B = 'permis_b';            // Permis de conduire B
    case PERMIS_POIDS_LOURD = 'permis_poids_lourd';  // Permis poids lourd (C, D, E)
    case HABILITATION_ELECTRIQUE = 'habilitation_electrique'; // Habilitation électrique
    case HABILITATION_SECURITE = 'habilitation_securite';   // Habilitation de sécurité / secret défense

    // ── Soft skills différenciants ────────────────────────────
    case LEADERSHIP = 'leadership';          // Leadership avéré (direction d'équipes)
    case PRESENTATION = 'presentation';        // Aisance à l'oral / prise de parole en public
    case REDACTION = 'redaction';           // Excellentes capacités rédactionnelles
    case PEDAGOGIE = 'pedagogie';           // Capacité à former / transmettre les savoirs
    case CREATIVITE = 'creativite';          // Créativité / innovation
    case RESILIENCE = 'resilience';          // Résilience / gestion du stress en environnement exigeant

    // ── Langues supplémentaires ───────────────────────────────
    case LANGUE_SUPP = 'langue_supp';         // Langue supplémentaire (générique)
    case ANGLAIS = 'anglais';             // Anglais professionnel
    case FRANCAIS = 'francais';            // Français professionnel
    case ESPAGNOL = 'espagnol';            // Espagnol professionnel
    case ARABE = 'arabe';               // Arabe professionnel
    case CHINOIS = 'chinois';             // Chinois mandarin
    case PORTUGAIS = 'portugais';           // Portugais professionnel
    case ALLEMAND = 'allemand';            // Allemand professionnel

    // ── Réseau & influence ────────────────────────────────────
    case RESEAU_SECTORIEL = 'reseau_sectoriel';    // Réseau professionnel établi dans le secteur
    case PORTEFEUILLE_CLIENTS = 'portefeuille_clients'; // Portefeuille clients existant transférable
    case INFLUENCE_DIGITALE = 'influence_digitale';  // Présence / influence digitale (LinkedIn, etc.)

    // ── Technique & outils ────────────────────────────────────
    case MAITRISE_ERP = 'maitrise_erp';        // Maîtrise d'un ERP (SAP, Oracle, Odoo…)
    case MAITRISE_CRM = 'maitrise_crm';        // Maîtrise d'un CRM (Salesforce, HubSpot…)
    case DATA_ANALYSE = 'data_analyse';        // Compétences data / analyse (Power BI, Tableau, SQL)
    case DEVELOPPEMENT = 'developpement';       // Compétences en développement logiciel
    case SECURITE_INFO = 'securite_info';       // Cybersécurité / sécurité informatique
    case DEVOPS = 'devops';              // Pratiques DevOps / CI-CD

    public function label(): string
    {
        return match ($this) {
            // Expérience sectorielle
            self::SECTORIEL => 'Expérience sectorielle',
            self::STARTUP => 'Expérience en startup',
            self::GRAND_GROUPE => 'Expérience en grande entreprise',
            self::PME => 'Expérience en PME',
            self::ONG => 'Expérience en ONG / associatif',
            self::SECTEUR_PUBLIC => 'Expérience secteur public',

            // Certifications
            self::CERTIFICATION => 'Certification professionnelle',
            self::DIPLOME_GRANDE_ECOLE => 'Diplôme grande école / université de renom',
            self::FORMATION_CONTINUE => 'Formation continue récente',
            self::CERTIFICATION_CLOUD => 'Certification cloud (AWS / Azure / GCP)',
            self::CERTIFICATION_GESTION => 'Certification gestion de projet',
            self::CERTIFICATION_SECURITE => 'Certification sécurité informatique',
            self::CERTIFICATION_COMPTABLE => 'Certification comptable (CPA / ACCA)',

            // Compétences contextuelles
            self::CONTEXTUEL => 'Compétence contextuelle',
            self::MANAGEMENT => 'Management d\'équipe',
            self::GESTION_PROJET => 'Gestion de projet',
            self::NEGOCIATION => 'Négociation commerciale',
            self::RELATION_CLIENT => 'Relation client / Account management',
            self::CONDUITE_CHANGEMENT => 'Conduite du changement',
            self::AUDIT => 'Audit interne / externe',
            self::CONFORMITE => 'Conformité / Compliance',
            self::VEILLE_STRATEGIQUE => 'Veille stratégique',

            // Mobilité
            self::TELETRAVAIL => 'Expérience télétravail confirmée',
            self::MOBILITE_NATIONALE => 'Mobilité nationale',
            self::MOBILITE_INTERNATIONALE => 'Mobilité internationale',
            self::EXPATRIATION => 'Expérience d\'expatriation',

            // Permis & habilitations
            self::PERMIS_B => 'Permis de conduire B',
            self::PERMIS_POIDS_LOURD => 'Permis poids lourd',
            self::HABILITATION_ELECTRIQUE => 'Habilitation électrique',
            self::HABILITATION_SECURITE => 'Habilitation de sécurité',

            // Soft skills
            self::LEADERSHIP => 'Leadership',
            self::PRESENTATION => 'Aisance à l\'oral',
            self::REDACTION => 'Capacités rédactionnelles',
            self::PEDAGOGIE => 'Pédagogie / formation',
            self::CREATIVITE => 'Créativité / innovation',
            self::RESILIENCE => 'Résilience / gestion du stress',

            // Langues
            self::LANGUE_SUPP => 'Langue supplémentaire',
            self::ANGLAIS => 'Anglais professionnel',
            self::FRANCAIS => 'Français professionnel',
            self::ESPAGNOL => 'Espagnol professionnel',
            self::ARABE => 'Arabe professionnel',
            self::CHINOIS => 'Chinois mandarin',
            self::PORTUGAIS => 'Portugais professionnel',
            self::ALLEMAND => 'Allemand professionnel',

            // Réseau
            self::RESEAU_SECTORIEL => 'Réseau professionnel sectoriel',
            self::PORTEFEUILLE_CLIENTS => 'Portefeuille clients transférable',
            self::INFLUENCE_DIGITALE => 'Influence digitale',

            // Technique
            self::MAITRISE_ERP => 'Maîtrise ERP (SAP / Oracle / Odoo ou autre)',
            self::MAITRISE_CRM => 'Maîtrise CRM (Salesforce / HubSpot)',
            self::DATA_ANALYSE => 'Data & Analyse (BI / SQL)',
            self::DEVELOPPEMENT => 'Développement logiciel',
            self::SECURITE_INFO => 'Cybersécurité',
            self::DEVOPS => 'DevOps / CI-CD',
        };
    }

    /**
     * Retourne la catégorie de l'atout pour le groupement dans les selects.
     */
    public function category(): AssetCategoryEnum
    {
        return match ($this) {
            self::SECTORIEL, self::STARTUP, self::GRAND_GROUPE,
            self::PME, self::ONG, self::SECTEUR_PUBLIC, => AssetCategoryEnum::SECTORIELLE,

            self::CERTIFICATION, self::DIPLOME_GRANDE_ECOLE, self::FORMATION_CONTINUE,
            self::CERTIFICATION_CLOUD, self::CERTIFICATION_GESTION,
            self::CERTIFICATION_SECURITE, self::CERTIFICATION_COMPTABLE, => AssetCategoryEnum::CERTIFICAT,

            self::CONTEXTUEL, self::MANAGEMENT, self::GESTION_PROJET,
            self::NEGOCIATION, self::RELATION_CLIENT, self::CONDUITE_CHANGEMENT,
            self::AUDIT, self::CONFORMITE, self::VEILLE_STRATEGIQUE, => AssetCategoryEnum::CONTEXTUELLES,

            self::TELETRAVAIL, self::MOBILITE_NATIONALE,
            self::MOBILITE_INTERNATIONALE, self::EXPATRIATION, => AssetCategoryEnum::MOBILITE,

            self::PERMIS_B, self::PERMIS_POIDS_LOURD,
            self::HABILITATION_ELECTRIQUE, self::HABILITATION_SECURITE, => AssetCategoryEnum::PERMIS,

            self::LEADERSHIP, self::PRESENTATION, self::REDACTION,
            self::PEDAGOGIE, self::CREATIVITE, self::RESILIENCE, => AssetCategoryEnum::SOFTSKILLS,

            self::LANGUE_SUPP, self::ANGLAIS, self::FRANCAIS,
            self::ESPAGNOL, self::ARABE, self::CHINOIS,
            self::PORTUGAIS, self::ALLEMAND, => AssetCategoryEnum::LANGUES,

            self::RESEAU_SECTORIEL, self::PORTEFEUILLE_CLIENTS,
            self::INFLUENCE_DIGITALE, => AssetCategoryEnum::RESEAU,

            self::MAITRISE_ERP, self::MAITRISE_CRM, self::DATA_ANALYSE,
            self::DEVELOPPEMENT, self::SECURITE_INFO, self::DEVOPS, => AssetCategoryEnum::TECHNQUE,

            // default => AssetCategoryEnum::AUTRE,
        };
    }

    /**
     * Retourne les cases groupées par catégorie.
     * Utile pour les <optgroup> dans les selects.
     *
     * @return array<string, AssetEnum[]>
     */
    /*public static function grouped(): array
    {
        $groups = [];
        foreach (self::cases() as $case) {
            $groups[$case->category()][] = $case;
        }
        return $groups;
    }*/
}
