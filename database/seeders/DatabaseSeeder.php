<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Conference;
use App\Models\Speaker;
use App\Models\User;
use App\Models\Venue;
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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $venue = Venue::factory()->create(['region' => 'IN']);

        Conference::factory()
            ->has(Attendee::factory()->count(10))
            ->for($venue)
            ->create([
                'name' => 'Laracon India 2026',
                'region' => 'IN',
            ]);

        Speaker::factory()
            ->count(10)
            ->withTalks(fake()->numberBetween(1, 3))
            ->create();
    }
}
