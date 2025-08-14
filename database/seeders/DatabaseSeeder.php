<?php

namespace Database\Seeders;
use App\Models\users;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        users::factory()->create();
        users::factory()->kasir()->create();
    }
}
