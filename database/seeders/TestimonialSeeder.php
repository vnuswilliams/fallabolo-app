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
                'author_name' => 'Marie Kamga',
                'author_role' => 'Responsable RH',
                'author_company' => 'TechCom Cameroun',
                'author_color' => 'emerald',
                'author_badge' => 'Recruteur',
                'content' => 'En 3 ans de recrutement je n\'avais jamais reçu des candidatures aussi qualifiées dès le premier jour. Le classement automatique m\'a fait économiser deux jours de travail sur notre dernière campagne.',
                'rating' => 5,
                'status' => TestimonialStatusEnum::APPROVED->value,
            ],
            [
                'author_name' => 'Jean-Paul Nkoa',
                'author_role' => 'Développeur Full Stack',
                'author_company' => 'Indépendant, Yaoundé',
                'author_color' => 'indigo',
                'author_badge' => 'Candidat',
                'content' => 'Voir mon score avant de postuler a tout changé. Je cible uniquement les offres où je dépasse 80 %. J\'ai décroché mon poste actuel en 12 jours.',
                'rating' => 5,
                'status' => TestimonialStatusEnum::APPROVED->value,
            ],
            [
                'author_name' => 'Sophie Bello',
                'author_role' => 'DG',
                'author_company' => 'Agence Digit+ Douala',
                'author_color' => 'amber',
                'author_badge' => 'Recruteur',
                'content' => 'On avait l\'habitude de recevoir 150 CVs par poste. Avec MatchRH on en reçoit 25, toutes pertinentes. Les critères bloquants font le filtre à notre place.',
                'rating' => 5,
                'status' => TestimonialStatusEnum::APPROVED->value,
            ],
            [
                'author_name' => 'Samuel Essomba',
                'author_role' => 'Gérant',
                'author_company' => 'PME Logistique, Douala',
                'author_color' => 'teal',
                'author_badge' => 'Recruteur',
                'content' => "L'algorithme est transparent chaque score est décomposé. Mes équipes l'ont adopté sans résistance parce qu'elles comprennent la logique. Pas de boîte noire, pas de méfiance. Juste des décisions plus rapides et mieux justifiées.",
                'rating' => 5,
                'status' => TestimonialStatusEnum::APPROVED->value,
            ],
            [
                'author_name' => 'Rose Nguefack',
                'author_role' => 'Ingénieure reconvertie RH',
                'author_company' => 'Ngaoundéré',
                'author_color' => 'rose',
                'author_badge' => 'Candidat',
                'content' => "J'avais peur que mon parcours atypique me pénalise. Mais le score valorise ce que je sais faire pas la linéarité de mon CV. Mon double profil technique et RH est devenu un atout visible, pas une anomalie à expliquer.",
                'rating' => 5,
                'status' => TestimonialStatusEnum::APPROVED->value,
            ],
            [
                'author_name' => 'Marie-Claire Kamto',
                'author_role' => 'Head of Talent',
                'author_company' => 'Banque régionale',
                'author_color' => 'indigo',
                'author_badge' => 'Recruteur',
                'content' => "En 3 ans de recrutement je n'avais jamais reçu des candidatures aussi ciblées dès le premier jour. Et pour la première fois, je peux justifier mes sélections avec des données plus de décisions au feeling difficiles à défendre.",
                'rating' => 5,
                'status' => TestimonialStatusEnum::APPROVED->value,
            ],
        ];

        // Clear existing testimonials to avoid duplicates when re-seeding
        Testimonial::truncate();

        foreach ($testimonials as $data) {
            Testimonial::create([
                'user_id' => null,
                'author_name' => $data['author_name'],
                'author_role' => $data['author_role'],
                'author_company' => $data['author_company'],
                'author_color' => $data['author_color'],
                'author_badge' => $data['author_badge'],
                'content' => $data['content'],
                'rating' => $data['rating'],
                'status' => $data['status'],
            ]);
        }
    }
}
