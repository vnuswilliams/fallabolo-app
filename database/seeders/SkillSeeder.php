<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Development
            ['name' => 'Laravel', 'category' => 'Development', 'is_active' => true],
            ['name' => 'PHP', 'category' => 'Development', 'is_active' => true],
            ['name' => 'MySQL', 'category' => 'Development', 'is_active' => true],
            ['name' => 'JavaScript', 'category' => 'Development', 'is_active' => true],
            ['name' => 'Vue.js', 'category' => 'Development', 'is_active' => true],
            ['name' => 'React', 'category' => 'Development', 'is_active' => true],
            ['name' => 'Docker', 'category' => 'Development', 'is_active' => true],
            ['name' => 'Git', 'category' => 'Development', 'is_active' => true],
            ['name' => 'Python', 'category' => 'Development', 'is_active' => true],
            ['name' => 'Node.js', 'category' => 'Development', 'is_active' => true],

            // Finance/Accounting
            ['name' => 'Sage Comptabilité', 'category' => 'Finance/Accounting', 'is_active' => true],
            ['name' => 'Sage Paie', 'category' => 'Finance/Accounting', 'is_active' => true],
            ['name' => 'Excel avancé', 'category' => 'Finance/Accounting', 'is_active' => true],
            ['name' => 'OHADA', 'category' => 'Finance/Accounting', 'is_active' => true],
            ['name' => 'Gestion budgétaire', 'category' => 'Finance/Accounting', 'is_active' => true],

            // HR
            ['name' => 'Recrutement', 'category' => 'HR', 'is_active' => true],
            ['name' => 'Formation', 'category' => 'HR', 'is_active' => true],
            ['name' => 'Paie', 'category' => 'HR', 'is_active' => true],
            ['name' => 'SIRH', 'category' => 'HR', 'is_active' => true],
            ['name' => 'Gestion des conflits', 'category' => 'HR', 'is_active' => true],

            // Sales/Marketing
            ['name' => 'Prospection commerciale', 'category' => 'Sales/Marketing', 'is_active' => true],
            ['name' => 'CRM', 'category' => 'Sales/Marketing', 'is_active' => true],
            ['name' => 'Marketing digital', 'category' => 'Sales/Marketing', 'is_active' => true],
            ['name' => 'Community management', 'category' => 'Sales/Marketing', 'is_active' => true],

            // Logistics
            ['name' => 'Gestion des stocks', 'category' => 'Logistics', 'is_active' => true],
            ['name' => 'Transport', 'category' => 'Logistics', 'is_active' => true],
            ['name' => 'Supply chain', 'category' => 'Logistics', 'is_active' => true],
            ['name' => 'Douane', 'category' => 'Logistics', 'is_active' => true],

            // Additional Technical Skills
            ['name' => 'API REST', 'category' => 'Development', 'is_active' => true],
            ['name' => 'PostgreSQL', 'category' => 'Development', 'is_active' => true],
            ['name' => 'AWS', 'category' => 'Development', 'is_active' => true],
            ['name' => 'Kubernetes', 'category' => 'Development', 'is_active' => true],
            ['name' => 'TypeScript', 'category' => 'Development', 'is_active' => true],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
