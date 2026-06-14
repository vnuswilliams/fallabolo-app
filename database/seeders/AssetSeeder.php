<?php

namespace Database\Seeders;

use App\Enums\AssetEnum;
use App\Models\Asset;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing assets
        // Asset::truncate();

        foreach (AssetEnum::cases() as $asset) {
            Asset::updateOrCreate(
                [
                    'name' => $asset->value,
                ], [
                    'name' => $asset->value,
                    'category' => $asset->category()->label(),
                    'is_active' => true,
                ]);
        }
    }
}
