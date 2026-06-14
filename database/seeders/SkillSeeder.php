<?php

namespace Database\Seeders;

use App\Enums\SkillEnum;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing skills

        foreach (SkillEnum::cases() as $skill) {
            Skill::updateOrCreate(
                [
                    'name' => $skill->value,
                ], [
                    'name' => $skill->value,
                    'category' => $skill->category()->label(),
                    'is_active' => true,
                ]);
        }
    }
}
