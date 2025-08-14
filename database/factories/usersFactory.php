<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\users>
 */
class usersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ];
    }

    public function kasir(): self
    {
        return $this->state([
            'username' => 'kasir',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir'
        ]);
    }
}
