<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomElement([1, 2, 3, 4, 5, 6]),
            'title' => fake()->sentence(10),
            'desc' => fake()->paragraph(12),
            'link' => fake()->url(),
            'tags' => fake()->randomElement([
                'game_dev,game',
                'tech,trend',
                'dev,backend,laravel',
                'dev,frontend',
                'tech,news',
                'news',
            ]),
            'approved' => 1
        ];
    }
}
