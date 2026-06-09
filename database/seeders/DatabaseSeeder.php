<?php

namespace Database\Seeders;

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
       /* $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            SkillSeeder::class,
            AssetSeeder::class,
            RecruiterProfileSeeder::class,
            CandidateProfileSeeder::class,
            JobOfferSeeder::class,
            ApplicationSeeder::class,
            MatchRhSeeder::class,
        ]);*/
        $this->call(TestimonialSeeder::class);
    }
}
