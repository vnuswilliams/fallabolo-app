<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = [
            // Sectoral Experience
            ['name' => 'Expérience BTP', 'category' => 'sectoriel', 'is_active' => true],
            ['name' => 'Expérience Banque', 'category' => 'sectoriel', 'is_active' => true],
            ['name' => 'Expérience Santé', 'category' => 'sectoriel', 'is_active' => true],
            ['name' => 'Expérience Télécoms', 'category' => 'sectoriel', 'is_active' => true],
            ['name' => 'Expérience Agriculture', 'category' => 'sectoriel', 'is_active' => true],

            // Certifications
            ['name' => 'Certification PMP', 'category' => 'certification', 'is_active' => true],
            ['name' => 'Certification CFA', 'category' => 'certification', 'is_active' => true],
            ['name' => 'Certification AWS', 'category' => 'certification', 'is_active' => true],
            ['name' => 'Certification Sage Paie', 'category' => 'certification', 'is_active' => true],
            ['name' => 'OHSAS 18001', 'category' => 'certification', 'is_active' => true],

            // Contextual Skills
            ['name' => 'Expérience télétravail', 'category' => 'contextuel', 'is_active' => true],
            ['name' => 'Management d\'équipe', 'category' => 'contextuel', 'is_active' => true],
            ['name' => 'Expérience PME', 'category' => 'contextuel', 'is_active' => true],
            ['name' => 'Expérience multinationale', 'category' => 'contextuel', 'is_active' => true],
            ['name' => 'Expérience internationale', 'category' => 'contextuel', 'is_active' => true],

            // Languages
            ['name' => 'Allemand', 'category' => 'langue_supp', 'is_active' => true],
            ['name' => 'Espagnol', 'category' => 'langue_supp', 'is_active' => true],
            ['name' => 'Chinois mandarin', 'category' => 'langue_supp', 'is_active' => true],
            ['name' => 'Portugais', 'category' => 'langue_supp', 'is_active' => true],
        ];

        foreach ($assets as $asset) {
            Asset::create($asset);
        }
    }
}
