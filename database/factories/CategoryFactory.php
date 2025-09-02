<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_Category' => 'Coffee',
        ];
    }

    public function Drink(): self
    {
        return $this->state([
            'nama_Category' => 'Drink',
        ]);
    }

    public function Food(): self
    {
        return $this->state([
            'nama_Category' => 'Food',
        ]);
    }

    public function Snack(): self
    {
        return $this->state([
            'nama_Category' => 'Snack',
        ]);
    }
}
