<?php

namespace Database\Factories;


use App\Enums\TalkLength;
use App\Enums\TalkStatus;
use App\Models\Speaker;
use Illuminate\Database\Eloquent\Factories\Factory;

class TalkFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'abstract' => fake()->text(),
            'speaker_id' => Speaker::factory(),
            'length' => $this->faker->randomElement(TalkLength::cases()),
            'status' => $this->faker->randomElement(TalkStatus::cases()),
            'is_new' => $this->faker->boolean(),
        ];
    }
}
