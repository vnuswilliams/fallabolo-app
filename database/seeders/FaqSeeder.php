<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;
use App\Enums\ReportStatusEnum;

class FaqSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faqs = [
        [
            'question' => 'Dois-je obligatoirement envoyer un CV pour postuler ?',
            'answer'   => 'Non, le CV est entièrement optionnel sur MatchRH. Vous créez un profil structuré (compétences notées /5, expériences vérifiables, langues, disponibilité) et c\'est lui qui génère votre score de compatibilité. Si vous avez un CV, vous pouvez l\'attacher, mais il n\'est jamais un prérequis pour postuler.',
        ],
        [
            'question' => 'Comment est calculé mon score de compatibilité ?',
            'answer'   => 'Le score est entièrement transparent et déterministe pas de boîte noire. Il repose sur 6 dimensions pondérées : compétences (50 %), expérience (20 %), formation (10 %), langues (10 %), disponibilité (5 %) et localisation (5 %). Des points bonus s\'ajoutent pour les certifications et expertises rares. Chaque critère est visible avant même que vous postuliez.',
        ],
        [
            'question' => 'Puis-je voir mon score avant de postuler à une offre ?',
            'answer'   => 'Oui, c\'est l\'une des fonctionnalités clés de MatchRH. Avant chaque candidature, vous voyez votre compatibilité estimée et sa décomposition détaillée. Vous pouvez ainsi postuler en connaissance de cause ou améliorer votre profil pour augmenter votre score.',
        ],
        [
            'question' => 'Je suis recruteur : combien coûte la plateforme ?',
            'answer'   => 'MatchRH est entièrement gratuit, sans limite cachée. Offres illimitées, candidatures illimitées, classement automatique, notifications temps réel tout est inclus sans carte bancaire requise. La gratuité totale est notre avantage stratégique : elle permet d\'agréger rapidement la masse critique de candidats et de recruteurs.',
        ],
        [
            'question' => 'Qu\'est-ce qu\'un critère bloquant et comment ça fonctionne ?',
            'answer'   => 'Un critère bloquant est une exigence non-négociable définie par le recruteur permis de conduire, niveau d\'expérience minimum, localisation, etc. Si le candidat ne satisfait pas ce critère, son score tombe automatiquement à 0 et sa candidature n\'apparaît pas dans le classement. Les recruteurs ne voient que des profils réellement éligibles.',
        ],
        [
            'question' => 'Comment MatchRH protège-t-il mes données personnelles ?',
            'answer'   => 'Vos données sont hébergées conformément à la loi camerounaise sur la protection des données personnelles (2024). Les accès sont contrôlés par rôle, les actions importantes sont tracées, et vous pouvez demander la suppression de votre profil à tout moment. Vos informations ne sont jamais revendues à des tiers.',
        ],
        [
            'question' => 'Qu\'est-ce que l\'intégration MCP annoncée sur la plateforme ?',
            'answer'   => 'MCP (Model Context Protocol) est un protocole qui permettra d\'interagir avec MatchRH directement depuis des assistants IA (Claude, ChatGPT, Cursor…). Recruteurs et candidats pourront consulter des classements, publier des offres et recevoir des recommandations en langage naturel, sans quitter leur outil habituel. Cette fonctionnalité est en cours de développement.',
        ],
        [
            'question' => 'L\'algorithme de matching est-il biaisé ?',
            'answer'   => 'Le scoring de MatchRH est intentionnellement déterministe et documenté pour minimiser les biais. Il n\'évalue pas la photo, le nom, le sexe ou l\'âge uniquement les compétences, l\'expérience et les critères objectifs définis par le recruteur. Chaque score est décomposé et contestable. L\'objectif : le meilleur profil gagne, pas le meilleur CV designer.',
        ],
    ];

        foreach ($faqs as $data) {
            Faq::create([
                'user_id' => null, // témoignages de démonstration, sans utilisateur réel
                'question' => $data['question'],
                'answer'  => $data['answer'],
                'status'  => ReportStatusEnum::CONFIRMED,
            ]);
        }
    }
}
