<?php

namespace Database\Factories;

use App\Models\Speaker;
use App\Models\Talk;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpeakerFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        $qualification_count = fake()->numberBetween(2, 5);
        $qualifications = fake()->randomElements(array_keys(Speaker::QUALIFICATIONS), $qualification_count);

        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'bio' => fake()->text(),
            'twitter_handle' => fake()->word(),
            'qualifications' => $qualifications,
        ];
    }

    public function withTalks(int $count = 1): self
    {
        return $this->has(Talk::factory()->count($count), 'talks');
    }
}
