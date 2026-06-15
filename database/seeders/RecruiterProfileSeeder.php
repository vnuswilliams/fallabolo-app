<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\RecruiterProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RecruiterProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users by email
        $recruteur1 = User::where('email', 'recruteur1@test.cm')->first();
        $recruteur2 = User::where('email', 'recruteur2@test.cm')->first();
        $recruteur3 = User::where('email', 'recruteur3@test.cm')->first();
        $benevole = User::where('email', 'benevole@test.cm')->first();

        // Create main recruiter profiles
        if ($recruteur1) {
            RecruiterProfile::create([
                'user_id' => $recruteur1->id,
                'company_name' => 'TechCorp',
                'company_sector' => 'IT/Technology',
                'phone' => '+237671234567',
                'city' => 'Douala',
                'region' => 'Littoral',
                'country' => 'Cameroon',
                'is_managed_by' => null,
                'is_suspended' => false,
            ]);
        }

        if ($recruteur2) {
            RecruiterProfile::create([
                'user_id' => $recruteur2->id,
                'company_name' => 'FinGroup',
                'company_sector' => 'Finance',
                'phone' => '+237672234567',
                'city' => 'Yaoundé',
                'region' => 'Centre',
                'country' => 'Cameroon',
                'is_managed_by' => null,
                'is_suspended' => false,
            ]);
        }

        if ($recruteur3) {
            RecruiterProfile::create([
                'user_id' => $recruteur3->id,
                'company_name' => 'AgenceDig',
                'company_sector' => 'Marketing/Digital',
                'phone' => '+237673234567',
                'city' => 'Douala',
                'region' => 'Littoral',
                'country' => 'Cameroon',
                'is_managed_by' => null,
                'is_suspended' => false,
            ]);
        }

        // Create managed profiles for the volunteer by creating additional recruiter users
        if ($benevole) {
            // Create first managed recruiter user
            $managedRecruiter1 = User::create([
                'name' => 'Manager BuildCorp',
                'email' => 'buildcorp@test.cm',
                'password' => Hash::make('password'),
                'role' => RoleEnum::RECRUITER,
            ]);
            $managedRecruiter1->assignRole(RoleEnum::RECRUITER->value);

            RecruiterProfile::create([
                'user_id' => $managedRecruiter1->id,
                'company_name' => 'BuildCorp',
                'company_sector' => 'BTP',
                'phone' => '+237674234567',
                'city' => 'Douala',
                'region' => 'Littoral',
                'country' => 'Cameroon',
                'is_managed_by' => $benevole->id,
                'is_suspended' => false,
            ]);

            // Create second managed recruiter user
            $managedRecruiter2 = User::create([
                'name' => 'Manager HealthPlus',
                'email' => 'healthplus@test.cm',
                'password' => Hash::make('password'),
                'role' => RoleEnum::RECRUITER,
            ]);
            $managedRecruiter2->assignRole(RoleEnum::RECRUITER->value);

            RecruiterProfile::create([
                'user_id' => $managedRecruiter2->id,
                'company_name' => 'HealthPlus',
                'company_sector' => 'Santé',
                'phone' => '+237675234567',
                'city' => 'Yaoundé',
                'region' => 'Centre',
                'country' => 'Cameroon',
                'is_managed_by' => $benevole->id,
                'is_suspended' => false,
            ]);
        }
    }
}
