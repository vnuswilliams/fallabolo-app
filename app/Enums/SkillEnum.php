<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum SkillEnum: string
{
    use EnumTrait;

    // ---------------------------------------------------------------
    // DÉVELOPPEMENT LOGICIEL & WEB
    // ---------------------------------------------------------------
    case PHP                    = 'php';
    case LARAVEL                = 'laravel';
    case SYMFONY                = 'symfony';
    case PYTHON                 = 'python';
    case DJANGO                 = 'django';
    case FASTAPI                = 'fastapi';
    case JAVASCRIPT             = 'javascript';
    case TYPESCRIPT             = 'typescript';
    case NODEJS                 = 'nodejs';
    case EXPRESSJS              = 'expressjs';
    case REACTJS                = 'reactjs';
    case VUEJS                  = 'vuejs';
    case ANGULAR                = 'angular';
    case NEXTJS                 = 'nextjs';
    case NUXTJS                 = 'nuxtjs';
    case LIVEWIRE               = 'livewire';
    case ALPINEJS               = 'alpinejs';
    case JAVA                   = 'java';
    case SPRING_BOOT            = 'spring_boot';
    case KOTLIN                 = 'kotlin';
    case SWIFT                  = 'swift';
    case FLUTTER                = 'flutter';
    case REACT_NATIVE           = 'react_native';
    case CSHARP                 = 'csharp';
    case DOTNET                 = 'dotnet';
    case CPP                    = 'cpp';
    case RUBY_ON_RAILS          = 'ruby_on_rails';
    case GO                     = 'go';
    case RUST                   = 'rust';
    case WORDPRESS              = 'wordpress';
    case SHOPIFY                = 'shopify';
    case HTML_CSS               = 'html_css';
    case TAILWIND_CSS           = 'tailwind_css';
    case BOOTSTRAP              = 'bootstrap';
    case GRAPHQL                = 'graphql';
    case REST_API               = 'rest_api';
    case WEBSOCKETS             = 'websockets';
    case MICROSERVICES          = 'microservices';

    // ---------------------------------------------------------------
    // BASE DE DONNÉES & DATA
    // ---------------------------------------------------------------
    case MYSQL                  = 'mysql';
    case POSTGRESQL             = 'postgresql';
    case SQLITE                 = 'sqlite';
    case MSSQL                  = 'mssql';
    case ORACLE_DB              = 'oracle_db';
    case MONGODB                = 'mongodb';
    case REDIS                  = 'redis';
    case FIREBASE               = 'firebase';
    case ELASTICSEARCH          = 'elasticsearch';
    case CASSANDRA              = 'cassandra';
    case POWER_BI               = 'power_bi';
    case TABLEAU                = 'tableau';
    case LOOKER_STUDIO          = 'looker_studio';
    case PANDAS                 = 'pandas';
    case SQL_AVANCE             = 'sql_avance';
    case ETL_DATA_PIPELINE      = 'etl_data_pipeline';
    case DATA_WAREHOUSE         = 'data_warehouse';
    case APACHE_SPARK           = 'apache_spark';
    case HADOOP                 = 'hadoop';

    // ---------------------------------------------------------------
    // DEVOPS, CLOUD & INFRASTRUCTURE
    // ---------------------------------------------------------------
    case GIT                    = 'git';
    case GITLAB_CICD            = 'gitlab_cicd';
    case DOCKER                 = 'docker';
    case KUBERNETES             = 'kubernetes';
    case AWS                    = 'aws';
    case GCP                    = 'gcp';
    case AZURE                  = 'azure';
    case TERRAFORM              = 'terraform';
    case ANSIBLE                = 'ansible';
    case LINUX                  = 'linux';
    case NGINX_APACHE           = 'nginx_apache';
    case JENKINS                = 'jenkins';
    case GITHUB_ACTIONS         = 'github_actions';
    case MONITORING             = 'monitoring';
    case SECURITE_RESEAU        = 'securite_reseau';

    // ---------------------------------------------------------------
    // INTELLIGENCE ARTIFICIELLE & DATA SCIENCE
    // ---------------------------------------------------------------
    case MACHINE_LEARNING       = 'machine_learning';
    case DEEP_LEARNING          = 'deep_learning';
    case TENSORFLOW             = 'tensorflow';
    case PYTORCH                = 'pytorch';
    case SCIKIT_LEARN           = 'scikit_learn';
    case NLP                    = 'nlp';
    case COMPUTER_VISION        = 'computer_vision';
    case DATA_ANALYSIS          = 'data_analysis';
    case STATISTIQUES           = 'statistiques';
    case R_LANGUAGE             = 'r_language';
    case PROMPT_ENGINEERING     = 'prompt_engineering';
    case RAG_LLM                = 'rag_llm';

    // ---------------------------------------------------------------
    // COMPTABILITÉ & FINANCE
    // ---------------------------------------------------------------
    case COMPTABILITE_GENERALE  = 'comptabilite_generale';
    case COMPTABILITE_ANALYTIQUE= 'comptabilite_analytique';
    case COMPTABILITE_SOCIETES  = 'comptabilite_societes';
    case PLAN_OHADA             = 'plan_ohada';
    case TRESORERIE             = 'tresorerie';
    case RAPPROCHEMENT_BANCAIRE = 'rapprochement_bancaire';
    case DECLARATIONS_FISCALES  = 'declarations_fiscales';
    case TVA                    = 'tva';
    case LIASSES_FISCALES       = 'liasses_fiscales';
    case AUDIT_INTERNE          = 'audit_interne';
    case AUDIT_EXTERNE          = 'audit_externe';
    case CONTROLE_GESTION       = 'controle_gestion';
    case BUDGET_PREVISIONNEL    = 'budget_previsionnel';
    case ANALYSE_FINANCIERE     = 'analyse_financiere';
    case CONSOLIDATION_COMPTES  = 'consolidation_comptes';
    case IFRS_SYSCOHADA         = 'ifrs_syscohada';
    case SAGE_COMPTABILITE      = 'sage_comptabilite';
    case SAGE_PAIE              = 'sage_paie';
    case SAP_FICO               = 'sap_fico';
    case CEGID                  = 'cegid';
    case QUICKBOOKS             = 'quickbooks';
    case GESTION_IMMOBILISATIONS= 'gestion_immobilisations';
    case REPORTING_FINANCIER    = 'reporting_financier';
    case GESTION_STOCKS_COMPTA  = 'gestion_stocks_compta';
    case FINANCE_ISLAMIQUE      = 'finance_islamique';
    case MODELISATION_FINANCIERE= 'modelisation_financiere';
    case PRIVATE_EQUITY         = 'private_equity';
    case MICROFINANCE           = 'microfinance';

    // ---------------------------------------------------------------
    // RESSOURCES HUMAINES
    // ---------------------------------------------------------------
    case RECRUTEMENT            = 'recrutement';
    case GESTION_PAIE           = 'gestion_paie';
    case ADMIN_PERSONNEL        = 'admin_personnel';
    case DROIT_TRAVAIL          = 'droit_travail';
    case CNPS                   = 'cnps';
    case FORMATION_DEV          = 'formation_dev';
    case EVALUATION_PERFORMANCES= 'evaluation_performances';
    case GPEC                   = 'gpec';
    case GESTION_CONFLITS       = 'gestion_conflits';
    case RELATIONS_SOCIALES     = 'relations_sociales';
    case POLITIQUE_REMUNERATION = 'politique_remuneration';
    case ONBOARDING             = 'onboarding';
    case MARQUE_EMPLOYEUR       = 'marque_employeur';
    case SIRH                   = 'sirh';
    case PSYCHOLOGIE_TRAVAIL    = 'psychologie_travail';
    case RSE                    = 'rse';

    // ---------------------------------------------------------------
    // COMMERCE, VENTE & MARKETING
    // ---------------------------------------------------------------
    case PROSPECTION            = 'prospection';
    case NEGOCIATION            = 'negociation';
    case CRM                    = 'crm';
    case GESTION_PORTEFEUILLE   = 'gestion_portefeuille';
    case MARKETING_DIGITAL      = 'marketing_digital';
    case SEO_SEA                = 'seo_sea';
    case COMMUNITY_MANAGEMENT   = 'community_management';
    case EMAIL_MARKETING        = 'email_marketing';
    case FACEBOOK_ADS           = 'facebook_ads';
    case GOOGLE_ADS             = 'google_ads';
    case CONTENT_MARKETING      = 'content_marketing';
    case GROWTH_HACKING         = 'growth_hacking';
    case ECOMMERCE              = 'ecommerce';
    case STRATEGIE_B2B          = 'strategie_b2b';
    case GESTION_GRANDS_COMPTES = 'gestion_grands_comptes';
    case MERCHANDISING          = 'merchandising';
    case ANIMATION_RESEAU_VENTE = 'animation_reseau_vente';
    case APPELS_OFFRES          = 'appels_offres';
    case TRADE_MARKETING        = 'trade_marketing';
    case MARKET_RESEARCH        = 'market_research';

    // ---------------------------------------------------------------
    // GESTION DE PROJET & MANAGEMENT
    // ---------------------------------------------------------------
    case GESTION_PROJET_PMP     = 'gestion_projet_pmp';
    case AGILE_SCRUM            = 'agile_scrum';
    case KANBAN                 = 'kanban';
    case PRINCE2                = 'prince2';
    case MS_PROJECT             = 'ms_project';
    case JIRA                   = 'jira';
    case TRELLO_ASANA_NOTION    = 'trello_asana_notion';
    case MANAGEMENT_EQUIPE      = 'management_equipe';
    case LEADERSHIP             = 'leadership';
    case GESTION_CHANGEMENT     = 'gestion_changement';
    case CONDUITE_CHANGEMENT    = 'conduite_changement';
    case PLANIFICATION_STRAT    = 'planification_strat';
    case GESTION_RISQUES        = 'gestion_risques';
    case REPORTING_PROJET       = 'reporting_projet';
    case ANIMATION_REUNIONS     = 'animation_reunions';
    case COACHING_EQUIPE        = 'coaching_equipe';
    case OKR                    = 'okr';

    // ---------------------------------------------------------------
    // GÉNIE CIVIL & BTP
    // ---------------------------------------------------------------
    case TOPOGRAPHIE            = 'topographie';
    case DESSIN_TECHNIQUE       = 'dessin_technique';
    case AUTOCAD                = 'autocad';
    case REVIT_BIM              = 'revit_bim';
    case ARCHICAD               = 'archicad';
    case BETON_ARME             = 'beton_arme';
    case CHARPENTE_METALLIQUE   = 'charpente_metallique';
    case GEOTECHNIQUE           = 'geotechnique';
    case VRD                    = 'vrd';
    case SUIVI_CHANTIER         = 'suivi_chantier';
    case METRES_DEVIS           = 'metres_devis';
    case GESTION_CHANTIER       = 'gestion_chantier';
    case ETUDE_SOL              = 'etude_sol';
    case HYDRAULIQUE            = 'hydraulique';
    case ASSAINISSEMENT         = 'assainissement';
    case THERMIQUE_BATIMENT     = 'thermique_batiment';
    case ARCHITECTURE_INTERIEUR = 'architecture_interieur';
    case MACONNERIE             = 'maconnerie';
    case PLOMBERIE              = 'plomberie';
    case ELECTRICITE_BATIMENT   = 'electricite_batiment';
    case HSE_BTP                = 'hse_btp';

    // ---------------------------------------------------------------
    // ÉLECTRICITÉ, ÉLECTRONIQUE & ÉNERGIE
    // ---------------------------------------------------------------
    case ELECTROTECHNIQUE       = 'electrotechnique';
    case AUTOMATISME            = 'automatisme';
    case API_PLC                = 'api_plc';
    case INSTRUMENTATION        = 'instrumentation';
    case SOLAIRE_PV             = 'solaire_pv';
    case MAINTENANCE_ELECTRIQUE = 'maintenance_electrique';
    case HAUTE_TENSION          = 'haute_tension';
    case GROUPE_ELECTROGENE     = 'groupe_electrogene';
    case EFFICACITE_ENERGETIQUE = 'efficacite_energetique';
    case ELECTRONIQUE_PUISSANCE = 'electronique_puissance';
    case EOLIEN                 = 'eolien';
    case RESEAUX_ELECTRIQUES    = 'reseaux_electriques';
    case CABLAGE_INDUSTRIEL     = 'cablage_industriel';
    case SCADA                  = 'scada';

    // ---------------------------------------------------------------
    // TÉLÉCOMMUNICATIONS & RÉSEAUX INFORMATIQUES
    // ---------------------------------------------------------------
    case ADMIN_RESEAU           = 'admin_reseau';
    case CISCO                  = 'cisco';
    case FIREWALL_VPN           = 'firewall_vpn';
    case CYBERSECURITE          = 'cybersecurite';
    case RESEAUX_MOBILES        = 'reseaux_mobiles';
    case FIBRE_OPTIQUE          = 'fibre_optique';
    case VOIP                   = 'voip';
    case ACTIVE_DIRECTORY       = 'active_directory';
    case WINDOWS_SERVER         = 'windows_server';
    case HELPDESK               = 'helpdesk';
    case VLAN_SWITCHING         = 'vlan_switching';
    case SOC                    = 'soc';
    case PENTEST                = 'pentest';
    case WIFI_ENTERPRISE        = 'wifi_enterprise';
    case M365_ADMIN             = 'm365_admin';

    // ---------------------------------------------------------------
    // LOGISTIQUE, TRANSPORT & SUPPLY CHAIN
    // ---------------------------------------------------------------
    case GESTION_STOCKS         = 'gestion_stocks';
    case GESTION_ENTREPOT       = 'gestion_entrepot';
    case SUPPLY_CHAIN           = 'supply_chain';
    case IMPORT_EXPORT          = 'import_export';
    case DEDOUANEMENT           = 'dedouanement';
    case INCOTERMS              = 'incoterms';
    case TRANSPORT_ROUTIER      = 'transport_routier';
    case TRANSPORT_MARITIME     = 'transport_maritime';
    case FRET_AERIEN            = 'fret_aerien';
    case GESTION_FLOTTE         = 'gestion_flotte';
    case PLANIFICATION_LOGISTIQUE = 'planification_logistique';
    case WMS                    = 'wms';
    case LEAN_SUPPLY_CHAIN      = 'lean_supply_chain';
    case ACHATS_APPROVISIONNEMENT = 'achats_approvisionnement';
    case GESTION_FOURNISSEURS   = 'gestion_fournisseurs';
    case PROCUREMENT            = 'procurement';
    case COLD_CHAIN             = 'cold_chain';

    // ---------------------------------------------------------------
    // SANTÉ & MÉDICAL
    // ---------------------------------------------------------------
    case SOINS_INFIRMIERS       = 'soins_infirmiers';
    case MEDECINE_GENERALE      = 'medecine_generale';
    case PHARMACOLOGIE          = 'pharmacologie';
    case BIOLOGIE_MEDICALE      = 'biologie_medicale';
    case RADIOLOGIE             = 'radiologie';
    case SAGE_FEMME             = 'sage_femme';
    case KINESITHERAPIE         = 'kinesitherapie';
    case NUTRITION              = 'nutrition';
    case SANTE_PUBLIQUE         = 'sante_publique';
    case EPIDEMIOLOGIE          = 'epidemiologie';
    case GESTION_HOSPITALIERE   = 'gestion_hospitaliere';
    case PHARMACIE              = 'pharmacie';
    case MEDECINE_TRAVAIL       = 'medecine_travail';
    case DENTISTERIE            = 'dentisterie';
    case PSYCHOLOGIE_CLINIQUE   = 'psychologie_clinique';
    case URGENCES_MEDICALES     = 'urgences_medicales';

    // ---------------------------------------------------------------
    // DROIT & JURIDIQUE
    // ---------------------------------------------------------------
    case DROIT_AFFAIRES_OHADA   = 'droit_affaires_ohada';
    case DROIT_TRAVAIL_JUR      = 'droit_travail_jur';
    case DROIT_FISCAL           = 'droit_fiscal';
    case DROIT_COMMERCIAL       = 'droit_commercial';
    case DROIT_CONTRATS         = 'droit_contrats';
    case CONTENTIEUX            = 'contentieux';
    case PROPRIETE_INTELLECTUELLE = 'propriete_intellectuelle';
    case COMPLIANCE             = 'compliance';
    case RGPD                   = 'rgpd';
    case ARBITRAGE              = 'arbitrage';
    case DROIT_BANCAIRE         = 'droit_bancaire';
    case SECRETARIAT_JURIDIQUE  = 'secretariat_juridique';
    case REDACTION_ACTES        = 'redaction_actes';
    case DROIT_PUBLIC           = 'droit_public';

    // ---------------------------------------------------------------
    // AGRICULTURE, AGRO-ALIMENTAIRE & ENVIRONNEMENT
    // ---------------------------------------------------------------
    case AGRONOMIE              = 'agronomie';
    case CULTURE_CACAOYERE      = 'culture_cacaoyere';
    case ELEVAGE                = 'elevage';
    case PISCICULTURE           = 'pisciculture';
    case AGRICULTURE_PRECISION  = 'agriculture_precision';
    case AGROFORESTERIE         = 'agroforesterie';
    case IRRIGATION             = 'irrigation';
    case HACCP                  = 'haccp';
    case INDUSTRIE_AGROALIM     = 'industrie_agroalim';
    case GESTION_FORESTIERE     = 'gestion_forestiere';
    case ETUDE_IMPACT_ENVIRO    = 'etude_impact_enviro';
    case TRAITEMENT_EAUX        = 'traitement_eaux';
    case GESTION_DECHETS        = 'gestion_dechets';
    case ISO_14001              = 'iso_14001';

    // ---------------------------------------------------------------
    // ENSEIGNEMENT & FORMATION
    // ---------------------------------------------------------------
    case PEDAGOGIE              = 'pedagogie';
    case INGENIERIE_FORMATION   = 'ingenierie_formation';
    case ELEARNING              = 'elearning';
    case TUTORAT_COACHING       = 'tutorat_coaching';
    case CONCEPTION_CURRICULA   = 'conception_curricula';
    case EVALUATION_PEDAGOGIQUE = 'evaluation_pedagogique';
    case FORMATION_PRO          = 'formation_pro';
    case ENSEIGNEMENT_PRIMAIRE  = 'enseignement_primaire';
    case ENSEIGNEMENT_SECONDAIRE= 'enseignement_secondaire';
    case ENSEIGNEMENT_SUPERIEUR = 'enseignement_superieur';
    case EDUCATION_SPECIALISEE  = 'education_specialisee';
    case FOAD                   = 'foad';

    // ---------------------------------------------------------------
    // COMMUNICATION, MÉDIAS & DESIGN
    // ---------------------------------------------------------------
    case GRAPHISME              = 'graphisme';
    case PHOTOSHOP              = 'photoshop';
    case ILLUSTRATOR            = 'illustrator';
    case INDESIGN               = 'indesign';
    case CANVA                  = 'canva';
    case FIGMA                  = 'figma';
    case UI_UX                  = 'ui_ux';
    case MOTION_DESIGN          = 'motion_design';
    case MONTAGE_VIDEO          = 'montage_video';
    case PHOTOGRAPHIE           = 'photographie';
    case JOURNALISME            = 'journalisme';
    case REDACTION_WEB          = 'redaction_web';
    case RELATIONS_PRESSE       = 'relations_presse';
    case COMMUNICATION_INSTIT   = 'communication_instit';
    case RELATIONS_PUBLIQUES    = 'relations_publiques';
    case EVENEMENTIEL           = 'evenementiel';
    case PRODUCTION_AUDIO       = 'production_audio';
    case BRAND_DESIGN           = 'brand_design';

    // ---------------------------------------------------------------
    // HÔTELLERIE, TOURISME & RESTAURATION
    // ---------------------------------------------------------------
    case GESTION_HOTELIERE      = 'gestion_hoteliere';
    case FRONT_OFFICE           = 'front_office';
    case CUISINE                = 'cuisine';
    case PATISSERIE             = 'patisserie';
    case SERVICE_EN_SALLE       = 'service_en_salle';
    case HOUSEKEEPING           = 'housekeeping';
    case GESTION_TOURISTIQUE    = 'gestion_touristique';
    case AGENCE_VOYAGE          = 'agence_voyage';
    case REVENUE_MANAGEMENT     = 'revenue_management';
    case FB_MANAGEMENT          = 'fb_management';
    case HYGIENE_ALIMENTAIRE    = 'hygiene_alimentaire';
    case TOURISME_ECO           = 'tourisme_eco';

    // ---------------------------------------------------------------
    // SÉCURITÉ, HSE & QUALITÉ
    // ---------------------------------------------------------------
    case HSE                    = 'hse';
    case ISO_9001               = 'iso_9001';
    case ISO_45001              = 'iso_45001';
    case AUDIT_QUALITE          = 'audit_qualite';
    case CONTROLE_QUALITE       = 'controle_qualite';
    case PREVENTION_RISQUES     = 'prevention_risques';
    case QHSE                   = 'qhse';
    case DUER                   = 'duer';
    case SECURITE_INCENDIE      = 'securite_incendie';
    case PREMIERS_SECOURS       = 'premiers_secours';
    case LEAN_MANAGEMENT        = 'lean_management';
    case SIX_SIGMA              = 'six_sigma';
    case KAIZEN                 = 'kaizen';
    case METROLOGIE             = 'metrologie';

    // ---------------------------------------------------------------
    // BUREAUTIQUE & COMPÉTENCES TRANSVERSALES
    // ---------------------------------------------------------------
    case EXCEL                  = 'excel';
    case EXCEL_AVANCE           = 'excel_avance';
    case WORD                   = 'word';
    case POWERPOINT             = 'powerpoint';
    case OUTLOOK                = 'outlook';
    case GOOGLE_WORKSPACE       = 'google_workspace';
    case SAISIE_DONNEES         = 'saisie_donnees';
    case SECRETARIAT_DIRECTION  = 'secretariat_direction';
    case PRISE_DE_NOTES         = 'prise_de_notes';
    case GESTION_DOCUMENTAIRE   = 'gestion_documentaire';
    case ACCUEIL_STANDARD       = 'accueil_standard';
    case ARCHIVAGE              = 'archivage';
    case SAP_ERP                = 'sap_erp';
    case ODOO                   = 'odoo';
    case REDACTION_ADMINISTRATIVE = 'redaction_administrative';
    case GESTION_AGENDA         = 'gestion_agenda';
    case ORGANISATION_EVENEMENTS= 'organisation_evenements';
    case VEILLE_STRATEGIQUE     = 'veille_strategique';
    case REPORTING              = 'reporting';
    case TRADUCTION_FR_EN       = 'traduction_fr_en';
    case INTERPRETARIAT         = 'interpretariat';

    // ---------------------------------------------------------------
    // LABELS
    // ---------------------------------------------------------------
    public function label(): string
    {
        return match($this) {
            // Développement
            self::PHP                     => 'PHP',
            self::LARAVEL                 => 'Laravel',
            self::SYMFONY                 => 'Symfony',
            self::PYTHON                  => 'Python',
            self::DJANGO                  => 'Django',
            self::FASTAPI                 => 'FastAPI',
            self::JAVASCRIPT              => 'JavaScript',
            self::TYPESCRIPT              => 'TypeScript',
            self::NODEJS                  => 'Node.js',
            self::EXPRESSJS               => 'Express.js',
            self::REACTJS                 => 'React.js',
            self::VUEJS                   => 'Vue.js',
            self::ANGULAR                 => 'Angular',
            self::NEXTJS                  => 'Next.js',
            self::NUXTJS                  => 'Nuxt.js',
            self::LIVEWIRE                => 'Livewire',
            self::ALPINEJS                => 'Alpine.js',
            self::JAVA                    => 'Java',
            self::SPRING_BOOT             => 'Spring Boot',
            self::KOTLIN                  => 'Kotlin',
            self::SWIFT                   => 'Swift',
            self::FLUTTER                 => 'Flutter',
            self::REACT_NATIVE            => 'React Native',
            self::CSHARP                  => 'C#',
            self::DOTNET                  => '.NET / ASP.NET',
            self::CPP                     => 'C++',
            self::RUBY_ON_RAILS           => 'Ruby on Rails',
            self::GO                      => 'Go (Golang)',
            self::RUST                    => 'Rust',
            self::WORDPRESS               => 'WordPress',
            self::SHOPIFY                 => 'Shopify',
            self::HTML_CSS                => 'HTML / CSS',
            self::TAILWIND_CSS            => 'Tailwind CSS',
            self::BOOTSTRAP               => 'Bootstrap',
            self::GRAPHQL                 => 'GraphQL',
            self::REST_API                => 'REST API',
            self::WEBSOCKETS              => 'WebSockets',
            self::MICROSERVICES           => 'Microservices',
            // Base de données
            self::MYSQL                   => 'MySQL',
            self::POSTGRESQL              => 'PostgreSQL',
            self::SQLITE                  => 'SQLite',
            self::MSSQL                   => 'Microsoft SQL Server',
            self::ORACLE_DB               => 'Oracle Database',
            self::MONGODB                 => 'MongoDB',
            self::REDIS                   => 'Redis',
            self::FIREBASE                => 'Firebase Firestore',
            self::ELASTICSEARCH           => 'Elasticsearch',
            self::CASSANDRA               => 'Cassandra',
            self::POWER_BI                => 'Power BI',
            self::TABLEAU                 => 'Tableau',
            self::LOOKER_STUDIO           => 'Google Looker Studio',
            self::PANDAS                  => 'Pandas (Python)',
            self::SQL_AVANCE              => 'SQL avancé',
            self::ETL_DATA_PIPELINE       => 'ETL / Data Pipeline',
            self::DATA_WAREHOUSE          => 'Data Warehouse',
            self::APACHE_SPARK            => 'Apache Spark',
            self::HADOOP                  => 'Hadoop',
            // DevOps
            self::GIT                     => 'Git / GitHub',
            self::GITLAB_CICD             => 'GitLab CI/CD',
            self::DOCKER                  => 'Docker',
            self::KUBERNETES              => 'Kubernetes',
            self::AWS                     => 'AWS (Amazon Web Services)',
            self::GCP                     => 'Google Cloud Platform',
            self::AZURE                   => 'Microsoft Azure',
            self::TERRAFORM               => 'Terraform',
            self::ANSIBLE                 => 'Ansible',
            self::LINUX                   => 'Linux / Ubuntu Server',
            self::NGINX_APACHE            => 'Nginx / Apache',
            self::JENKINS                 => 'Jenkins',
            self::GITHUB_ACTIONS          => 'GitHub Actions',
            self::MONITORING              => 'Monitoring (Grafana, Prometheus)',
            self::SECURITE_RESEAU         => 'Sécurité réseau',
            // IA
            self::MACHINE_LEARNING        => 'Machine Learning',
            self::DEEP_LEARNING           => 'Deep Learning',
            self::TENSORFLOW              => 'TensorFlow',
            self::PYTORCH                 => 'PyTorch',
            self::SCIKIT_LEARN            => 'Scikit-learn',
            self::NLP                     => 'NLP (Traitement du langage)',
            self::COMPUTER_VISION         => 'Computer Vision',
            self::DATA_ANALYSIS           => 'Data Analysis',
            self::STATISTIQUES            => 'Statistiques appliquées',
            self::R_LANGUAGE              => 'R (langage statistique)',
            self::PROMPT_ENGINEERING      => 'Prompt Engineering',
            self::RAG_LLM                 => 'RAG / LLM Integration',
            // Comptabilité
            self::COMPTABILITE_GENERALE   => 'Comptabilité générale',
            self::COMPTABILITE_ANALYTIQUE => 'Comptabilité analytique',
            self::COMPTABILITE_SOCIETES   => 'Comptabilité des sociétés',
            self::PLAN_OHADA              => 'Plan OHADA',
            self::TRESORERIE              => 'Trésorerie',
            self::RAPPROCHEMENT_BANCAIRE  => 'Rapprochement bancaire',
            self::DECLARATIONS_FISCALES   => 'Déclarations fiscales (DGI)',
            self::TVA                     => 'TVA',
            self::LIASSES_FISCALES        => 'Liasses fiscales',
            self::AUDIT_INTERNE           => 'Audit interne',
            self::AUDIT_EXTERNE           => 'Audit externe',
            self::CONTROLE_GESTION        => 'Contrôle de gestion',
            self::BUDGET_PREVISIONNEL     => 'Budget prévisionnel',
            self::ANALYSE_FINANCIERE      => 'Analyse financière',
            self::CONSOLIDATION_COMPTES   => 'Consolidation des comptes',
            self::IFRS_SYSCOHADA          => 'IFRS / SYSCOHADA',
            self::SAGE_COMPTABILITE       => 'Sage Comptabilité',
            self::SAGE_PAIE               => 'Sage Paie',
            self::SAP_FICO                => 'SAP FI/CO',
            self::CEGID                   => 'Cegid',
            self::QUICKBOOKS              => 'QuickBooks',
            self::GESTION_IMMOBILISATIONS => 'Gestion des immobilisations',
            self::REPORTING_FINANCIER     => 'Reporting financier',
            self::GESTION_STOCKS_COMPTA   => 'Gestion des stocks comptable',
            self::FINANCE_ISLAMIQUE       => 'Finance islamique',
            self::MODELISATION_FINANCIERE => 'Modélisation financière',
            self::PRIVATE_EQUITY          => 'Private Equity',
            self::MICROFINANCE            => 'Microfinance',
            // RH
            self::RECRUTEMENT             => 'Recrutement',
            self::GESTION_PAIE            => 'Gestion de la paie',
            self::ADMIN_PERSONNEL         => 'Administration du personnel',
            self::DROIT_TRAVAIL           => 'Droit du travail camerounais',
            self::CNPS                    => 'CNPS (cotisations sociales)',
            self::FORMATION_DEV           => 'Formation et développement',
            self::EVALUATION_PERFORMANCES => 'Évaluation des performances',
            self::GPEC                    => 'GPEC / GPEEC',
            self::GESTION_CONFLITS        => 'Gestion des conflits',
            self::RELATIONS_SOCIALES      => 'Relations sociales',
            self::POLITIQUE_REMUNERATION  => 'Politique de rémunération',
            self::ONBOARDING              => 'Onboarding',
            self::MARQUE_EMPLOYEUR        => 'Marque employeur',
            self::SIRH                    => 'SIRH (Système info RH)',
            self::PSYCHOLOGIE_TRAVAIL     => 'Psychologie du travail',
            self::RSE                     => 'Responsabilité Sociale (RSE)',
            // Commerce
            self::PROSPECTION             => 'Prospection commerciale',
            self::NEGOCIATION             => 'Négociation commerciale',
            self::CRM                     => 'CRM (Salesforce, HubSpot)',
            self::GESTION_PORTEFEUILLE    => "Gestion d'un portefeuille client",
            self::MARKETING_DIGITAL       => 'Marketing digital',
            self::SEO_SEA                 => 'SEO / SEA',
            self::COMMUNITY_MANAGEMENT    => 'Community Management',
            self::EMAIL_MARKETING         => 'Email Marketing',
            self::FACEBOOK_ADS            => 'Publicité Meta / Facebook Ads',
            self::GOOGLE_ADS              => 'Google Ads',
            self::CONTENT_MARKETING       => 'Content Marketing',
            self::GROWTH_HACKING          => 'Growth Hacking',
            self::ECOMMERCE               => 'E-commerce',
            self::STRATEGIE_B2B           => 'Stratégie commerciale B2B',
            self::GESTION_GRANDS_COMPTES  => 'Gestion grands comptes',
            self::MERCHANDISING           => 'Merchandising',
            self::ANIMATION_RESEAU_VENTE  => 'Animation réseau de vente',
            self::APPELS_OFFRES           => "Appels d'offres",
            self::TRADE_MARKETING         => 'Trade Marketing',
            self::MARKET_RESEARCH         => 'Market Research',
            // Management
            self::GESTION_PROJET_PMP      => 'Gestion de projet (PMI/PMP)',
            self::AGILE_SCRUM             => 'Méthode Agile / Scrum',
            self::KANBAN                  => 'Méthode Kanban',
            self::PRINCE2                 => 'PRINCE2',
            self::MS_PROJECT              => 'Microsoft Project',
            self::JIRA                    => 'Jira',
            self::TRELLO_ASANA_NOTION     => 'Trello / Asana / Notion',
            self::MANAGEMENT_EQUIPE       => "Management d'équipe",
            self::LEADERSHIP              => 'Leadership',
            self::GESTION_CHANGEMENT      => 'Gestion du changement',
            self::CONDUITE_CHANGEMENT     => 'Conduite du changement',
            self::PLANIFICATION_STRAT     => 'Planification stratégique',
            self::GESTION_RISQUES         => 'Gestion des risques',
            self::REPORTING_PROJET        => 'Reporting de projet',
            self::ANIMATION_REUNIONS      => 'Animation de réunions',
            self::COACHING_EQUIPE         => "Coaching d'équipe",
            self::OKR                     => 'OKR (Objectives & Key Results)',
            // BTP
            self::TOPOGRAPHIE             => 'Topographie',
            self::DESSIN_TECHNIQUE        => 'Dessin technique / DAO',
            self::AUTOCAD                 => 'AutoCAD',
            self::REVIT_BIM               => 'Revit (BIM)',
            self::ARCHICAD                => 'ArchiCAD',
            self::BETON_ARME              => 'Béton armé',
            self::CHARPENTE_METALLIQUE    => 'Charpente métallique',
            self::GEOTECHNIQUE            => 'Géotechnique',
            self::VRD                     => 'Voirie et réseaux divers (VRD)',
            self::SUIVI_CHANTIER          => 'Suivi de chantier',
            self::METRES_DEVIS            => 'Métrés et devis',
            self::GESTION_CHANTIER        => 'Gestion de chantier',
            self::ETUDE_SOL               => 'Étude de sol',
            self::HYDRAULIQUE             => 'Hydraulique',
            self::ASSAINISSEMENT          => 'Assainissement',
            self::THERMIQUE_BATIMENT      => 'Thermique du bâtiment',
            self::ARCHITECTURE_INTERIEUR  => "Architecture d'intérieur",
            self::MACONNERIE              => 'Maçonnerie',
            self::PLOMBERIE               => 'Plomberie',
            self::ELECTRICITE_BATIMENT    => 'Électricité bâtiment',
            self::HSE_BTP                 => 'Sécurité chantier (HSE BTP)',
            // Électricité
            self::ELECTROTECHNIQUE        => 'Électrotechnique',
            self::AUTOMATISME             => 'Automatisme industriel',
            self::API_PLC                 => 'API / PLC (Siemens, Schneider)',
            self::INSTRUMENTATION         => 'Instrumentation',
            self::SOLAIRE_PV              => 'Énergie solaire photovoltaïque',
            self::MAINTENANCE_ELECTRIQUE  => 'Maintenance électrique',
            self::HAUTE_TENSION           => 'Haute tension (HTA/HTB)',
            self::GROUPE_ELECTROGENE      => 'Groupe électrogène',
            self::EFFICACITE_ENERGETIQUE  => 'Efficacité énergétique',
            self::ELECTRONIQUE_PUISSANCE  => 'Électronique de puissance',
            self::EOLIEN                  => 'Éolien',
            self::RESEAUX_ELECTRIQUES     => 'Réseaux électriques',
            self::CABLAGE_INDUSTRIEL      => 'Câblage industriel',
            self::SCADA                   => 'SCADA / Supervision',
            // Télécom
            self::ADMIN_RESEAU            => 'Administration réseau',
            self::CISCO                   => 'Cisco (CCNA / CCNP)',
            self::FIREWALL_VPN            => 'Firewall / VPN',
            self::CYBERSECURITE           => 'Cybersécurité',
            self::RESEAUX_MOBILES         => 'Réseaux mobiles (2G/3G/4G/5G)',
            self::FIBRE_OPTIQUE           => 'Fibre optique',
            self::VOIP                    => 'IP Téléphonie / VoIP',
            self::ACTIVE_DIRECTORY        => 'Active Directory',
            self::WINDOWS_SERVER          => 'Windows Server',
            self::HELPDESK                => 'Helpdesk / Support N1-N2-N3',
            self::VLAN_SWITCHING          => 'VLAN / Switching',
            self::SOC                     => 'Sécurité informatique (SOC)',
            self::PENTEST                 => 'Penetration Testing',
            self::WIFI_ENTERPRISE         => 'WiFi Enterprise',
            self::M365_ADMIN              => 'Microsoft 365 Admin',
            // Logistique
            self::GESTION_STOCKS          => 'Gestion des stocks',
            self::GESTION_ENTREPOT        => "Gestion d'entrepôt",
            self::SUPPLY_CHAIN            => 'Supply Chain Management',
            self::IMPORT_EXPORT           => 'Importation / Exportation',
            self::DEDOUANEMENT            => 'Dédouanement',
            self::INCOTERMS               => 'Incoterms',
            self::TRANSPORT_ROUTIER       => 'Transport routier',
            self::TRANSPORT_MARITIME      => 'Transport maritime',
            self::FRET_AERIEN             => 'Fret aérien',
            self::GESTION_FLOTTE          => 'Gestion de flotte',
            self::PLANIFICATION_LOGISTIQUE=> 'Planification logistique',
            self::WMS                     => 'WMS (Warehouse Mgmt System)',
            self::LEAN_SUPPLY_CHAIN       => 'Lean Supply Chain',
            self::ACHATS_APPROVISIONNEMENT=> 'Achats / Approvisionnement',
            self::GESTION_FOURNISSEURS    => 'Gestion des fournisseurs',
            self::PROCUREMENT             => 'Procurement',
            self::COLD_CHAIN              => 'Cold Chain (chaîne du froid)',
            // Santé
            self::SOINS_INFIRMIERS        => 'Soins infirmiers',
            self::MEDECINE_GENERALE       => 'Médecine générale',
            self::PHARMACOLOGIE           => 'Pharmacologie',
            self::BIOLOGIE_MEDICALE       => 'Biologie médicale',
            self::RADIOLOGIE              => 'Radiologie / Imagerie',
            self::SAGE_FEMME              => 'Sage-femme',
            self::KINESITHERAPIE          => 'Kinésithérapie',
            self::NUTRITION               => 'Nutrition / Diététique',
            self::SANTE_PUBLIQUE          => 'Santé publique',
            self::EPIDEMIOLOGIE           => 'Épidémiologie',
            self::GESTION_HOSPITALIERE    => 'Gestion hospitalière',
            self::PHARMACIE               => 'Pharmacie',
            self::MEDECINE_TRAVAIL        => 'Médecine du travail',
            self::DENTISTERIE             => 'Dentisterie',
            self::PSYCHOLOGIE_CLINIQUE    => 'Psychologie clinique',
            self::URGENCES_MEDICALES      => 'Assistance médicale urgente',
            // Droit
            self::DROIT_AFFAIRES_OHADA    => 'Droit des affaires OHADA',
            self::DROIT_TRAVAIL_JUR       => 'Droit du travail',
            self::DROIT_FISCAL            => 'Droit fiscal camerounais',
            self::DROIT_COMMERCIAL        => 'Droit commercial',
            self::DROIT_CONTRATS          => 'Droit des contrats',
            self::CONTENTIEUX             => 'Contentieux / Procédure',
            self::PROPRIETE_INTELLECTUELLE=> 'Propriété intellectuelle',
            self::COMPLIANCE              => 'Compliance / Conformité',
            self::RGPD                    => 'RGPD / Protection des données',
            self::ARBITRAGE               => 'Arbitrage commercial',
            self::DROIT_BANCAIRE          => 'Droit bancaire',
            self::SECRETARIAT_JURIDIQUE   => 'Secrétariat juridique',
            self::REDACTION_ACTES         => "Rédaction d'actes",
            self::DROIT_PUBLIC            => 'Droit public / administratif',
            // Agriculture
            self::AGRONOMIE               => 'Agronomie',
            self::CULTURE_CACAOYERE       => 'Culture cacaoyère / caféière',
            self::ELEVAGE                 => 'Élevage',
            self::PISCICULTURE            => 'Pisciculture',
            self::AGRICULTURE_PRECISION   => 'Agriculture de précision',
            self::AGROFORESTERIE          => 'Agroforesterie',
            self::IRRIGATION              => 'Irrigation',
            self::HACCP                   => 'Qualité alimentaire (HACCP)',
            self::INDUSTRIE_AGROALIM      => 'Industrie agro-alimentaire',
            self::GESTION_FORESTIERE      => 'Gestion forestière',
            self::ETUDE_IMPACT_ENVIRO     => "Évaluation d'impact environnemental",
            self::TRAITEMENT_EAUX         => 'Traitement des eaux',
            self::GESTION_DECHETS         => 'Gestion des déchets',
            self::ISO_14001               => 'Certification ISO 14001',
            // Enseignement
            self::PEDAGOGIE               => 'Pédagogie',
            self::INGENIERIE_FORMATION    => 'Ingénierie de formation',
            self::ELEARNING               => 'E-learning / LMS',
            self::TUTORAT_COACHING        => 'Tutorat / Coaching',
            self::CONCEPTION_CURRICULA    => 'Conception de curricula',
            self::EVALUATION_PEDAGOGIQUE  => 'Évaluation pédagogique',
            self::FORMATION_PRO           => 'Formation professionnelle',
            self::ENSEIGNEMENT_PRIMAIRE   => 'Enseignement primaire',
            self::ENSEIGNEMENT_SECONDAIRE => 'Enseignement secondaire',
            self::ENSEIGNEMENT_SUPERIEUR  => 'Enseignement supérieur',
            self::EDUCATION_SPECIALISEE   => 'Éducation spécialisée',
            self::FOAD                    => 'Formation aux adultes (FOAD)',
            // Communication
            self::GRAPHISME               => 'Graphisme / Design graphique',
            self::PHOTOSHOP               => 'Adobe Photoshop',
            self::ILLUSTRATOR             => 'Adobe Illustrator',
            self::INDESIGN                => 'Adobe InDesign',
            self::CANVA                   => 'Canva',
            self::FIGMA                   => 'Figma',
            self::UI_UX                   => 'UI/UX Design',
            self::MOTION_DESIGN           => 'Motion Design',
            self::MONTAGE_VIDEO           => 'Vidéo / Montage (Premiere)',
            self::PHOTOGRAPHIE            => 'Photographie',
            self::JOURNALISME             => 'Journalisme',
            self::REDACTION_WEB           => 'Rédaction web (copywriting)',
            self::RELATIONS_PRESSE        => 'Relations presse',
            self::COMMUNICATION_INSTIT    => 'Communication institutionnelle',
            self::RELATIONS_PUBLIQUES     => 'Relations publiques (RP)',
            self::EVENEMENTIEL            => 'Événementiel',
            self::PRODUCTION_AUDIO        => 'Production audio / radio',
            self::BRAND_DESIGN            => 'Brand design',
            // Hôtellerie
            self::GESTION_HOTELIERE       => 'Gestion hôtelière',
            self::FRONT_OFFICE            => 'Front Office / Réception',
            self::CUISINE                 => 'Restauration / Cuisine',
            self::PATISSERIE              => 'Pâtisserie',
            self::SERVICE_EN_SALLE        => 'Service en salle',
            self::HOUSEKEEPING            => 'Housekeeping',
            self::GESTION_TOURISTIQUE     => 'Gestion touristique',
            self::AGENCE_VOYAGE           => 'Agence de voyage',
            self::REVENUE_MANAGEMENT      => 'Revenue Management',
            self::FB_MANAGEMENT           => 'Food & Beverage Management',
            self::HYGIENE_ALIMENTAIRE     => 'HACCP (hygiène alimentaire)',
            self::TOURISME_ECO            => 'Tourisme écologique',
            // Sécurité / Qualité
            self::HSE                     => 'Hygiène Sécurité Environnement (HSE)',
            self::ISO_9001                => 'ISO 9001 (Management qualité)',
            self::ISO_45001               => 'ISO 45001 (Sécurité au travail)',
            self::AUDIT_QUALITE           => 'Audit qualité',
            self::CONTROLE_QUALITE        => 'Contrôle qualité',
            self::PREVENTION_RISQUES      => 'Plan de prévention des risques',
            self::QHSE                    => 'QHSE',
            self::DUER                    => 'Document unique (DUER)',
            self::SECURITE_INCENDIE       => 'Sécurité incendie',
            self::PREMIERS_SECOURS        => 'Premiers secours (SST)',
            self::LEAN_MANAGEMENT         => 'Lean Management',
            self::SIX_SIGMA               => 'Six Sigma',
            self::KAIZEN                  => 'Amélioration continue (Kaizen)',
            self::METROLOGIE              => 'Métrologie',
            // Bureautique
            self::EXCEL                   => 'Microsoft Excel',
            self::EXCEL_AVANCE            => 'Excel avancé (TCD, macros)',
            self::WORD                    => 'Microsoft Word',
            self::POWERPOINT              => 'Microsoft PowerPoint',
            self::OUTLOOK                 => 'Microsoft Outlook',
            self::GOOGLE_WORKSPACE        => 'Google Workspace (Docs, Sheets)',
            self::SAISIE_DONNEES          => 'Saisie de données',
            self::SECRETARIAT_DIRECTION   => 'Secrétariat de direction',
            self::PRISE_DE_NOTES          => 'Prise de notes / Sténographie',
            self::GESTION_DOCUMENTAIRE    => 'Gestion documentaire',
            self::ACCUEIL_STANDARD        => 'Accueil et standard',
            self::ARCHIVAGE               => 'Archivage',
            self::SAP_ERP                 => 'SAP (ERP généraliste)',
            self::ODOO                    => 'Odoo',
            self::REDACTION_ADMINISTRATIVE=> 'Rédaction administrative',
            self::GESTION_AGENDA          => "Gestion d'agenda",
            self::ORGANISATION_EVENEMENTS => "Organisation d'événements",
            self::VEILLE_STRATEGIQUE      => 'Veille stratégique',
            self::REPORTING               => 'Reporting',
            self::TRADUCTION_FR_EN        => 'Traduction FR/EN',
            self::INTERPRETARIAT          => 'Interprétariat',
        };
    }

    public function category(): SkillCategoryEnum
    {
        return match($this) {
            self::PHP, self::LARAVEL, self::SYMFONY, self::PYTHON, self::DJANGO,
            self::FASTAPI, self::JAVASCRIPT, self::TYPESCRIPT, self::NODEJS,
            self::EXPRESSJS, self::REACTJS, self::VUEJS, self::ANGULAR,
            self::NEXTJS, self::NUXTJS, self::LIVEWIRE, self::ALPINEJS,
            self::JAVA, self::SPRING_BOOT, self::KOTLIN, self::SWIFT,
            self::FLUTTER, self::REACT_NATIVE, self::CSHARP, self::DOTNET,
            self::CPP, self::RUBY_ON_RAILS, self::GO, self::RUST,
            self::WORDPRESS, self::SHOPIFY, self::HTML_CSS, self::TAILWIND_CSS,
            self::BOOTSTRAP, self::GRAPHQL, self::REST_API, self::WEBSOCKETS,
            self::MICROSERVICES
                => SkillCategoryEnum::DEVELOPPEMENT,

            self::MYSQL, self::POSTGRESQL, self::SQLITE, self::MSSQL,
            self::ORACLE_DB, self::MONGODB, self::REDIS, self::FIREBASE,
            self::ELASTICSEARCH, self::CASSANDRA, self::POWER_BI, self::TABLEAU,
            self::LOOKER_STUDIO, self::PANDAS, self::SQL_AVANCE,
            self::ETL_DATA_PIPELINE, self::DATA_WAREHOUSE, self::APACHE_SPARK,
            self::HADOOP
                => SkillCategoryEnum::BASE_DE_DONNEES,

            self::GIT, self::GITLAB_CICD, self::DOCKER, self::KUBERNETES,
            self::AWS, self::GCP, self::AZURE, self::TERRAFORM, self::ANSIBLE,
            self::LINUX, self::NGINX_APACHE, self::JENKINS, self::GITHUB_ACTIONS,
            self::MONITORING, self::SECURITE_RESEAU
                => SkillCategoryEnum::DEVOPS_CLOUD,

            self::MACHINE_LEARNING, self::DEEP_LEARNING, self::TENSORFLOW,
            self::PYTORCH, self::SCIKIT_LEARN, self::NLP, self::COMPUTER_VISION,
            self::DATA_ANALYSIS, self::STATISTIQUES, self::R_LANGUAGE,
            self::PROMPT_ENGINEERING, self::RAG_LLM
                => SkillCategoryEnum::IA_DATA_SCIENCE,

            self::COMPTABILITE_GENERALE, self::COMPTABILITE_ANALYTIQUE,
            self::COMPTABILITE_SOCIETES, self::PLAN_OHADA, self::TRESORERIE,
            self::RAPPROCHEMENT_BANCAIRE, self::DECLARATIONS_FISCALES, self::TVA,
            self::LIASSES_FISCALES, self::AUDIT_INTERNE, self::AUDIT_EXTERNE,
            self::CONTROLE_GESTION, self::BUDGET_PREVISIONNEL,
            self::ANALYSE_FINANCIERE, self::CONSOLIDATION_COMPTES,
            self::IFRS_SYSCOHADA, self::SAGE_COMPTABILITE, self::SAGE_PAIE,
            self::SAP_FICO, self::CEGID, self::QUICKBOOKS,
            self::GESTION_IMMOBILISATIONS, self::REPORTING_FINANCIER,
            self::GESTION_STOCKS_COMPTA, self::FINANCE_ISLAMIQUE,
            self::MODELISATION_FINANCIERE, self::PRIVATE_EQUITY, self::MICROFINANCE
                => SkillCategoryEnum::COMPTABILITE_FINANCE,

            self::RECRUTEMENT, self::GESTION_PAIE, self::ADMIN_PERSONNEL,
            self::DROIT_TRAVAIL, self::CNPS, self::FORMATION_DEV,
            self::EVALUATION_PERFORMANCES, self::GPEC, self::GESTION_CONFLITS,
            self::RELATIONS_SOCIALES, self::POLITIQUE_REMUNERATION,
            self::ONBOARDING, self::MARQUE_EMPLOYEUR, self::SIRH,
            self::PSYCHOLOGIE_TRAVAIL, self::RSE
                => SkillCategoryEnum::RH,

            self::PROSPECTION, self::NEGOCIATION, self::CRM,
            self::GESTION_PORTEFEUILLE, self::MARKETING_DIGITAL, self::SEO_SEA,
            self::COMMUNITY_MANAGEMENT, self::EMAIL_MARKETING, self::FACEBOOK_ADS,
            self::GOOGLE_ADS, self::CONTENT_MARKETING, self::GROWTH_HACKING,
            self::ECOMMERCE, self::STRATEGIE_B2B, self::GESTION_GRANDS_COMPTES,
            self::MERCHANDISING, self::ANIMATION_RESEAU_VENTE, self::APPELS_OFFRES,
            self::TRADE_MARKETING, self::MARKET_RESEARCH
                => SkillCategoryEnum::COMMERCE_MARKETING,

            self::GESTION_PROJET_PMP, self::AGILE_SCRUM, self::KANBAN,
            self::PRINCE2, self::MS_PROJECT, self::JIRA, self::TRELLO_ASANA_NOTION,
            self::MANAGEMENT_EQUIPE, self::LEADERSHIP, self::GESTION_CHANGEMENT,
            self::CONDUITE_CHANGEMENT, self::PLANIFICATION_STRAT,
            self::GESTION_RISQUES, self::REPORTING_PROJET, self::ANIMATION_REUNIONS,
            self::COACHING_EQUIPE, self::OKR
                => SkillCategoryEnum::MANAGEMENT_PROJET,

            self::TOPOGRAPHIE, self::DESSIN_TECHNIQUE, self::AUTOCAD,
            self::REVIT_BIM, self::ARCHICAD, self::BETON_ARME,
            self::CHARPENTE_METALLIQUE, self::GEOTECHNIQUE, self::VRD,
            self::SUIVI_CHANTIER, self::METRES_DEVIS, self::GESTION_CHANTIER,
            self::ETUDE_SOL, self::HYDRAULIQUE, self::ASSAINISSEMENT,
            self::THERMIQUE_BATIMENT, self::ARCHITECTURE_INTERIEUR,
            self::MACONNERIE, self::PLOMBERIE, self::ELECTRICITE_BATIMENT,
            self::HSE_BTP
                => SkillCategoryEnum::GENIE_CIVIL_BTP,

            self::ELECTROTECHNIQUE, self::AUTOMATISME, self::API_PLC,
            self::INSTRUMENTATION, self::SOLAIRE_PV, self::MAINTENANCE_ELECTRIQUE,
            self::HAUTE_TENSION, self::GROUPE_ELECTROGENE,
            self::EFFICACITE_ENERGETIQUE, self::ELECTRONIQUE_PUISSANCE,
            self::EOLIEN, self::RESEAUX_ELECTRIQUES, self::CABLAGE_INDUSTRIEL,
            self::SCADA
                => SkillCategoryEnum::ELECTRICITE_ENERGIE,

            self::ADMIN_RESEAU, self::CISCO, self::FIREWALL_VPN,
            self::CYBERSECURITE, self::RESEAUX_MOBILES, self::FIBRE_OPTIQUE,
            self::VOIP, self::ACTIVE_DIRECTORY, self::WINDOWS_SERVER,
            self::HELPDESK, self::VLAN_SWITCHING, self::SOC, self::PENTEST,
            self::WIFI_ENTERPRISE, self::M365_ADMIN
                => SkillCategoryEnum::TELECOM_RESEAU,

            self::GESTION_STOCKS, self::GESTION_ENTREPOT, self::SUPPLY_CHAIN,
            self::IMPORT_EXPORT, self::DEDOUANEMENT, self::INCOTERMS,
            self::TRANSPORT_ROUTIER, self::TRANSPORT_MARITIME, self::FRET_AERIEN,
            self::GESTION_FLOTTE, self::PLANIFICATION_LOGISTIQUE, self::WMS,
            self::LEAN_SUPPLY_CHAIN, self::ACHATS_APPROVISIONNEMENT,
            self::GESTION_FOURNISSEURS, self::PROCUREMENT, self::COLD_CHAIN
                => SkillCategoryEnum::LOGISTIQUE_TRANSPORT,

            self::SOINS_INFIRMIERS, self::MEDECINE_GENERALE, self::PHARMACOLOGIE,
            self::BIOLOGIE_MEDICALE, self::RADIOLOGIE, self::SAGE_FEMME,
            self::KINESITHERAPIE, self::NUTRITION, self::SANTE_PUBLIQUE,
            self::EPIDEMIOLOGIE, self::GESTION_HOSPITALIERE, self::PHARMACIE,
            self::MEDECINE_TRAVAIL, self::DENTISTERIE, self::PSYCHOLOGIE_CLINIQUE,
            self::URGENCES_MEDICALES
                => SkillCategoryEnum::SANTE_MEDICAL,

            self::DROIT_AFFAIRES_OHADA, self::DROIT_TRAVAIL_JUR, self::DROIT_FISCAL,
            self::DROIT_COMMERCIAL, self::DROIT_CONTRATS, self::CONTENTIEUX,
            self::PROPRIETE_INTELLECTUELLE, self::COMPLIANCE, self::RGPD,
            self::ARBITRAGE, self::DROIT_BANCAIRE, self::SECRETARIAT_JURIDIQUE,
            self::REDACTION_ACTES, self::DROIT_PUBLIC
                => SkillCategoryEnum::DROIT_JURIDIQUE,

            self::AGRONOMIE, self::CULTURE_CACAOYERE, self::ELEVAGE,
            self::PISCICULTURE, self::AGRICULTURE_PRECISION, self::AGROFORESTERIE,
            self::IRRIGATION, self::HACCP, self::INDUSTRIE_AGROALIM,
            self::GESTION_FORESTIERE, self::ETUDE_IMPACT_ENVIRO,
            self::TRAITEMENT_EAUX, self::GESTION_DECHETS, self::ISO_14001
                => SkillCategoryEnum::AGRICULTURE_ENVIRONNEMENT,

            self::PEDAGOGIE, self::INGENIERIE_FORMATION, self::ELEARNING,
            self::TUTORAT_COACHING, self::CONCEPTION_CURRICULA,
            self::EVALUATION_PEDAGOGIQUE, self::FORMATION_PRO,
            self::ENSEIGNEMENT_PRIMAIRE, self::ENSEIGNEMENT_SECONDAIRE,
            self::ENSEIGNEMENT_SUPERIEUR, self::EDUCATION_SPECIALISEE, self::FOAD
                => SkillCategoryEnum::ENSEIGNEMENT_FORMATION,

            self::GRAPHISME, self::PHOTOSHOP, self::ILLUSTRATOR, self::INDESIGN,
            self::CANVA, self::FIGMA, self::UI_UX, self::MOTION_DESIGN,
            self::MONTAGE_VIDEO, self::PHOTOGRAPHIE, self::JOURNALISME,
            self::REDACTION_WEB, self::RELATIONS_PRESSE, self::COMMUNICATION_INSTIT,
            self::RELATIONS_PUBLIQUES, self::EVENEMENTIEL, self::PRODUCTION_AUDIO,
            self::BRAND_DESIGN
                => SkillCategoryEnum::COMMUNICATION_DESIGN,

            self::GESTION_HOTELIERE, self::FRONT_OFFICE, self::CUISINE,
            self::PATISSERIE, self::SERVICE_EN_SALLE, self::HOUSEKEEPING,
            self::GESTION_TOURISTIQUE, self::AGENCE_VOYAGE,
            self::REVENUE_MANAGEMENT, self::FB_MANAGEMENT,
            self::HYGIENE_ALIMENTAIRE, self::TOURISME_ECO
                => SkillCategoryEnum::HOTELLERIE_TOURISME,

            self::HSE, self::ISO_9001, self::ISO_45001, self::AUDIT_QUALITE,
            self::CONTROLE_QUALITE, self::PREVENTION_RISQUES, self::QHSE,
            self::DUER, self::SECURITE_INCENDIE, self::PREMIERS_SECOURS,
            self::LEAN_MANAGEMENT, self::SIX_SIGMA, self::KAIZEN, self::METROLOGIE
                => SkillCategoryEnum::SECURITE_QUALITE,

            self::EXCEL, self::EXCEL_AVANCE, self::WORD, self::POWERPOINT,
            self::OUTLOOK, self::GOOGLE_WORKSPACE, self::SAISIE_DONNEES,
            self::SECRETARIAT_DIRECTION, self::PRISE_DE_NOTES,
            self::GESTION_DOCUMENTAIRE, self::ACCUEIL_STANDARD, self::ARCHIVAGE,
            self::SAP_ERP, self::ODOO, self::REDACTION_ADMINISTRATIVE,
            self::GESTION_AGENDA, self::ORGANISATION_EVENEMENTS,
            self::VEILLE_STRATEGIQUE, self::REPORTING, self::TRADUCTION_FR_EN,
            self::INTERPRETARIAT
                => SkillCategoryEnum::BUREAUTIQUE_TRANSVERSAL,
        };
    }
}
