<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*$this->call([
                   //UserSeeder::class,
                   //SkillSeeder::class,
                   //AssetSeeder::class,
                   //RecruiterProfileSeeder::class,
                   //CandidateProfileSeeder::class,
                   //JobOfferSeeder::class,
                   //ApplicationSeeder::class,
                  // MatchRhSeeder::class,
               ]);*/
        // seeder in production
        $this->call([
            RoleAndPermissionSeeder::class,
            TestimonialSeeder::class,
            FaqSeeder::class,
            SkillSeeder::class,
            AssetSeeder::class,
        ]);
        User::firstOrCreate([
            'name' => 'vnuswilliams',
            'email' => 'payongvenus@icloud.com',
            'password' => 'password',
            'role' => RoleEnum::ADMIN->value,
            'agree' => true,
            'agreed_at' => now(),
            'updates' => true,
        ]);
    }
}
