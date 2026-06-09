<?php

namespace Database\Seeders;

use App\Enums\TestimonialStatusEnum;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'content' => 'En 3 ans de recrutement je n\'avais jamais reçu des candidatures aussi qualifiées dès le premier jour. Le classement automatique m\'a fait économiser deux jours de travail sur notre dernière campagne.',
                'rating'  => 5,
                'status'  => TestimonialStatusEnum::APPROVED->value,
            ],
            [
                'content' => 'Voir mon score avant de postuler a tout changé. Je cible uniquement les offres où je dépasse 80 %. J\'ai décroché mon poste actuel en 12 jours.',
                'rating'  => 5,
                'status'  => TestimonialStatusEnum::APPROVED->value,
            ],
            [
                'content' => 'On avait l\'habitude de recevoir 150 CVs par poste. Avec MatchRH on en reçoit 25, toutes pertinentes. Les critères bloquants font le filtre à notre place.',
                'rating'  => 5,
                'status'  => TestimonialStatusEnum::APPROVED->value,
            ],
            [
                'content' => 'Sans CV obligatoire, j\'ai pu me concentrer sur ce que je sais vraiment faire. Mon profil reflète mes vraies compétences — le recruteur m\'a rappelé en 48 h.',
                'rating'  => 5,
                'status'  => TestimonialStatusEnum::APPROVED->value,
            ],
            [
                'content' => 'L\'algorithme est transparent — chaque score est décomposé, explicable. Nos équipes l\'ont adopté sans résistance parce qu\'elles comprennent la logique. Pas de boîte noire.',
                'rating'  => 5,
                'status'  => TestimonialStatusEnum::APPROVED->value,
            ],
            [
                'content' => 'J\'ai passé des mois à adapter mon CV sans résultats. Sur MatchRH j\'ai rempli mon profil une fois et les offres viennent à moi. Le système de recommandations est vraiment efficace.',
                'rating'  => 5,
                'status'  => TestimonialStatusEnum::APPROVED->value,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create([
                'user_id' => null, // témoignages de démonstration, sans utilisateur réel
                'content' => $data['content'],
                'rating'  => $data['rating'],
                'status'  => $data['status'],
            ]);
        }
    }
}
