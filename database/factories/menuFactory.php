<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class menuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'nama' => $this->faker->word(),
        'harga' => $this->faker->randomFloat(2, 10000, 100000),
        'categories_id' => \App\Models\Category::inRandomOrder()->first()->id,
        'gambar' => $this->faker->imageUrl(180, 180, 'food'),
        'status_id' => \App\Models\Status::inRandomOrder()->first()->id,
    ];
    }
}
