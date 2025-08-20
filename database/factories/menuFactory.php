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
        'kategori' => $this->faker->randomElement(['Drink', 'Coffee', 'Snack', 'Food']),
        'gambar' => $this->faker->imageUrl(180, 180, 'food'),
        'status' => $this->faker->randomElement(['On', 'Off']),
    ];
    }
}
