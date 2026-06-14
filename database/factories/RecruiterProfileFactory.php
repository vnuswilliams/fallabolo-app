<?php

namespace Database\Factories;

use App\Models\RecruiterProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RecruiterProfile>
 */
class RecruiterProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_name' => $this->faker->company(),
            'company_sector' => 'Technologie',
            'phone' => '690000000',
            'city' => 'Douala',
            'country' => 'Cameroun',
        ];
    }
}
