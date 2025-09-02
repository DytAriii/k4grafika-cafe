<?php

namespace Database\Seeders;
use App\Models\users;
use App\Models\roles;
use App\Models\Category;
use App\Models\status;

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
        roles::factory()->create();
        roles::factory()->kasir()->create();
        status::factory()->create();
        status::factory()->unavailable()->create();
        users::factory()->create();
        users::factory()->kasir()->create();
        Category::factory()->create();
        Category::factory()->Drink()->create();
        Category::factory()->Food()->create();
        Category::factory()->Snack()->create();

        $this->call([
        MenuSeeder::class,
    ]);
    }
}
