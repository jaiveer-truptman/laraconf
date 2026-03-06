<?php

namespace Database\Factories;

use App\Enums\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $startDate = now()->addMonth(9);
        $endDate = $startDate->copy()->addDays(2);

        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => fake()->randomElement([0, 1, 2]),
            'region' => fake()->randomElement(Region::cases()),
            'venue_id' => null,
        ];
    }
}
