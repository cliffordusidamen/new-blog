<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => preg_replace('/[^a-z0-9]/i', '-', $title),
            'description' => $this->faker->sentences(mt_rand(4, 6), true),
            'publication_date' => now()->subtract(mt_rand(2, 7) . ' days')->format('Y-m-d H:i:s'),
        ];
    }
}
