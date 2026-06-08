<?php

namespace Database\Seeders;

use App\Enums\AvailabilityEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\JobStatusEnum;
use App\Enums\JobTemplateEnum;
use App\Enums\LanguageProfileEnum;
use App\Models\JobOffer;
use App\Models\RecruiterProfile;
use Illuminate\Database\Seeder;

class JobOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get recruiter profiles
        $techcorp = RecruiterProfile::where('company_name', 'TechCorp')->first();
        $fingroup = RecruiterProfile::where('company_name', 'FinGroup')->first();
        $agencedig = RecruiterProfile::where('company_name', 'AgenceDig')->first();

        // Job Offer 1: Développeur Laravel Senior at TechCorp
        if ($techcorp) {
            JobOffer::create([
                'recruiter_profile_id' => $techcorp->id,
                'title' => 'Développeur Laravel Senior',
                'description' => 'Nous recherchons un développeur Laravel senior avec une expérience confirmée en développement web. Vous serez responsable de la conception et du développement de nouvelles fonctionnalités.',
                'template' => JobTemplateEnum::CADRE,
                'city' => 'Douala',
                'region' => 'Littoral',
                'country' => 'Cameroon',
                'blocking_language' => LanguageProfileEnum::BILINGUE,
                'blocking_education' => EducationLevelEnum::LICENCE,
                'blocking_experience' => ExperienceTierEnum::TIER_3,
                'blocking_availability' => AvailabilityEnum::IMMEDIATE,
                'required_experience' => ExperienceTierEnum::TIER_3,
                'required_education' => EducationLevelEnum::LICENCE,
                'required_availability' => AvailabilityEnum::IMMEDIATE,
                'budget_min' => 800000,
                'budget_max' => 1500000,
                'status' => JobStatusEnum::PUBLISHED,
                'published_at' => now()->setDate(2026, 6, 2),
                'expires_at' => now()->setDate(2026, 7, 2),
            ]);
        }

        // Job Offer 2: Comptable Senior at FinGroup
        if ($fingroup) {
            JobOffer::create([
                'recruiter_profile_id' => $fingroup->id,
                'title' => 'Comptable Senior',
                'description' => 'FinGroup recherche un comptable senior avec une maîtrise des normes OHADA et une expérience en gestion comptable générale.',
                'template' => JobTemplateEnum::AGENT,
                'city' => 'Yaoundé',
                'region' => 'Centre',
                'country' => 'Cameroon',
                'blocking_language' => LanguageProfileEnum::FRANCOPHONE,
                'blocking_education' => EducationLevelEnum::LICENCE,
                'blocking_experience' => ExperienceTierEnum::TIER_2,
                'blocking_availability' => AvailabilityEnum::FIFTEEN_DAYS,
                'required_experience' => ExperienceTierEnum::TIER_2,
                'required_education' => EducationLevelEnum::LICENCE,
                'required_availability' => AvailabilityEnum::FIFTEEN_DAYS,
                'budget_min' => 700000,
                'budget_max' => 1200000,
                'status' => JobStatusEnum::PUBLISHED,
                'published_at' => now()->setDate(2026, 5, 28),
                'expires_at' => now()->setDate(2026, 6, 28),
            ]);
        }

        // Job Offer 3: Responsable RH at AgenceDig
        if ($agencedig) {
            JobOffer::create([
                'recruiter_profile_id' => $agencedig->id,
                'title' => 'Responsable RH',
                'description' => 'AgenceDig recrute un Responsable RH pour gérer l\'ensemble des processus de recrutement, formation et gestion administrative du personnel.',
                'template' => JobTemplateEnum::CADRE,
                'city' => 'Douala',
                'region' => 'Littoral',
                'country' => 'Cameroon',
                'blocking_language' => LanguageProfileEnum::FRANCOPHONE,
                'blocking_education' => EducationLevelEnum::LICENCE,
                'blocking_experience' => ExperienceTierEnum::TIER_2,
                'blocking_availability' => AvailabilityEnum::THIRTY_DAYS,
                'required_experience' => ExperienceTierEnum::TIER_2,
                'required_education' => EducationLevelEnum::LICENCE,
                'required_availability' => AvailabilityEnum::THIRTY_DAYS,
                'budget_min' => 600000,
                'budget_max' => 1100000,
                'status' => JobStatusEnum::PUBLISHED,
                'published_at' => now()->setDate(2026, 5, 15),
                'expires_at' => now()->setDate(2026, 6, 15),
            ]);
        }
    }
}
