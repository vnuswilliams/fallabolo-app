<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skill;
use App\Models\Asset;
use App\Models\RecruiterProfile;
use App\Models\CandidateProfile;
use App\Models\JobOffer;
use App\Enums\RoleEnum;
use App\Enums\AssetCategoryEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\AvailabilityEnum;
use App\Enums\LanguageProfileEnum;
use App\Enums\JobTemplateEnum;
use App\Enums\JobStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MatchRhSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Skills
        $skills = [
            // Développement
            ['name' => 'Laravel', 'category' => 'Développement'],
            ['name' => 'PHP', 'category' => 'Développement'],
            ['name' => 'MySQL', 'category' => 'Développement'],
            ['name' => 'JavaScript', 'category' => 'Développement'],
            ['name' => 'Vue.js', 'category' => 'Développement'],
            ['name' => 'React', 'category' => 'Développement'],
            ['name' => 'Docker', 'category' => 'Développement'],
            ['name' => 'Git', 'category' => 'Développement'],
            ['name' => 'Python', 'category' => 'Développement'],
            ['name' => 'Node.js', 'category' => 'Développement'],
            // Comptabilité
            ['name' => 'Sage Comptabilité', 'category' => 'Comptabilité'],
            ['name' => 'Sage Paie', 'category' => 'Comptabilité'],
            ['name' => 'Excel avancé', 'category' => 'Comptabilité'],
            ['name' => 'OHADA', 'category' => 'Comptabilité'],
            ['name' => 'Gestion budgétaire', 'category' => 'Comptabilité'],
            // RH
            ['name' => 'Recrutement', 'category' => 'RH'],
            ['name' => 'Formation', 'category' => 'RH'],
            ['name' => 'Paie', 'category' => 'RH'],
            ['name' => 'SIRH', 'category' => 'RH'],
            ['name' => 'Gestion des conflits', 'category' => 'RH'],
            // Vente
            ['name' => 'Prospection commerciale', 'category' => 'Vente'],
            ['name' => 'CRM', 'category' => 'Vente'],
            ['name' => 'Marketing digital', 'category' => 'Vente'],
            ['name' => 'Community management', 'category' => 'Vente'],
            // Logistique
            ['name' => 'Gestion des stocks', 'category' => 'Logistique'],
            ['name' => 'Transport', 'category' => 'Logistique'],
            ['name' => 'Supply chain', 'category' => 'Logistique'],
            ['name' => 'Douane', 'category' => 'Logistique'],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(['name' => $skill['name']], $skill);
        }

        // 2. Assets
        $assets = [
            ['name' => 'Expérience BTP', 'category' => AssetCategoryEnum::SECTORIEL],
            ['name' => 'Expérience Banque', 'category' => AssetCategoryEnum::SECTORIEL],
            ['name' => 'Expérience Santé', 'category' => AssetCategoryEnum::SECTORIEL],
            ['name' => 'Expérience Télécoms', 'category' => AssetCategoryEnum::SECTORIEL],
            ['name' => 'Expérience Agriculture', 'category' => AssetCategoryEnum::SECTORIEL],
            ['name' => 'Certification PMP', 'category' => AssetCategoryEnum::CERTIFICATION],
            ['name' => 'Certification CFA', 'category' => AssetCategoryEnum::CERTIFICATION],
            ['name' => 'Certification AWS', 'category' => AssetCategoryEnum::CERTIFICATION],
            ['name' => 'Certification Sage Paie', 'category' => AssetCategoryEnum::CERTIFICATION],
            ['name' => 'OHSAS 18001', 'category' => AssetCategoryEnum::CERTIFICATION],
            ['name' => 'Expérience télétravail', 'category' => AssetCategoryEnum::CONTEXTUEL],
            ['name' => 'Management d’équipe', 'category' => AssetCategoryEnum::CONTEXTUEL],
            ['name' => 'Expérience PME', 'category' => AssetCategoryEnum::CONTEXTUEL],
            ['name' => 'Expérience multinationale', 'category' => AssetCategoryEnum::CONTEXTUEL],
            ['name' => 'Expérience internationale', 'category' => AssetCategoryEnum::CONTEXTUEL],
            ['name' => 'Allemand', 'category' => AssetCategoryEnum::LANGUE_SUPP],
            ['name' => 'Espagnol', 'category' => AssetCategoryEnum::LANGUE_SUPP],
            ['name' => 'Chinois mandarin', 'category' => AssetCategoryEnum::LANGUE_SUPP],
            ['name' => 'Portugais', 'category' => AssetCategoryEnum::LANGUE_SUPP],
        ];

        foreach ($assets as $asset) {
            Asset::updateOrCreate(['name' => $asset['name']], $asset);
        }

        // 3. Users
        $password = Hash::make('password');

        $recruiter1 = User::updateOrCreate(['email' => 'recruteur1@test.cm'], ['name' => 'Recruiter 1', 'password' => $password, 'role' => RoleEnum::RECRUITER]);
        $recruiter2 = User::updateOrCreate(['email' => 'recruteur2@test.cm'], ['name' => 'Recruiter 2', 'password' => $password, 'role' => RoleEnum::RECRUITER]);
        $recruiter3 = User::updateOrCreate(['email' => 'recruteur3@test.cm'], ['name' => 'Recruiter 3', 'password' => $password, 'role' => RoleEnum::RECRUITER]);
        $candidat1 = User::updateOrCreate(['email' => 'candidat1@test.cm'], ['name' => 'Jean Ekotto', 'password' => $password, 'role' => RoleEnum::CANDIDATE]);
        $candidat2 = User::updateOrCreate(['email' => 'candidat2@test.cm'], ['name' => 'Marie Mballa', 'password' => $password, 'role' => RoleEnum::CANDIDATE]);
        $candidat3 = User::updateOrCreate(['email' => 'candidat3@test.cm'], ['name' => 'Alain Nkodo', 'password' => $password, 'role' => RoleEnum::CANDIDATE]);
        $admin = User::updateOrCreate(['email' => 'admin@matchrh.cm'], ['name' => 'Admin MatchRH', 'password' => $password, 'role' => RoleEnum::ADMIN]);
        $benevole = User::updateOrCreate(['email' => 'benevole@test.cm'], ['name' => 'Bénévole Test', 'password' => $password, 'role' => RoleEnum::RECRUITER]);

        // Assign Roles (Spatie)
        $recruiter1->assignRole(RoleEnum::RECRUITER->value);
        $recruiter2->assignRole(RoleEnum::RECRUITER->value);
        $recruiter3->assignRole(RoleEnum::RECRUITER->value);
        $candidat1->assignRole(RoleEnum::CANDIDATE->value);
        $candidat2->assignRole(RoleEnum::CANDIDATE->value);
        $candidat3->assignRole(RoleEnum::CANDIDATE->value);
        $admin->assignRole(RoleEnum::ADMIN->value);
        $benevole->assignRole(RoleEnum::RECRUITER->value);

        // 4. Recruiter Profiles
        $rp1 = RecruiterProfile::updateOrCreate(['user_id' => $recruiter1->id], [
            'company_name' => 'TechCorp Douala',
            'company_sector' => 'Télécommunications',
            'phone' => '690000001',
            'city' => 'Douala',
        ]);

        $rp2 = RecruiterProfile::updateOrCreate(['user_id' => $recruiter2->id], [
            'company_name' => 'FinGroup Yaoundé',
            'company_sector' => 'Banque & Finance',
            'phone' => '690000002',
            'city' => 'Yaoundé',
        ]);

        $rp3 = RecruiterProfile::updateOrCreate(['user_id' => $recruiter3->id], [
            'company_name' => 'AgenceDig Douala',
            'company_sector' => 'Marketing Digital',
            'phone' => '690000003',
            'city' => 'Douala',
        ]);

        // Managed by benevole
        RecruiterProfile::updateOrCreate(['company_name' => 'SmallBiz Managed 1'], [
            'user_id' => null,
            'company_sector' => 'Commerce',
            'phone' => '690000004',
            'city' => 'Douala',
            'is_managed_by' => $benevole->id,
        ]);

        RecruiterProfile::updateOrCreate(['company_name' => 'SmallBiz Managed 2'], [
            'user_id' => null,
            'company_sector' => 'Services',
            'phone' => '690000005',
            'city' => 'Yaoundé',
            'is_managed_by' => $benevole->id,
        ]);

        // 5. Candidate Profiles
        CandidateProfile::updateOrCreate(['user_id' => $candidat1->id], [
            'phone' => '670000001',
            'city' => 'Douala',
            'region' => 'Littoral',
            'language_profile' => LanguageProfileEnum::BILINGUE,
            'availability' => AvailabilityEnum::IMMEDIATE,
            'experience_tier' => ExperienceTierEnum::TIER_3,
            'education_level' => EducationLevelEnum::MASTER,
            'education_field' => 'Informatique',
        ]);

        CandidateProfile::updateOrCreate(['user_id' => $candidat2->id], [
            'phone' => '670000002',
            'city' => 'Yaoundé',
            'region' => 'Centre',
            'language_profile' => LanguageProfileEnum::FRANCOPHONE,
            'availability' => AvailabilityEnum::FIFTEEN_DAYS,
            'experience_tier' => ExperienceTierEnum::TIER_2,
            'education_level' => EducationLevelEnum::LICENCE,
            'education_field' => 'Comptabilité',
        ]);

        CandidateProfile::updateOrCreate(['user_id' => $candidat3->id], [
            'phone' => '670000003',
            'city' => 'Douala',
            'region' => 'Littoral',
            'language_profile' => LanguageProfileEnum::ANGLOPHONE,
            'availability' => AvailabilityEnum::THIRTY_DAYS,
            'experience_tier' => ExperienceTierEnum::TIER_4,
            'education_level' => EducationLevelEnum::MASTER,
            'education_field' => 'Ressources Humaines',
        ]);

        // 6. Job Offers
        JobOffer::updateOrCreate(['title' => 'Développeur Laravel Senior', 'recruiter_profile_id' => $rp1->id], [
            'description' => 'Nous recherchons un développeur Laravel senior pour rejoindre notre équipe à Douala.',
            'template' => JobTemplateEnum::CADRE,
            'city' => 'Douala',
            'region' => 'Littoral',
            'country' => 'Cameroun',
            'blocking_language' => LanguageProfileEnum::BILINGUE,
            'blocking_education' => EducationLevelEnum::MASTER,
            'blocking_experience' => ExperienceTierEnum::TIER_3,
            'blocking_availability' => AvailabilityEnum::THIRTY_DAYS,
            'required_experience' => ExperienceTierEnum::TIER_3,
            'required_education' => EducationLevelEnum::MASTER,
            'required_availability' => AvailabilityEnum::THIRTY_DAYS,
            'status' => JobStatusEnum::PUBLISHED,
            'published_at' => now(),
        ]);

        JobOffer::updateOrCreate(['title' => 'Comptable Senior', 'recruiter_profile_id' => $rp2->id], [
            'description' => 'FinGroup recherche un comptable expérimenté pour son bureau de Yaoundé.',
            'template' => JobTemplateEnum::CADRE,
            'city' => 'Yaoundé',
            'region' => 'Centre',
            'country' => 'Cameroun',
            'blocking_language' => LanguageProfileEnum::FRANCOPHONE,
            'blocking_education' => EducationLevelEnum::LICENCE,
            'blocking_experience' => ExperienceTierEnum::TIER_2,
            'blocking_availability' => AvailabilityEnum::FIFTEEN_DAYS,
            'required_experience' => ExperienceTierEnum::TIER_2,
            'required_education' => EducationLevelEnum::LICENCE,
            'required_availability' => AvailabilityEnum::FIFTEEN_DAYS,
            'status' => JobStatusEnum::PUBLISHED,
            'published_at' => now()->subDays(5),
        ]);

        JobOffer::updateOrCreate(['title' => 'Responsable RH', 'recruiter_profile_id' => $rp3->id], [
            'description' => 'AgenceDig recrute un responsable RH pour gérer son capital humain.',
            'template' => JobTemplateEnum::CADRE,
            'city' => 'Douala',
            'region' => 'Littoral',
            'country' => 'Cameroun',
            'blocking_language' => LanguageProfileEnum::BILINGUE,
            'blocking_education' => EducationLevelEnum::MASTER,
            'blocking_experience' => ExperienceTierEnum::TIER_3,
            'blocking_availability' => AvailabilityEnum::THIRTY_DAYS,
            'required_experience' => ExperienceTierEnum::TIER_3,
            'required_education' => EducationLevelEnum::MASTER,
            'required_availability' => AvailabilityEnum::THIRTY_DAYS,
            'status' => JobStatusEnum::PUBLISHED,
            'published_at' => now()->subDays(10),
        ]);
    }
}
