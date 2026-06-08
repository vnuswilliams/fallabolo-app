<?php

namespace Database\Seeders;

use App\Enums\ApplicationStatusEnum;
use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\JobOffer;
use App\Models\MatchResult;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get candidates and job offers
        $jeanEkotto = CandidateProfile::whereHas('user', function ($q) {
            $q->where('email', 'candidat1@test.cm');
        })->first();

        $marieMballa = CandidateProfile::whereHas('user', function ($q) {
            $q->where('email', 'candidat2@test.cm');
        })->first();

        $developerJobOffer = JobOffer::where('title', 'Développeur Laravel Senior')->first();
        $accountantJobOffer = JobOffer::where('title', 'Comptable Senior')->first();

        // Application 1: Jean Ekotto → Développeur Laravel Senior
        if ($jeanEkotto && $developerJobOffer) {
            $matchResult1 = MatchResult::create([
                'job_offer_id' => $developerJobOffer->id,
                'candidate_profile_id' => $jeanEkotto->id,
                'passed_blocking' => true,
                'score_skills' => 85,
                'score_experience' => 88,
                'score_education' => 90,
                'score_availability' => 100,
                'score_location' => 95,
                'score_salary' => 80,
                'score_principal' => 87,
                'assets_matched' => json_encode(['certifications' => []]),
                'extra_skills' => json_encode(['Docker', 'Git', 'API REST']),
                'is_stale' => false,
                'calculated_at' => now()->setDate(2026, 6, 1),
            ]);

            Application::create([
                'match_result_id' => $matchResult1->id,
                'status' => ApplicationStatusEnum::PENDING,
                'applied_at' => now()->setDate(2026, 6, 1),
            ]);
        }

        // Application 2: Marie Mballa → Comptable Senior
        if ($marieMballa && $accountantJobOffer) {
            $matchResult2 = MatchResult::create([
                'job_offer_id' => $accountantJobOffer->id,
                'candidate_profile_id' => $marieMballa->id,
                'passed_blocking' => true,
                'score_skills' => 92,
                'score_experience' => 85,
                'score_education' => 95,
                'score_availability' => 80,
                'score_location' => 100,
                'score_salary' => 88,
                'score_principal' => 90,
                'assets_matched' => json_encode(['certifications' => ['Certification CFA']]),
                'extra_skills' => json_encode(['Excel avancé', 'OHADA']),
                'is_stale' => false,
                'calculated_at' => now()->setDate(2026, 5, 28),
            ]);

            Application::create([
                'match_result_id' => $matchResult2->id,
                'status' => ApplicationStatusEnum::VIEWED,
                'applied_at' => now()->setDate(2026, 5, 28),
            ]);
        }
    }
}
