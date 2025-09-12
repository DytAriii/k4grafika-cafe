<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\status>
 */
class statusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_status' => "available",
        ];
    }

    public function unavailable(): self
    {
        return $this->state([
            'nama_status' => 'unavailable',
        ]);
    }
}
