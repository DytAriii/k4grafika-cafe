<?php

namespace Database\Seeders;

use App\Models\users;
use App\Models\roles;
use App\Models\Category;
use App\Models\status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // seed roles
        roles::factory()->create();
        roles::factory()->kasir()->create();

        // seed status
        status::factory()->create();
        status::factory()->unavailable()->create();

        // seed users dengan aman (tidak duplikat)
        users::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => bcrypt('admin123'),
                'roles_id' => 1,
            ]
        );

        users::updateOrCreate(
            ['username' => 'kasir'],
            [
                'password' => bcrypt('kasir123'),
                'roles_id' => 2,
            ]
        );

        // seed categories
        Category::factory()->create();
        Category::factory()->Drink()->create();
        Category::factory()->Food()->create();
        Category::factory()->Snack()->create();
    }
}
