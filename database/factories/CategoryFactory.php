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
            'nama_category' => 'Coffee',
        ];
    }

    public function Drink(): self
    {
        return $this->state([
            'nama_category' => 'Non-Coffee',
        ]);
    }

    public function Food(): self
    {
        return $this->state([
            'nama_category' => 'Food',
        ]);
    }

    public function Snack(): self
    {
        return $this->state([
            'nama_category' => 'Snack',
        ]);
    }
}
