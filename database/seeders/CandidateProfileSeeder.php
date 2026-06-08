<?php

namespace Database\Seeders;

use App\Enums\AvailabilityEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\LanguageProfileEnum;
use App\Models\CandidateProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class CandidateProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get candidate users
        $candidat1 = User::where('email', 'candidat1@test.cm')->first();
        $candidat2 = User::where('email', 'candidat2@test.cm')->first();
        $candidat3 = User::where('email', 'candidat3@test.cm')->first();

        // Jean Ekotto
        if ($candidat1) {
            CandidateProfile::create([
                'user_id' => $candidat1->id,
                'phone' => '+237672345678',
                'city' => 'Douala',
                'region' => 'Littoral',
                'country' => 'Cameroon',
                'language_profile' => LanguageProfileEnum::BILINGUE,
                'availability' => AvailabilityEnum::IMMEDIATE,
                'experience_tier' => ExperienceTierEnum::TIER_3,
                'education_level' => EducationLevelEnum::LICENCE,
                'education_field' => 'Computer Science',
                'salary_min' => 500000,
                'salary_max' => 1200000,
                'is_suspended' => false,
            ]);
        }

        // Marie Mballa
        if ($candidat2) {
            CandidateProfile::create([
                'user_id' => $candidat2->id,
                'phone' => '+237698765432',
                'city' => 'Yaoundé',
                'region' => 'Centre',
                'country' => 'Cameroon',
                'language_profile' => LanguageProfileEnum::FRANCOPHONE,
                'availability' => AvailabilityEnum::FIFTEEN_DAYS,
                'experience_tier' => ExperienceTierEnum::TIER_2,
                'education_level' => EducationLevelEnum::MASTER,
                'education_field' => 'Accounting & Finance',
                'salary_min' => 600000,
                'salary_max' => 1500000,
                'is_suspended' => false,
            ]);
        }

        // Alain Nkodo
        if ($candidat3) {
            CandidateProfile::create([
                'user_id' => $candidat3->id,
                'phone' => '+237655555555',
                'city' => 'Douala',
                'region' => 'Littoral',
                'country' => 'Cameroon',
                'language_profile' => LanguageProfileEnum::ANGLOPHONE,
                'availability' => AvailabilityEnum::THIRTY_DAYS,
                'experience_tier' => ExperienceTierEnum::TIER_1,
                'education_level' => EducationLevelEnum::BTS,
                'education_field' => 'Business Administration',
                'salary_min' => 300000,
                'salary_max' => 700000,
                'is_suspended' => false,
            ]);
        }
    }
}
